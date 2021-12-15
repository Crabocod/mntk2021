<?php namespace App\Controllers\Pages\Editor;

use App\Controllers\Pages\Editor\BaseController;
use App\Entities\Groups\Group;
use App\Entities\Groups\GroupValid;
use App\Entities\Groups\GroupView;
use App\Entities\UserGroup\UserGroupView;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\UserGroup;

class Groups extends BaseController
{
    public function index($conference_id)
    {
        $groupsModel = new \App\Models\Groups();
        $userGroupsModel = new UserGroup();

        $groups = $groupsModel->where('conference_id', $conference_id)->find();

        $userGroupsModel->select('user_group.*');
        $userGroupsModel->select('u.surname as user_surname');
        $userGroupsModel->select('u.name as user_name');
        $userGroupsModel->select('u.email as user_email');
        $userGroupsModel->select('g.title as group_title');
        $userGroupsModel->join('groups g', 'g.id=user_group.group_id');
        $userGroupsModel->join('users u', 'u.id=user_group.user_id');
        $userGroupsModel->where('g.conference_id', $conference_id);
        $user_groups = $userGroupsModel->find();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['groups'] = GroupView::getEditorTableRows($groups);
        $data['user_groups'] = UserGroupView::getEditorTableRows($user_groups);

        echo view('pages/editor/groups', $data);
    }

    public function add($conference_id)
    {
        try {
            $groupsModel = new \App\Models\Groups();
            $group = new Group();

            // Валидация
            $post = $this->request->getPost();
            GroupValid::add($post);

            // Поиск дубликата
            $groupsModel->where('title', $post['title']);
            $groupsModel->where('conference_id', $this->conference->id);
            if(!empty($groupsModel->first()))
                throw new \Exception(ErrorMessages::get(1903));

            // Сохранение
            $group->title = $post['title'];
            $group->conference_id = $this->conference->id;
            $groupsModel->save($group);
            if (!isset($post['id']))
                $group->id = $groupsModel->getInsertID();

            Output::ok([
                'html' => GroupView::getEditorTableRow($group->toArray()),
                'message' => SuccessMessages::get(1900)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function update($conference_id)
    {
        try {
            $groupsModel = new \App\Models\Groups();
            $group = new Group();

            // Валидация
            $post = $this->request->getPost();
            GroupValid::update($post);

            // Поиск дубликата
            $groupsModel->where('title', $post['title']);
            $groupsModel->where('conference_id', $this->conference->id);
            $groupsModel->where('id!=', $post['id']);
            if(!empty($groupsModel->first()))
                throw new \Exception(ErrorMessages::get(1903));

            // Сохранение
            $group->id = $post['id'];
            $group->title = $post['title'];
            $groupsModel->save($group);

            Output::ok([
                'html' => GroupView::getEditorTableRow($group->toArray()),
                'message' => SuccessMessages::get(1900)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function delete($conference_id)
    {
        try {
            $groupsModel = new \App\Models\Groups();
            $userGroupModel = new UserGroup();
            $usersModel = new \App\Models\Users();

            // Валидация
            $post = $this->request->getPost();

            // Поиск данных в таблице user_group
            $userGroupModel->where('group_id', $post['id']);
            $userGroups = $userGroupModel->find();

            // Устанавливаем дату обновления пользователя чтобы синхронизировать с моб. прил.
            $updateUsers = Array();
            foreach ($userGroups as $userGroup) {
                $updateUsers[] = [
                    'id' => $userGroup['user_id'],
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            if(!empty($updateUsers))
                $usersModel->updateBatch($updateUsers, 'id');

            // Удаляем всех участников данной группы
            $userGroupModel->where('group_id', $post['id'])->delete();

            // Удаление
            $groupsModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(1901)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function distribute($conference_id)
    {
        try {
            $groupsModel = new \App\Models\Groups();
            $usersModel = new \App\Models\Users();
            $userGroupModel = new UserGroup();

            $groupsModel->select('groups.*');
            $groupsModel->select('(SELECT COUNT(*) FROM user_group ug WHERE ug.group_id = groups.id) as count_users');
            $groupsModel->where('conference_id', $conference_id);
            $groups = $groupsModel->find();

            if(empty($groups))
                throw new \Exception(ErrorMessages::get(1900));

            $groupsIds = '';
            foreach ($groups as $group) {
                $groupsIds .= (empty($groupsIds)) ? $group->id : ','.$group->id;
            }

            $usersModel->where('(SELECT COUNT(*) FROM user_conferences uc WHERE uc.user_id=users.id AND uc.conference_id='.$conference_id.')>0');
            $usersModel->where('(SELECT COUNT(*) FROM user_group ug WHERE ug.user_id=users.id AND ug.group_id IN ('.$groupsIds.'))=0');
            $usersModel->where('role_id', 3);
            $users = $usersModel->find();

            if(empty($users))
                throw new \Exception(ErrorMessages::get(1902));

            $insertUserGroup = Array();
            $updateUsers = Array();

            foreach ($users as $user) {
                $group = $this->getSmallestGroup($groups);
                if(!isset($group->count_users))
                    $group->count_users = 0;
                $group->count_users ++;

                $insertUserGroup[] = [
                    'user_id' => $user->id,
                    'group_id' => $group->id
                ];

                $updateUsers[] = [
                    'id' => $user->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }

            // Распределяем участников по группам
            $userGroupModel->insertBatch($insertUserGroup);

            // Устанавливаем дату обновления пользователя чтобы синхронизировать с моб. прил.
            $usersModel->updateBatch($updateUsers, 'id');

            Output::ok([
                'message' => SuccessMessages::get(1902)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    private function getSmallestGroup(array &$groups) {
        $smallestGroup = null;
        foreach ($groups as &$group) {
            if(empty($smallestGroup)) {
                $smallestGroup = $group;
                continue;
            }
            if($group->count_users < $smallestGroup->count_users)
                $smallestGroup = $group;
        }
        return $smallestGroup;
    }

    public function getMembersRows($conference_id)
    {
        try {
            $userGroupsModel = new UserGroup();

            $userGroupsModel->select('user_group.*');
            $userGroupsModel->select('u.surname as user_surname');
            $userGroupsModel->select('u.name as user_name');
            $userGroupsModel->select('u.email as user_email');
            $userGroupsModel->select('g.title as group_title');
            $userGroupsModel->join('groups g', 'g.id=user_group.group_id');
            $userGroupsModel->join('users u', 'u.id=user_group.user_id');
            $userGroupsModel->where('g.conference_id', $conference_id);
            $user_groups = $userGroupsModel->find();

            $html = UserGroupView::getEditorTableHead();
            $html .= UserGroupView::getEditorTableRows($user_groups);

            Output::ok([
                'html' => $html
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}

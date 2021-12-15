<?php namespace App\Controllers\Pages\OldConference;

use App\Entities\MemberGroups\MemberGroupValid;
use App\Entities\MemberGroups\MemberGroupView;
use App\Entities\Users\UserSession;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Models\MemberGroups;
use App\Models\MemberGroupUsers;

class Member extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();
        $memberGroupsModel = new MemberGroups();

        $conference = $this->conference;

        $user = UserSession::getUser();
        $data['user_surname'] = $user->surname;
        $data['user_name'] = $user->name;

        $memberGroupsModel->select('member_groups.*');
        $memberGroupsModel->select('mgu.user_id as user_id');
        $memberGroupsModel->join('member_group_user mgu', '(mgu.member_group_id=member_groups.id and mgu.user_id=' . $user->id . ')', 'left');
        $memberGroupsModel->where('conference_id', $conference->id);
        $memberGroupsModel->orderBy('id', 'asc');
        $memberGroups = $memberGroupsModel->find();

        $data['conferences'] = $conference;
        $data['member_groups'] = MemberGroupView::getCards($memberGroups);
        echo view('pages/conference/member', $data);
    }

    public function signing($url_segment)
    {
        try {
            $confModel = new \App\Models\Conferences();
            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();

            $conference = $confModel->where('url_segment', $url_segment)->first();

            $memberGroupModel = new MemberGroups();
            $memberGroupUserModel = new MemberGroupUsers();

            // Валидация
            $post = $this->request->getPost();
            MemberGroupValid::add($post);

            $user = UserSession::getUser();

            $memberGroup = $memberGroupModel->find($post['member_group_id']);
            if(empty($memberGroup))
                throw new \Exception(ErrorMessages::get(401));

            // Проверка на дублирование
            $memberGroupUserModel->where('member_group_id', $post['member_group_id']);
            $memberGroupUserModel->where('user_id', $user->id);
            $result = $memberGroupUserModel->first();
            if(!empty($result))
                throw new \Exception(ErrorMessages::get(400));

            // Добавление пользователя в группу
            $post['user_id'] = $user->id;
            $memberGroupUserModel->insert($post);

            $data['conference_title'] = $conference->title;
            $data['user_name'] = $user->name;
            $data['user_surname'] = $user->surname;
            $data['member_group_name'] = $memberGroup->text;

            $mailer->user_email = $conference->wtb_email;
            $mailer->text = view('emails/user_signing_group', $data);
            $mailer->send_date = date("Y-m-d H:i:s");
            $mailer->status = 0;
            $mailer->subject = 'Хочу стать участником';
            $mailerModel->save($mailer);

            $html = MemberGroupView::getCardButton(true);
            Output::ok(['html' => $html]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}
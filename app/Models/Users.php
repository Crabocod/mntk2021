<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Users\UserRole;
use App\Entities\Roles\RoleStorage;
use App\Entities\Users\UserConferences;
use App\Models\UserConferences as UserConferencesModel;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Users\User';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'full_name', 'section_id', 'phone', 'email', 'password', 'password_recovery', 'role_id', 'og_title', 'email_confirmed', 'user_sync_at', 'is_registered'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $afterFind = ['getRolePermissions', 'setRoleTitle', 'getConferences', 'getSync', 'getGroups'];
    protected $withPermissions = false;
    protected $withConferences = false;
    protected $withSync = false;
    protected $withGroups = false;

    public function withPermissions()
    {
        $this->withPermissions = true;
        return $this;
    }

    public function withConferences()
    {
        $this->withConferences = true;
        return $this;
    }

    public function withSync()
    {
        $this->withSync = true;
        return $this;
    }

    public function withGroups()
    {
        $this->withGroups = true;
        return $this;
    }

    /**
     * Выводит для пользователя его права
     *
     * @param array $data
     * @return array
     */
    protected function getRolePermissions($data = [])
    {
        if (isset($data['data']) and $this->withPermissions === true) {
            $user = $data['data'];
            $rolePerm = new RolePerm();
            $permissions = $rolePerm->getRolePermissions($user->role_id);
            $user->setRoleOneTime(UserRole::setRolePerms($permissions));
        }
        return $data;
    }

    public function getConferences($data = [])
    {
        if (isset($data['data']) and $this->withConferences === true) {
            if (is_array($data['data'])) {
                foreach ($data['data'] as $user) {
                    $userConfModel = new UserConferencesModel();
                    $userConfModel->select('c.url_segment');
                    $userConfModel->join('conferences c', 'c.id=conference_id', 'left');
                    $userConfModel->where('user_id', $user->id);
                    $userConfs = $userConfModel->findAll();
                    $userConfUrlSegments = array();
                    foreach ($userConfs as $conf) {
                        $userConfUrlSegments[] = $conf['url_segment'];
                    }
                    $user->setConferencesOneTime(UserConferences::setConferences($userConfUrlSegments));
                }
            } else {
                $user = $data['data'];
                $userConfModel = new UserConferencesModel();
                $userConfModel->select('c.url_segment');
                $userConfModel->join('conferences c', 'c.id=conference_id', 'left');
                $userConfModel->where('user_id', $user->id);
                $userConfs = $userConfModel->findAll();
                $userConfUrlSegments = array();
                foreach ($userConfs as $conf) {
                    $userConfUrlSegments[] = $conf['url_segment'];
                }
                $user->setConferencesOneTime(UserConferences::setConferences($userConfUrlSegments));
            }
        }
        return $data;
    }

    /**
     * Добавляет название роли.
     * В зависимости от метода поиска параметры и данные приходят разные.
     * https://codeigniter.com/user_guide/models/model.html
     *
     * @param array $data
     * @param null $limit
     * @return array
     */
    protected function setRoleTitle(&$idOrArray = null, &$arrayOrLimit = null, $offset = null)
    {
        $roles = RoleStorage::get();
        // find()
        if (is_int($idOrArray) and is_object($arrayOrLimit)) {
            if (is_object($arrayOrLimit['data']) && isset($roles[$arrayOrLimit['data']->role_id]))
                $arrayOrLimit['data']->role_title = $roles[$arrayOrLimit['data']->role_id]['title'];
            elseif(is_array($arrayOrLimit['data']) && isset($roles[$arrayOrLimit['data']['role_id']]))
                $arrayOrLimit['data']['role_title'] = $roles[$arrayOrLimit['data']['role_id']]['title'];
            return $arrayOrLimit;
        }
        // findAll()
        if (is_array($idOrArray['data']) and !empty($idOrArray['data'][0])) {
            foreach ($idOrArray['data'] as $user) {
                if (is_object($user) && isset($roles[$user->role_id]))
                    $user->role_title = $roles[$user->role_id]['title'];
                elseif(is_array($user) && isset($roles[$user['role_id']]))
                    $user['role_title'] = $roles[$user['role_id']]['title'];
            }
        }
        // first()
        if (is_object($idOrArray['data']) and empty($arrayOrLimit)) {
            if (is_object($idOrArray['data']) && isset($roles[$idOrArray['data']->role_id]))
                $idOrArray['data']->role_title = $roles[$idOrArray['data']->role_id]['title'];
            elseif(is_array($idOrArray['data']) && isset($roles[$idOrArray['data']['role_id']]))
                $idOrArray['data']['role_title'] = $roles[$idOrArray['data']['role_id']]['title'];
        }
        return $idOrArray;
    }

    public function getSync($data = [])
    {
        if (isset($data['data']) and $this->withSync === true) {
            if (is_array($data['data'])) {
                foreach ($data['data'] as $user) {
                    $userSyncModel = new UserSync();
                    $userSyncModel->select('c.url_segment');
                    $userSyncModel->join('conferences c', 'c.id=conference_id', 'left');
                    $userSyncModel->where('user_id', $user->id);
                    $userConfs = $userSyncModel->find();
                    $userSync = array();
                    foreach ($userConfs as $conf) {
                        $userSync[] = $conf['url_segment'];
                    }
                    $user->setSyncOneTime(\App\Entities\Users\UserSync::setConferences($userSync));
                }
            } else {
                $user = $data['data'];
                $userSyncModel = new UserSync();
                $userSyncModel->select('c.url_segment');
                $userSyncModel->join('conferences c', 'c.id=conference_id', 'left');
                $userSyncModel->where('user_id', $user->id);
                $userConfs = $userSyncModel->find();
                $userSync = array();
                foreach ($userConfs as $conf) {
                    $userSync[] = $conf['url_segment'];
                }
                $user->setSyncOneTime(\App\Entities\Users\UserSync::setConferences($userSync));
            }
        }
        return $data;
    }

    public function getGroups($data = [])
    {
        if (isset($data['data']) and $this->withGroups === true) {
            if (is_array($data['data'])) {
                foreach ($data['data'] as $user) {
                    $groupsModel = new Groups();
                    $groupsModel->select('groups.*');
                    $groupsModel->join('user_group ug', 'ug.group_id=groups.id', 'left');
                    $groupsModel->where('ug.user_id', $user->id);
                    $user->groups = $groupsModel->find();
                }
            } else {
                $user = $data['data'];
                $groupsModel = new Groups();
                $groupsModel->select('groups.*');
                $groupsModel->join('user_group ug', 'ug.group_id=groups.id', 'left');
                $groupsModel->where('ug.user_id', $user->id);
                $user->groups = $groupsModel->find();
            }
        }
        return $data;
    }
}

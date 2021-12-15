<?php namespace App\Controllers\Pages\Editor;

use App\Entities\Conferences\ConferenceValid;
use App\Entities\MemberGroups\MemberGroupValid;
use App\Entities\MemberGroups\MemberGroupView;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Conferences;

class Partner extends BaseController
{
    public function index($conference_id)
    {
        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();

        $memberModel = new \App\Models\MemberGroups();
        $memberGroups = $memberModel->where('conference_id', $conference_id)->findAll();

        $data['member_groups'] = \App\Entities\MemberGroups\MemberGroupView::getEditorCards($memberGroups);

        echo view('pages/editor/partner', $data);
    }

    public function editWtb()
    {
        try {
            $confereceModel = new Conferences();

            // Валидация
            $post = $this->request->getPost();
            ConferenceValid::saveWtbItems($post);

            // Сохранение
            $this->conference->wtb_text = $post['wtb_text'];
            $this->conference->wtb_email = $post['wtb_email'];
            if ($this->conference->hasChanged())
                $confereceModel->save($this->conference);

            Output::ok(['message' => SuccessMessages::get(305)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveMemberGroup($conference_id)
    {
        try {
            $memberGroupModel = new \App\Models\MemberGroups();
            $memberGroup = new \App\Entities\MemberGroups\MemberGroup();

            $file = $this->request->getFile('img_link');

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            MemberGroupValid::save($post, $this->request);

            // Сохранение
            if(!empty($post['id']) and !empty($post['deleted_icon']))
                $memberGroup->img = 'img/icon-demo.svg';
            if (isset($post['id'])) {
                $memberGroup->id = $post['id'];
                if ($file !== null && $file->isFile() !== false)
                    $memberGroup->saveIcon($file);
            }else{
                $memberGroup->saveIcon($file);
            }
            $memberGroup->conference_id = $this->conference->id;
            $memberGroup->text = $post['text'];

            if ($memberGroup->hasChanged())
                $memberGroupModel->save($memberGroup);

            $memberGroup->id = $memberGroupModel->getInsertID();

            $html = '';
            if (!isset($post['id'])){
                $html = MemberGroupView::getEditorCard($memberGroup->toArray());
            }

            Output::ok([
                'html' => $html,
                'message' => SuccessMessages::get(400)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
    public function deleteMemberGroup()
    {
        try {
            $memberGroupModel = new \App\Models\MemberGroups();
            $post = $this->request->getPost();
            $memberGroupModel->where('id', $post['id'])->delete();

            Output::ok([
                'message' => SuccessMessages::get(401)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

}

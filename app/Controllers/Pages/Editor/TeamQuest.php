<?php namespace App\Controllers\Pages\Editor;

use App\Entities\TeamQuests\TeamQuestValid;
use App\Entities\TeamQuests\TeamQuestView;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;

class TeamQuest extends BaseController
{
    public function index($conference_id)
    {
        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();

        $teamQuestModel = new \App\Models\TeamQuests();
        $teamQuests = $teamQuestModel->where('conference_id', $conference_id)->findAll();

        $data['team_quests'] = \App\Entities\TeamQuests\TeamQuestView::getEditorCards($teamQuests);
        echo view('pages/editor/team_quest', $data);
    }

    public function update($conference_id)
    {
        try {
            $post = $this->request->getPost();
            $teamQuestModel = new \App\Models\TeamQuests();
            $teamQuest = new \App\Entities\TeamQuests\TeamQuest();

            TeamQuestValid::save($post);

            if (isset($post['id'])){
                $teamQuest->id = $post['id'];
            }
            $teamQuest->title = $post['title'];
            $teamQuest->points = $post['points'];
            $teamQuest->conference_id = $conference_id;
            $teamQuestModel->save($teamQuest);

            $html = '';
            if (!isset($post['id'])){
                $teamQuest->id = $teamQuestModel->getInsertID();
                $html = TeamQuestView::getEditorCard($teamQuest->toArray());
            }
            $message = SuccessMessages::get(1400);

            Output::ok(['message' => $message, 'html' => $html]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        $post = $this->request->getPost();

        $teamQuestModel = new \App\Models\TeamQuests();
        $teamQuestModel->where('id', $post['id'])->delete();
        Output::ok([]);
    }

}

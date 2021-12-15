<?php namespace App\Controllers\Pages\Editor;


use App\Entities\Conferences\ConferenceValid;
use App\Entities\Events\EventValid;
use App\Entities\Files\File;
use App\Entities\Files\FileValid;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Conferences;

class OgInfo extends BaseController
{
    public function index()
    {
        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        echo view('pages/editor/og_info', $data);
    }

    public function saveOg($conference_id)
    {
        try {
            $confereceModel = new Conferences();

            $file = $this->request->getFile('og_logo');
            $fileName = $file->getName();
            // Валидация
            $post = $this->request->getPost();
            ConferenceValid::saveOgItems($post, $this->request);

            // Сохранение
            $this->conference->saveOgLogo($file);
            $this->conference->og_logo_name = $fileName;
            $this->conference->og_text = $post['og_text'];
            $this->conference->og_video = $post['og_video'];
            if ($this->conference->hasChanged())
                $confereceModel->save($this->conference);

            Output::ok(['message' => SuccessMessages::get(303)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}

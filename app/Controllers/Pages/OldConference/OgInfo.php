<?php namespace App\Controllers\Pages\OldConference;

use App\Controllers\Pages\BaseController;

class OgInfo extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conferences'] = $confModel->where('url_segment', $url_segment)->first();
        echo view('pages/conference/og_info', $data);
    }
}
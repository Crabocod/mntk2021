<?php namespace App\Controllers\Pages\Conference;

use App\Libraries\Output;

class Programs extends BaseController
{
    public function index($id)
    {
        $buisnessProgramsModel = new \App\Models\BusinessPrograms();

        $buisnessProgram = $buisnessProgramsModel->where('id', $id)->where('is_published', '1')->first();
        if(empty($buisnessProgram))
            Output::output(view('errors/html/error_404'));

        $buisnessProgram->date = date('d.m.Y', strtotime($buisnessProgram->date));

        $data['program'] = $buisnessProgram->toRawArray();

        echo view('pages/conference/programs', $data);
    }
}
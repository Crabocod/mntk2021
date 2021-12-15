<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Libraries\Output;

class ProgramsAbout extends BaseController
{
    public function index($id)
    {
        $programModel = new \App\Models\BusinessPrograms();
        $programModel->select('business_programs.*');
        $programModel->select('f.title as file_title');
        $programModel->join('files f', 'f.id = business_programs.photo_file_id', 'left');
        $programModel->where('business_programs.deleted_at IS NULL');
        $program = $programModel->where('business_programs.id', $id)->first();


        if(empty($program))
            Output::output(view('errors/html/error_404'));

        $program->date = date('Y-m-d', strtotime($program->date));
        $data['program_info'] = $program->toRawArray();
        echo view('pages/admin/programs-about', $data);
    }
}
<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\Acquaintances\AcquaintancesValid;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\AcquaintanceModel;

class Acquaintance extends BaseController
{
    public function index()
    {
        $znakomstvoModel = new \App\Models\AcquaintanceModel();
        $feedBackModel = new \App\Models\AcquaintanceFeedback();

        $feedBackModel->select('acquaintance_feedback.*');
        $feedBackModel->select('u.full_name as name');
        $feedBackModel->join('users u', 'u.id = acquaintance_feedback.user_id', 'left');
        $feedBack = $feedBackModel->findAll();

        $znakomstvo = $znakomstvoModel->first();

        $data['znakomstvo'] = $znakomstvo->toRawArray();
        $data['feedBack'] = $feedBack;

        echo view('pages/admin/acquaintance', $data);
    }

    public function update()
    {
        try {
            helper('string');
            $acquaintanceModel = new \App\Models\AcquaintanceModel();
            $acquaintance = new \App\Entities\Acquaintances\Acquaintance();

            $post = $this->request->getPost();
            AcquaintancesValid::upadte($post);

            $acquaintance->fill($post);
            $acquaintance->id = 1;
            $acquaintanceModel->save($acquaintance);

            Output::ok([
                'message' => SuccessMessages::get(2300)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

}
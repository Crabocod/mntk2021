<?php namespace App\Models;

use CodeIgniter\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Settings\Setting';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'name', 'value'];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
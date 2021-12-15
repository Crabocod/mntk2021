<?php namespace App\Models;

use CodeIgniter\Model;

class Mailer extends Model
{
    protected $table = 'mailer';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Mailers\Mailer';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'user_email', 'text', 'subject', 'send_date', 'status'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
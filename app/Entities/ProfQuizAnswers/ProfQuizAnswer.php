<?php namespace App\Entities\ProfQuizAnswers;

use CodeIgniter\Entity;

class ProfQuizAnswer extends Entity
{
    private $fileUploadFolder = 'uploads';

    public function saveFile(\CodeIgniter\HTTP\Files\UploadedFile $file = null)
    {
        if ($file === null or $file->isFile() === false)
            return false;

        $newName = $file->getRandomName();
        $clientName = $file->getClientName();
        $path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $file->move(WRITEPATH . $path, $newName);
        $this->file = $path . '/' . $newName;
        $this->file_name = $clientName;

        return true;
    }
}
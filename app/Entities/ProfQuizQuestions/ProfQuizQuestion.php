<?php namespace App\Entities\ProfQuizQuestions;

use CodeIgniter\Entity;

class ProfQuizQuestion extends Entity
{
    private $fileUploadFolder = 'uploads';

    public function saveImage(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null or $file->isFile() === false)
            return false;

        $newName = $file->getRandomName();
        $path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $file->move(WRITEPATH . $path, $newName);
        $this->img = $path . '/' . $newName;

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $this->img);
        $image->resize(600, 300, true, 'width');
        $image->save(WRITEPATH . $this->img);

        return true;
    }

    public function saveAudio(\CodeIgniter\HTTP\Files\UploadedFile $file = null)
    {
        if ($file === null or $file->isFile() === false)
            return false;

        $newName = $file->getRandomName();
        $clientName = $file->getClientName();
        $path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $file->move(WRITEPATH . $path, $newName);
        $this->audio = $path . '/' . $newName;
        $this->audio_title = $clientName;

        return true;
    }

    public function saveFile(\CodeIgniter\HTTP\Files\UploadedFile $file = null)
    {
        if ($file === null or $file->isFile() === false)
            return false;

        $newName = $file->getRandomName();
        $clientName = $file->getClientName();
        $path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $file->move(WRITEPATH . $path, $newName);
        $this->file = $path . '/' . $newName;
        $this->file_title = $clientName;

        return true;
    }
}
<?php namespace App\Entities\RadioArchives;

use CodeIgniter\Entity;

class RadioArchive extends Entity
{
    private $fileUploadFolder = 'uploads';

    public function saveAudioFile(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        $newName = $file->getRandomName();
        $path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $file->move(WRITEPATH . $path, $newName);
        $this->audio =  $path . '/' . $newName;
        return true;
    }
}
<?php namespace App\Entities\ArchiveFiles;

use CodeIgniter\Entity;

class ArchiveFile extends Entity
{
    private $fileUploadFolder = 'uploads';
    private $fileDeletedFolder = 'deleted';

    public function saveFile(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;
        $this->title = $file->getClientName();

        $newName = $file->getRandomName();
        $path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $file->move(WRITEPATH . $path, $newName);
        $this->link =  $path . '/' . $newName;
        return true;
    }

    public function deleteFile(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        $path = $this->fileDeletedFolder . '/' . date('Y-m/Y-m-d');
        if (!file_exists(WRITEPATH . $path))
            mkdir(WRITEPATH . $path, 0777, true);
        $result = rename($file->getRealPath(), WRITEPATH . $path . '/' . $file->getFilename());
        if ($result === false)
            return $result;
        $this->link = '';
        return $path . '/' . $file->getFilename();
    }
}
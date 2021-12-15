<?php namespace App\Entities\Events;

use App\Entities\FileExts\FileExtsStorage;
use CodeIgniter\Entity;

class Event extends Entity
{
    private $fileUploadFolder = 'uploads';
    private $fileDeletedFolder = 'deleted';

    public function saveEventPreview(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        if ($file->isFile() === false) return false;

        $this->preview_img = $this->saveFile($file);

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $this->preview_img);
        $image->resize(165, 114, true, 'width');
        $image->save(WRITEPATH . $this->preview_img);
        return true;
    }

    private function saveFile(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        $newName = $file->getRandomName();
        $path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $file->move(WRITEPATH . $path, $newName);
        return $path . '/' . $newName;
    }

    private function deleteFile(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;


        $path = $this->fileDeletedFolder . '/' . date('Y-m/Y-m-d');
        if (!file_exists(WRITEPATH . $path))
            mkdir(WRITEPATH . $path, 0777, true);
        $result = rename($file->getRealPath(), WRITEPATH . $path . '/' . $file->getFilename());
        if ($result === false)
            return $result;
        return $path . '/' . $file->getFilename();
    }
}

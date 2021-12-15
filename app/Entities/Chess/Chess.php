<?php namespace App\Entities\Chess;

use CodeIgniter\Entity;

class Chess extends Entity
{
    private $fileUploadFolder = 'uploads';
    private $fileDeletedFolder = 'deleted';

    public function saveIcon(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null or $file->isFile() === false)
            return false;

        $this->img_link = $this->saveFile($file);

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $this->img_link);
        $image->resize(100, 50, true, 'height');
        $image->save(WRITEPATH . $this->img_link);
        return true;
    }

    public function deleteIcon(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        $this->deleteFile($file);
        $this->img_link = '';
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
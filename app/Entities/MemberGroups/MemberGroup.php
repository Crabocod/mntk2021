<?php namespace App\Entities\MemberGroups;

use CodeIgniter\Entity;

class MemberGroup extends Entity
{
    private $fileUploadFolder = 'uploads';
    public function saveIcon(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null or $file->isFile() === false) {
            $this->img = 'img/icon-demo.svg';
            return true;
        }

        $this->img = $this->saveFile($file);

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $this->img);
        $image->resize(70, 120, true, 'height');
        $image->save(WRITEPATH . $this->img);
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
}
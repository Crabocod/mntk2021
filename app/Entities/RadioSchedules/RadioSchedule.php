<?php namespace App\Entities\RadioSchedules;

use CodeIgniter\Entity;

class RadioSchedule extends Entity
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
}
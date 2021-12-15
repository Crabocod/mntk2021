<?php namespace App\Entities\SectionImages;

use CodeIgniter\Entity;

class SectionImage extends Entity
{
    private $fileUploadFolder = 'uploads';
    private $fileDeletedFolder = 'deleted';

    public function saveImage(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null or $file->isFile() === false)
            return false;

        // Данные
        $file_ext = $file->getExtension();
        $file_path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $origin_file_name = $file->getRandomName();
        $this->img_orig = $file_path . '/' . $origin_file_name;
        $this->img_min = $file_path . '/' . $file->getBasename('.' . $file_ext) . '_min.' . $file_ext;

        // Сохранение оригинала
        $file->move(WRITEPATH . $file_path, $origin_file_name);

        // Ресайз и сохранение миниатюры
        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $this->img_orig);
        $image->fit(600, 400, 'center');
        $image->save(WRITEPATH . $this->img_min, 100);

        return true;
    }
}
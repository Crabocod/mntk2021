<?php namespace App\Entities\Files;

use CodeIgniter\Entity;
use App\Entities\FileExts\FileExtsStorage;

class File extends Entity
{
    public $image_min_link = null;

    public function save(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        $newName = $file->getRandomName();
        $path = 'uploads/' . date('Y-m/Y-m-d');
        if(!file_exists(WRITEPATH . $path))
            mkdir(WRITEPATH . $path, 0777, true);
        $file->move(WRITEPATH . $path, $newName);
        $file_ext = FileExtsStorage::getByExtension($file->getClientExtension());
        $this->ext_id = $file_ext['id'];
        $this->title = $file->getClientName();
        $this->link = $path . '/' . $newName;
        $this->size = $file->getSize();
        return true;
    }

    public function delete(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        $path = 'deleted/' . date('Y-m/Y-m-d');
        if(!file_exists(WRITEPATH . $path))
            mkdir(WRITEPATH . $path, 0777, true);
        $result = rename($file->getRealPath(), WRITEPATH . $path . '/' . $file->getFilename());
        if($result === false)
            return $result;
        $file_ext = FileExtsStorage::getByExtension($file->getExtension());
        $this->ext_id = $file_ext['id'];
        $this->link = $path . '/' . $file->getFilename();
        return true;
    }

    /**
     * Обработка изображений
     *
     * @param string $link
     * @return bool
     */
    public function handleImage(string $link)
    {
        if (empty($link) || !file_exists(WRITEPATH . $link))
            return false;

        $file = new \CodeIgniter\Files\File($link);

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $link);
        $image->getFile();
        $info = $image->getProperties(true);

        if($info['width'] > 1920) {
            $image = \Config\Services::image();
            $image->withFile(WRITEPATH . $link);
            $image->resize(1920, 0, true, 'width');
            $image->save(WRITEPATH . $link, 100);
        }

        if($info['width'] > 400) {
            $newName = $file->getRandomName();
            $path = 'uploads/' . date('Y-m/Y-m-d');

            $this->image_min_link = $path . '/' . $newName;

            $image = \Config\Services::image();
            $image->withFile(WRITEPATH . $file->getPathname());
            $image->resize(400, 400, true, 'width');
            $image->save(WRITEPATH . $this->image_min_link);
        }

        return true;
    }
}
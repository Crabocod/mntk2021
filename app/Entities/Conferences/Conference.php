<?php namespace App\Entities\Conferences;

use CodeIgniter\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;

class Conference extends Entity
{
    private $fileUploadFolder = 'uploads';
    private $fileDeletedFolder = 'deleted';

    public function saveAudioFile(UploadedFile $file = null)
    {
        if ($file === null or $file->isFile() === false) return false;

        $newName = $file->getRandomName();
        $clientName = $file->getClientName();
        $path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $file->move(WRITEPATH . $path, $newName);
        $this->radio_audio =  $path . '/' . $newName;
        $this->radio_audio_name =  $clientName;
        return true;
    }

    public function saveGrLogo(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        if ($file->isFile() === false) return false;

        $this->gr_logo = $this->saveFile($file);

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $this->gr_logo);
        $image->resize(100, 50, true, 'width');
        $image->save(WRITEPATH . $this->gr_logo);
        return true;
    }

    public function saveOgLogo(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        if ($file->isFile() === false) return false;

        $this->og_logo = $this->saveFile($file);

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $this->og_logo);
        $image->resize(100, 50, true, 'width');
        $image->save(WRITEPATH . $this->og_logo);
        return true;
    }

    public function saveCkeditorImage(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;
        if ($file->isFile() === false) return false;

        $link = $this->saveFile($file);

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $link);
        $image->getFile();
        $info = $image->getProperties(true);

        if($info['width'] > 1920) {
            $image = \Config\Services::image();
            $image->withFile(WRITEPATH . $link);
            $image->resize(1280, 0, true, 'width');
            $image->save(WRITEPATH . $link, 100);
        }
        return $link;
    }

    public function deleteGrLogo(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        $this->deleteFile($file);
        $this->gr_logo = '';
        return true;
    }

    public function saveManagementFile(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null or $file->isFile() === false) return false;

        $newName = $file->getRandomName();
        $clientName = $file->getClientName();
        $path = $this->fileUploadFolder . '/' . date('Y-m/Y-m-d');
        $file->move(WRITEPATH . $path, $newName);
        $this->management_file_url =  $path . '/' . $newName;
        $this->management_file_name =  $clientName;
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

    public function setUrlSegment(string $url_segment)
    {
        $this->attributes['url_segment'] = strtolower($url_segment);
        return $this;
    }

    public function saveRadioMainScheduleImage1(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        if ($file->isFile() === false) return false;

        $this->radio_main_schedule_img1 = $this->saveFile($file);

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $this->radio_main_schedule_img1);
        $image->resize(600, 420, true, 'width');
        $image->save(WRITEPATH . $this->radio_main_schedule_img1);
        return true;
    }

    public function saveRadioMainScheduleImage2(\CodeIgniter\Files\File $file = null)
    {
        if ($file === null) return false;

        if ($file->isFile() === false) return false;

        $this->radio_main_schedule_img2 = $this->saveFile($file);

        $image = \Config\Services::image();
        $image->withFile(WRITEPATH . $this->radio_main_schedule_img2);
        $image->resize(600, 420, true, 'width');
        $image->save(WRITEPATH . $this->radio_main_schedule_img2);
        return true;
    }
}
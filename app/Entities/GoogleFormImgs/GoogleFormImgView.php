<?php namespace App\Entities\GoogleFormImgs;

use CodeIgniter\Entity;

class GoogleFormImgView extends Entity
{
    public static function getFeedbackItems($imgs)
    {
        $cards = '';
        foreach ($imgs as $item) {
            $item = $item->toRawArray();
            $cards .= self::getFeedbackItem($item);
        }
        return $cards;
    }

    public static function getFeedbackItem(array $item)
    {
        return view('templates/conference/feedback/img_item', $item);
    }

    public static function getEditorItems(array $images)
    {
        $items = '';
        foreach ($images as $item) {
            $item = $item->toRawArray();
            $items .= self::getEditorItem($item);
        }
        return $items;
    }

    public static function getEditorItem(array $item)
    {
        return view('templates/editor/feedback/google_form_image_item', $item);
    }
}
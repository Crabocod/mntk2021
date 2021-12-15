<?php namespace App\Entities\SectionImages;

use CodeIgniter\Entity;

class SectionImageView extends Entity
{
    public static function getSectionImages($images)
    {
        $cards = '';
        foreach ($images as $item) {
            $item = $item->toRawArray();
            $cards .= self::getSectionImage($item);
        }
        return $cards;
    }

    public static function getSectionImage(array $item)
    {
        return view('templates/conference/sections/section_image', $item);
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
        return view('templates/editor/sections/image_item', $item);
    }
}
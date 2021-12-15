<?php namespace App\Entities\MemberGroups;

use CodeIgniter\Entity;

class MemberGroupView extends Entity
{
    public static function getCards($memberGroups)
    {
        $cards = '';
        foreach ($memberGroups as $item) {
            $item = $item->toRawArray();
            $cards .= self::getCard($item);
        }
        return $cards;
    }

    public static function getCard(array $item)
    {
        $item['button'] = self::getCardButton(!empty($item['user_id']));
        return view('templates/conference/member_groups/card', $item);
    }

    public static function getCardButton($has_user = false)
    {
        if(!$has_user)
            $result = view('templates/conference/member_groups/card_button');
        else
            $result = view('templates/conference/member_groups/card_button_signed');
        return $result;
    }

    public static function getEditorCards($memberGroups)
    {
        $cards = '';
        foreach ($memberGroups as $item) {
            $item = $item->toRawArray();
            $cards .= self::getEditorCard($item);
        }
        return $cards;
    }

    public static function getEditorCard(array $item)
    {
        return view('templates/editor/member_groups/card', $item);
    }
}
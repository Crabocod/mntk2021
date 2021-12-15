<?php namespace App\Entities\TeamQuests;

use CodeIgniter\Entity;

class TeamQuestView extends Entity
{
    public static function getSection(array $teamQuests)
    {
        $result = '';
        foreach ($teamQuests as $teamQuest) {
            $result .= self::getItem($teamQuest->toRawArray());
        }
        return $result;
    }

    public static function getItem(array $teamQuest)
    {
        return view('templates/conference/index/team-quest-item', $teamQuest);
    }

    public static function getEditorCards(array $teamQuests)
    {
        $result = '';
        foreach ($teamQuests as $teamQuest) {
            $result .= self::getEditorCard($teamQuest->toRawArray());
        }
        return $result;
    }

    public static function getEditorCard(array $teamQuest)
    {
        return view('templates/editor/team_quest/card', $teamQuest);
    }
}
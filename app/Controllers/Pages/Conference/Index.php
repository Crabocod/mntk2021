<?php namespace App\Controllers\Pages\Conference;

use App\Entities\Archives\ArchiveView;
use App\Entities\Chess\ChessView;
use App\Entities\News\NewsView;
use App\Models\Archives;
use App\Models\BusinessPrograms;
use App\Models\Chess;
use App\Models\Conference;
use App\Models\Files;
use App\Models\News;
use App\Models\SortBlocksModel;
use App\Models\SortNavigationBlockItemsModel;

class Index extends BaseController
{
    public function index()
    {
        $newsModel = new News();
        $filesModel = new Files();
        $chessModel = new Chess();
        $archivesModel = new Archives();
        $conferenceModel = new Conference();
        $eventsModel = new \App\Models\Events();
        $sortBlocksModel = new SortBlocksModel();
        $sectionsModel = new \App\Models\Sections();
        $businessProgramsModel = new BusinessPrograms();
        $sortNavigationBlocksModel = new SortNavigationBlockItemsModel();

        $data['conference'] = $conferenceModel->asArray()->first();
        $data['conference']['file'] = null;
        if(!empty($data['conference']['logo_file_id']))
            $data['conference']['logo_file'] = $filesModel->where('id', $data['conference']['logo_file_id'])->asArray()->first();
        if(!empty($data['conference']['logo_min_file_id']))
            $data['conference']['logo_min_file'] = $filesModel->where('id', $data['conference']['logo_min_file_id'])->asArray()->first();

        $chessModel->select('chess.*');
        $chessModel->select('img_file.link as img_file_link');
        $chessModel->select('img_file_min.link as img_file_min_link');
        $chessModel->join('files img_file', 'img_file.id=chess.img_file_id', 'left');
        $chessModel->join('files img_file_min', 'img_file_min.id=chess.img_min_file_id', 'left');
        $chessModel->orderBy('date', 'asc');
        $chess = $chessModel->findAll();
        $data['chess_section'] = ChessView::getChessSection($chess);

        $newsModel->select('news.*');
        $newsModel->select('photo_file.link as photo_file_link');
        $newsModel->select('photo_min_file.link as photo_min_file_link');
        $newsModel->where('news.is_publication', 1);
        $newsModel->join('files photo_file', 'photo_file.id=news.photo_file_id', 'left');
        $newsModel->join('files photo_min_file', 'photo_min_file.id=news.photo_min_file_id', 'left');
        $newsModel->limit(2);
        $newsModel->orderBy('id', 'desc');
        $news = $newsModel->find();

        $data['news_card'] = '';
        foreach($news as $item)
            $data['news_card'] .= NewsView::getNewsCardIndex($item->toArray());

        $archives = $archivesModel->show_all(['is_published' => 1]);
        $data['archives_card'] = ArchiveView::getCards($archives);

        $businessProgramsModel->where('is_published', 1);
        $data['business_programs'] = $businessProgramsModel->find();

        $data['sections'] = $sectionsModel->asArray()->where('is_publication', 1)->find();

        $data['events_type_1'] = $eventsModel->asArray()->where('event_type_id', 1)->find();
        $data['events_type_2'] = $eventsModel->asArray()->where('event_type_id', 2)->find();
        $data['events_type_3'] = $eventsModel->asArray()->where('event_type_id', 3)->find();
        $data['events_type_4'] = $eventsModel->asArray()->where('event_type_id', 4)->find();

        $sortBlocksModel->orderBy('number', 'ASC');
        $data['sort_blocks'] = $sortBlocksModel->find();

        $sortNavigationBlocksModel->orderBy('number', 'ASC');
        $data['sort_navigation_items'] = $sortNavigationBlocksModel->find();

        echo view('pages/conference/index', $data);
    }
}
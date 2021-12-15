<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Pages\Index');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/logout', 'Pages\Logout::index', ['name' => 'logout']);
$routes->get('/uploads/(:any)', 'FilesController::get/$1', ['name' => 'uploads/get']);

$routes->cli('/eventicious-sync', 'EventiciousSync::index', ['name' => 'cli']);
$routes->post('/eventicious-sync/(:num)/user/Create', 'EventiciousSync::addUser/$1', ['name' => '/']);
$routes->put('/eventicious-sync/(:num)/user/Update/(:num)', 'EventiciousSync::updateUser/$1/$2', ['name' => '/']);
$routes->delete('/eventicious-sync/(:num)/user/Delete/(:num)', 'EventiciousSync::deleteUser/$1/$2', ['name' => '/']);

$routes->post('/admin/save-ckeditor-image', 'Pages\Editor\Index::saveCkeditorImage', ['name' => 'admin']);

$routes->cli('/mailer/index', 'Mailer::index', ['name' => 'cli']);

$routes->get('/auth', 'Pages\Conference\Auth::index', ['name' => 'auth']);
$routes->get('/logout', 'Pages\Conference\Logout::index', ['name' => 'auth']);
$routes->get('/recovery', 'Pages\Conference\Recovery::index', ['name' => 'recovery']);
$routes->post('/recovery', 'Pages\Conference\Recovery::recoveryPassword', ['name' => 'recovery']);
$routes->post('/auth/login', 'Pages\Conference\Auth::login', ['name' => 'auth']);
$routes->get('/registration', 'Pages\Conference\Registration::index', ['name' => 'registration']);
$routes->post('/registration/register', 'Pages\Conference\Registration::register', ['name' => 'registration']);
$routes->get('/registration/confirm-email', 'Pages\Conference\Registration::confirmEmail', ['name' => 'registration']);
$routes->get('/', 'Pages\Conference\Index::index', ['name' => 'conference']);
$routes->get('/acquaintance', 'Pages\Conference\Acquaintance::index', ['name' => 'conference']);
$routes->post('/acquaintance/add-feedback', 'Pages\Conference\Acquaintance::addFeedback', ['name' => 'conference']);
$routes->get('/events/(:num)', 'Pages\Conference\Events::index/$1', ['name' => 'conference']);
$routes->post('/events/(:num)/signup', 'Pages\Conference\Events::signup/$1', ['name' => 'conference']);
$routes->post('/events/(:num)/add-feedback', 'Pages\Conference\Events::addFeedback/$1', ['name' => 'conference']);
$routes->get('/sections/(:num)', 'Pages\Conference\Sections::index/$1', ['name' => 'conference']);
$routes->post('/sections/(:num)/add-feedback', 'Pages\Conference\Sections::addFeedback/$1', ['name' => 'conference']);
$routes->post('/sections/(:num)/get-feedback', 'Pages\Conference\Sections::getFeedback/$1', ['name' => 'conference']);
$routes->get('/chronograph', 'Pages\Conference\Chronograph::index', ['name' => 'conference']);
$routes->post('/chronograph/add-answer', 'Pages\Conference\Chronograph::addAnswer', ['name' => 'conference']);
$routes->get('/programs/(:num)', 'Pages\Conference\Programs::index/$1', ['name' => 'conference']);
$routes->get('/archives', 'Pages\Conference\Archives::index', ['name' => 'conference']);
$routes->get('/archives/(:num)', 'Pages\Conference\ArchiveAbout::index/$1', ['name' => 'conference']);
$routes->get('/news', 'Pages\Conference\News::index/$1', ['name' => 'conference']);
$routes->get('/news/(:num)', 'Pages\Conference\News::about/$1', ['name' => 'conference']);

$routes->get('/admin/auth', 'Pages\Admin\Auth::index', ['name' => 'auth']);
$routes->post('/admin/auth/login', 'Pages\Admin\Auth::login', ['name' => 'auth']);
$routes->get('/admin/logout', 'Pages\Admin\Logout::index', ['name' => 'auth']);
$routes->get('/admin', 'Pages\Admin\Index::index', ['name' => 'admin']);
$routes->post('/admin/sort-blocks', 'Pages\Admin\Index::sortBlocks', ['name' => 'admin']);
$routes->post('/admin/sort-nav-items', 'Pages\Admin\Index::sortNabItems', ['name' => 'admin']);
$routes->post('/admin/hide-block', 'Pages\Admin\Index::hideBlock', ['name' => 'admin']);
$routes->post('/admin/update-main-block', 'Pages\Admin\Index::updateMainBlock', ['name' => 'admin']);
$routes->post('/admin/update-timer', 'Pages\Admin\Index::updateTimer', ['name' => 'admin']);
$routes->post('/admin/save-chess', 'Pages\Admin\Index::saveChess', ['name' => 'admin']);
$routes->post('/admin/delete-chess', 'Pages\Admin\Index::deleteChess', ['name' => 'admin']);
$routes->get('/admin/users', 'Pages\Admin\Users::index', ['name' => 'admin']);
$routes->post('/admin/users/add', 'Pages\Admin\Users::addUser', ['name' => 'admin']);
$routes->post('/admin/users/delete', 'Pages\Admin\Users::deleteUser', ['name' => 'admin']);
$routes->post('/admin/users/send-mail', 'Pages\Admin\Users::sendMail', ['name' => 'admin']);
$routes->post('/admin/users/send-all-mail', 'Pages\Admin\Users::sendAllMail', ['name' => 'admin']);
$routes->post('/admin/users/add-from-excel', 'Pages\Admin\Users::addFromExcel', ['name' => 'admin']);
$routes->post('/admin/users/show-users', 'Pages\Admin\Users::showUser', ['name' => 'admin']);
$routes->get('/admin/news', 'Pages\Admin\News::index', ['name' => 'admin']);
$routes->get('/admin/news/(:num)', 'Pages\Admin\NewsAbout::index/$1', ['name' => 'admin']);
$routes->post('/admin/news/save-news', 'Pages\Admin\News::saveNews', ['name' => 'admin']);
$routes->post('/admin/news/delete-news', 'Pages\Admin\News::deleteNews', ['name' => 'admin']);
$routes->post('/admin/news/show-news', 'Pages\Admin\News::showNews', ['name' => 'admin']);

$routes->get('/admin/master-classes', 'Pages\Admin\Events::index', ['name' => 'admin']);
$routes->get('/admin/master-classes/(:num)', 'Pages\Admin\EventsAbout::index/$1', ['name' => 'admin']);
$routes->post('/admin/master-classes/(:num)/sort-images', 'Pages\Admin\Events::sortImage/$1', ['name' => 'admin']);
$routes->post('/admin/master-classes/(:num)/update', 'Pages\Admin\Events::update/$1', ['name' => 'admin']);
$routes->post('/admin/master-classes/(:num)/delete', 'Pages\Admin\Events::delete/$1', ['name' => 'admin']);
$routes->post('/admin/master-classes/(:num)/confirm-user', 'Pages\Admin\Events::confirmUser/$1', ['name' => 'admin']);
$routes->post('/admin/master-classes/(:num)/save-image', 'Pages\Admin\Events::addImage/$1', ['name' => 'admin']);
$routes->post('/admin/master-classes/(:num)/delete-image', 'Pages\Admin\Events::deleteImage/$1', ['name' => 'admin']);
$routes->post('/admin/master-classes/(:num)/sort-image', 'Pages\Admin\Events::sortImage/$1', ['name' => 'admin']);

$routes->get('/admin/experts', 'Pages\Admin\Events::index', ['name' => 'admin']);
$routes->get('/admin/experts/(:num)', 'Pages\Admin\EventsAbout::index/$1', ['name' => 'admin']);
$routes->post('/admin/experts/(:num)/update', 'Pages\Admin\Events::update/$1', ['name' => 'admin']);
$routes->post('/admin/experts/(:num)/sort-images', 'Pages\Admin\Events::sortImage/$1', ['name' => 'admin']);
$routes->post('/admin/experts/(:num)/delete', 'Pages\Admin\Events::delete/$1', ['name' => 'admin']);
$routes->post('/admin/experts/(:num)/confirm-user', 'Pages\Admin\Events::confirmUser/$1', ['name' => 'admin']);
$routes->post('/admin/experts/(:num)/save-image', 'Pages\Admin\Events::addImage/$1', ['name' => 'admin']);
$routes->post('/admin/experts/(:num)/delete-image', 'Pages\Admin\Events::deleteImage/$1', ['name' => 'admin']);
$routes->post('/admin/experts/(:num)/sort-image', 'Pages\Admin\Events::sortImage/$1', ['name' => 'admin']);

$routes->get('/admin/oil-english-club', 'Pages\Admin\Events::index', ['name' => 'admin']);
$routes->get('/admin/oil-english-club/(:num)', 'Pages\Admin\EventsAbout::index/$1', ['name' => 'admin']);
$routes->post('/admin/oil-english-club/(:num)/update', 'Pages\Admin\Events::update/$1', ['name' => 'admin']);
$routes->post('/admin/oil-english-club/(:num)/sort-images', 'Pages\Admin\Events::sortImage/$1', ['name' => 'admin']);
$routes->post('/admin/oil-english-club/(:num)/delete', 'Pages\Admin\Events::delete/$1', ['name' => 'admin']);
$routes->post('/admin/oil-english-club/(:num)/confirm-user', 'Pages\Admin\Events::confirmUser/$1', ['name' => 'admin']);
$routes->post('/admin/oil-english-club/(:num)/save-image', 'Pages\Admin\Events::addImage/$1', ['name' => 'admin']);
$routes->post('/admin/oil-english-club/(:num)/delete-image', 'Pages\Admin\Events::deleteImage/$1', ['name' => 'admin']);
$routes->post('/admin/oil-english-club/(:num)/sort-image', 'Pages\Admin\Events::sortImage/$1', ['name' => 'admin']);

$routes->get('/admin/lounge-time', 'Pages\Admin\Events::index', ['name' => 'admin']);
$routes->get('/admin/lounge-time/(:num)', 'Pages\Admin\EventsAbout::index/$1', ['name' => 'admin']);
$routes->post('/admin/lounge-time/(:num)/update', 'Pages\Admin\Events::update/$1', ['name' => 'admin']);
$routes->post('/admin/lounge-time/(:num)/sort-images', 'Pages\Admin\Events::sortImage/$1', ['name' => 'admin']);
$routes->post('/admin/lounge-time/(:num)/delete', 'Pages\Admin\Events::delete/$1', ['name' => 'admin']);
$routes->post('/admin/lounge-time/(:num)/confirm-user', 'Pages\Admin\Events::confirmUser/$1', ['name' => 'admin']);
$routes->post('/admin/lounge-time/(:num)/save-image', 'Pages\Admin\Events::addImage/$1', ['name' => 'admin']);
$routes->post('/admin/lounge-time/(:num)/delete-image', 'Pages\Admin\Events::deleteImage/$1', ['name' => 'admin']);
$routes->post('/admin/lounge-time/(:num)/sort-image', 'Pages\Admin\Events::sortImage/$1', ['name' => 'admin']);

$routes->post('/admin/events/add', 'Pages\Admin\Events::add', ['name' => 'admin']);
$routes->get('/admin/acquaintance', 'Pages\Admin\Acquaintance::index', ['name' => 'admin']);
$routes->post('/admin/acquaintance/update', 'Pages\Admin\Acquaintance::update', ['name' => 'admin']);
$routes->get('/admin/programs', 'Pages\Admin\Programs::index', ['name' => 'admin']);
$routes->post('/admin/programs/save-program', 'Pages\Admin\Programs::saveProgram', ['name' => 'admin']);
$routes->post('/admin/programs/show-programs', 'Pages\Admin\Programs::showPrograms', ['name' => 'admin']);
$routes->post('/admin/programs/delete-program', 'Pages\Admin\Programs::deleteProgram', ['name' => 'admin']);
$routes->post('/admin/programs/public-programs', 'Pages\Admin\Programs::publicProgram', ['name' => 'admin']);
$routes->get('/admin/programs/(:num)', 'Pages\Admin\ProgramsAbout::index/$1', ['name' => 'admin']);
$routes->get('/admin/chronograph', 'Pages\Admin\Chronograph::index', ['name' => 'admin']);
$routes->post('/admin/chronograph/save-text', 'Pages\Admin\Chronograph::saveText', ['name' => 'admin']);
$routes->post('/admin/chronograph/save-question', 'Pages\Admin\Chronograph::saveQuestion', ['name' => 'admin']);
$routes->post('/admin/chronograph/show-questions', 'Pages\Admin\Chronograph::showQuestion', ['name' => 'admin']);
$routes->post('/admin/chronograph/delete-question', 'Pages\Admin\Chronograph::deleteQuestion', ['name' => 'admin']);
$routes->get('/admin/jury-work', 'Pages\Admin\JuryWork::index', ['name' => 'admin']);

$routes->post('/admin/jury-work/add', 'Pages\Admin\JuryWork::addJuryWork', ['name' => 'admin']);
$routes->get('/admin/jury-work/(:num)', 'Pages\Admin\JuryWorkAbout::index/$1', ['name' => 'admin']);
$routes->post('/admin/jury-work/(:num)/update', 'Pages\Admin\JuryWorkAbout::update/$1', ['name' => 'admin']);
$routes->post('/admin/jury-work/(:num)/save-jury', 'Pages\Admin\JuryWorkAbout::saveJury/$1', ['name' => 'admin']);
$routes->post('/admin/jury-work/(:num)/delete-jury', 'Pages\Admin\JuryWorkAbout::deleteJury/$1', ['name' => 'admin']);
$routes->post('/admin/jury-work/(:num)/add-jury', 'Pages\Admin\JuryWorkAbout::addJury/$1', ['name' => 'admin']);
$routes->post('/admin/jury-work/(:num)/sort-images', 'Pages\Admin\JuryWorkAbout::sortImages/$1', ['name' => 'admin']);
$routes->post('/admin/jury-work/(:num)/delete-image', 'Pages\Admin\JuryWorkAbout::deleteImages/$1', ['name' => 'admin']);
$routes->post('/admin/jury-work/(:num)/save-image', 'Pages\Admin\JuryWorkAbout::saveImages/$1', ['name' => 'admin']);
$routes->post('/admin/jury-work/(:num)/delete-section', 'Pages\Admin\JuryWorkAbout::deleteSection/$1', ['name' => 'admin']);
$routes->get('/admin/jury-work/(:num)', 'Pages\Admin\JuryWorkAbout::index', ['name' => 'admin']);

$routes->get('/admin/archive', 'Pages\Admin\Archive::index', ['name' => 'admin']);
$routes->post('/admin/archive/add', 'Pages\Admin\Archive::add', ['name' => 'admin']);
$routes->post('/admin/archive/publication', 'Pages\Admin\Archive::publication', ['name' => 'admin']);
$routes->get('/admin/archive/(:num)', 'Pages\Admin\ArchiveAbout::index/$1', ['name' => 'admin']);
$routes->post('/admin/archive/(:num)/update', 'Pages\Admin\Archive::update/$1', ['name' => 'admin']);
$routes->post('/admin/archive/(:num)/delete', 'Pages\Admin\Archive::delete/$1', ['name' => 'admin']);

$routes->get('/admin/moderators', 'Pages\Admin\Moderators::index', ['name' => 'admin']);
$routes->post('/admin/moderators/add', 'Pages\Admin\Moderators::addUser', ['name' => 'admin']);
$routes->post('/admin/moderators/show-users', 'Pages\Admin\Moderators::showUser', ['name' => 'admin']);
$routes->post('/admin/moderators/send-all-mail', 'Pages\Admin\Moderators::sendAllMail', ['name' => 'admin']);
$routes->post('/admin/moderators/add-from-excel', 'Pages\Admin\Moderators::addFromExcel', ['name' => 'admin']);


//$routes->get('/admin/auth', 'Pages\Admin\Auth::index', ['name' => 'auth', 'as' => 'admin_auth']);
//$routes->post('/admin/auth/recovery-password', 'Pages\Admin\Auth::recoveryPassword', ['name' => 'auth']);
//$routes->post('/admin/auth/login', 'Pages\Admin\Auth::login', ['name' => 'auth']);
//$routes->post('/admin/auth/recovery-password', 'Pages\Admin\Auth::recoveryPassword', ['name' => 'auth']);
//$routes->get('/admin/admin-users', 'Pages\Admin\AdminUsers::index', ['name' => 'admin']);
//$routes->post('/admin/admin-users/user-update', 'Pages\Admin\AdminUsers::save', ['name' => 'admin']);
//$routes->post('/admin/admin-users/user-delete', 'Pages\Admin\AdminUsers::delete', ['name' => 'admin']);
//$routes->post('/admin/admin-users/send-pass', 'Pages\Admin\AdminUsers::sendPass', ['name' => 'admin']);
//$routes->get('/admin/editors', 'Pages\Admin\Editors::index', ['name' => 'admin']);
//$routes->post('/admin/editors/editor-update', 'Pages\Admin\Editors::save', ['name' => 'admin']);
//$routes->post('/admin/editors/editor-delete', 'Pages\Admin\Editors::delete', ['name' => 'admin']);
//$routes->post('/admin/editors/send-pass', 'Pages\Admin\Editors::sendPass', ['name' => 'admin']);
//$routes->get('/admin/logout', 'Pages\Admin\Logout::logout', ['name' => 'logout']);
//$routes->post('/admin/save-conference', 'Pages\Admin\Index::saveConference', ['name' => 'admin']);
//$routes->post('/admin/delete-conference', 'Pages\Admin\Index::deleteConference', ['name' => 'admin']);
//
//$routes->get('/editor', 'Pages\Editor\Auth::index/$1', ['name' => 'auth', 'as' => 'editor_auth']);
//$routes->post('/editor/auth/recovery-password', 'Pages\Editor\Auth::recoveryPassword', ['name' => 'auth']);
//$routes->get('/editor/(:num)', 'Pages\Editor\Index::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/save-ckeditor-image', 'Pages\Editor\Index::saveCkeditorImage/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/users', 'Pages\Editor\Users::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/users/send-all-pass', 'Pages\Editor\Users::sendAllPass/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/og-info', 'Pages\Editor\OgInfo::index/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/events', 'Pages\Editor\Events::index/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/partner', 'Pages\Editor\Partner::index/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/team-quest', 'Pages\Editor\TeamQuest::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/team-quest/update', 'Pages\Editor\TeamQuest::update/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/team-quest/delete', 'Pages\Editor\TeamQuest::delete/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/partner/edit-wtb', 'Pages\Editor\Partner::EditWtb/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/partner/save-member-group', 'Pages\Editor\Partner::saveMemberGroup/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/partner/delete-member-group', 'Pages\Editor\Partner::deleteMemberGroup/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/events/(:num)', 'Pages\Editor\Events::about/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/events/(:num)/save-event-about', 'Pages\Editor\Events::saveAbout/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/events/(:num)/event-delete', 'Pages\Editor\Events::delete/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/events/(:num)/user-change-status', 'Pages\Editor\Events::userChangeStatus/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/events/(:num)/get-users-excel', 'Pages\Editor\Events::getUsersExcel/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/events/save-event', 'Pages\Editor\Events::saveEvent/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/og-info/save-og', 'Pages\Editor\OgInfo::saveOg/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/users/update', 'Pages\Editor\Users::save/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/users/delete', 'Pages\Editor\Users::delete/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/users/send-pass', 'Pages\Editor\Users::sendPass/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/users/add-from-excel', 'Pages\Editor\Users::addFromExcel/$1', ['name' => 'editor']);
//$routes->get('/editor/logout', 'Pages\Editor\Logout::logout', ['name' => 'logout']);
//$routes->post('/editor/auth/login', 'Pages\Editor\Auth::login/$1', ['name' => 'auth']);
//$routes->post('/editor/auth/recovery-password', 'Pages\Editor\Auth::recoveryPassword/$1', ['name' => 'auth']);
//$routes->post('/editor/(:num)/save-conference', 'Pages\Editor\Index::saveConference/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/save-gr', 'Pages\Editor\Index::saveGr/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/save-radio', 'Pages\Editor\Index::saveRadio/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/save-chess', 'Pages\Editor\Index::saveChess/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/save-barrels', 'Pages\Editor\Index::saveBarrels/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/delete-chess', 'Pages\Editor\Index::deleteChess/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/archives', 'Pages\Editor\Archives::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/archives/save-archive', 'Pages\Editor\Archives::saveArchive/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/archives/(:num)', 'Pages\Editor\Archives::about/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/archives/(:num)/save-archive', 'Pages\Editor\Archives::saveArchive/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/archives/(:num)/delete-archive', 'Pages\Editor\Archives::deleteArchive/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/archives/(:num)/add-archive-file', 'Pages\Editor\Archives::addArchiveFile/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/archives/(:num)/delete-archive-file', 'Pages\Editor\Archives::deleteArchiveFile/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/archives/(:num)/delete-archive-feedback', 'Pages\Editor\Archives::deleteArchiveFeedback/$1/$2', ['name' => 'editor']);
//$routes->get('/editor/(:num)/news', 'Pages\Editor\News::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/news/save-news', 'Pages\Editor\News::save/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/news/publication', 'Pages\Editor\News::publication/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/news/(:num)/save-news', 'Pages\Editor\News::save/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/news/(:num)/delete-news', 'Pages\Editor\News::delete/$1/$2', ['name' => 'editor']);
//$routes->get('/editor/(:num)/news/(:num)', 'Pages\Editor\News::about/$1/$2', ['name' => 'editor']);
//$routes->get('/editor/(:num)/sections', 'Pages\Editor\Sections::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/save-section', 'Pages\Editor\Sections::save/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/publication', 'Pages\Editor\Sections::publication/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/sections/(:num)', 'Pages\Editor\Sections::about/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/(:num)/save-section', 'Pages\Editor\Sections::save/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/(:num)/delete-section', 'Pages\Editor\Sections::delete/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/(:num)/delete-section-feedback', 'Pages\Editor\Sections::deleteFeedback/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/(:num)/save-jury', 'Pages\Editor\Sections::saveJury/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/(:num)/delete-jury', 'Pages\Editor\Sections::deleteJury/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/(:num)/save-image', 'Pages\Editor\Sections::addImage/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/(:num)/delete-image', 'Pages\Editor\Sections::deleteImage/$1/$2', ['name' => 'editor']);
//$routes->post('/editor/(:num)/sections/(:num)/sort-images', 'Pages\Editor\Sections::sortImages/$1/$2', ['name' => 'editor']);
//$routes->get('/editor/(:num)/feedback', 'Pages\Editor\Feedback::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/feedback/save', 'Pages\Editor\Feedback::save/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/feedback/save-image', 'Pages\Editor\Feedback::addImage/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/feedback/delete-image', 'Pages\Editor\Feedback::deleteImage/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/feedback/sort-images', 'Pages\Editor\Feedback::sortImages/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/prof-quiz', 'Pages\Editor\ProfQuiz::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/prof-quiz/save-main', 'Pages\Editor\ProfQuiz::saveMain/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/prof-quiz/publication', 'Pages\Editor\ProfQuiz::publication/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/prof-quiz/save', 'Pages\Editor\ProfQuiz::save/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/prof-quiz/delete', 'Pages\Editor\ProfQuiz::delete/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/prof-quiz/get-excel', 'Pages\Editor\ProfQuiz::getAnswersExcel/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/region-quiz', 'Pages\Editor\RegionQuiz::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/region-quiz/save-main', 'Pages\Editor\RegionQuiz::saveMain/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/region-quiz/publication', 'Pages\Editor\RegionQuiz::publication/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/region-quiz/save', 'Pages\Editor\RegionQuiz::save/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/region-quiz/delete', 'Pages\Editor\RegionQuiz::delete/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/region-quiz/get-excel', 'Pages\Editor\RegionQuiz::getAnswersExcel/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/radio', 'Pages\Editor\Radio::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/radio/save-live', 'Pages\Editor\Radio::saveLive/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/radio/update-live', 'Pages\Editor\Radio::updateLive/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/radio/save-archive', 'Pages\Editor\Radio::saveArchive/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/radio/update-archive', 'Pages\Editor\Radio::updateArchive/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/radio/delete-live', 'Pages\Editor\Radio::deleteLive/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/radio/delete-archive', 'Pages\Editor\Radio::deleteArchive/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/radio/save-radio', 'Pages\Editor\Radio::saveRadio/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/radio/save-main-schedule', 'Pages\Editor\Radio::saveMainSchedule/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/groups', 'Pages\Editor\Groups::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/groups/add-group', 'Pages\Editor\Groups::add/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/groups/delete-group', 'Pages\Editor\Groups::delete/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/groups/update-group', 'Pages\Editor\Groups::update/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/groups/distribute', 'Pages\Editor\Groups::distribute/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/groups/get-members-rows', 'Pages\Editor\Groups::getMembersRows/$1', ['name' => 'editor']);
//$routes->get('/editor/(:num)/management', 'Pages\Editor\Management::index/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/management/save', 'Pages\Editor\Management::save/$1', ['name' => 'editor']);
//$routes->post('/editor/(:num)/management/delete-feedback', 'Pages\Editor\Management::deleteFeedback/$1', ['name' => 'editor']);
//
//$routes->get('/(:alphanum)/auth', 'Pages\Conference\Auth::index/$1', ['name' => 'auth', 'as' => 'auth']);
//$routes->post('/(:alphanum)/auth/login', 'Pages\Conference\Auth::login/$1', ['name' => 'auth']);
//$routes->post('/(:alphanum)/auth/recovery-password', 'Pages\Conference\Auth::recoveryPassword/$1', ['name' => 'auth']);
//$routes->get('/(:alphanum)', 'Pages\Conference\Index::index/$1', ['name' => 'conference']);
//$routes->post('/(:alphanum)/add-barrel', 'Pages\Conference\Index::addBarrel/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/og-info', 'Pages\Conference\OgInfo::index/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/events', 'Pages\Conference\Events::index/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/news', 'Pages\Conference\News::index/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/news/(:num)', 'Pages\Conference\News::about/$1/$2', ['name' => 'conference']);
//$routes->get('/(:alphanum)/sections', 'Pages\Conference\Sections::index/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/sections/(:num)', 'Pages\Conference\Sections::about/$1/$2', ['name' => 'conference']);
//$routes->post('/(:alphanum)/sections/(:num)/add-feedback', 'Pages\Conference\Sections::addFeedback/$1/$2', ['name' => 'conference']);
//$routes->get('/(:alphanum)/archive', 'Pages\Conference\Archive::index/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/archive/(:num)', 'Pages\Conference\Archive::about/$1/$2', ['name' => 'conference']);
//$routes->post('/(:alphanum)/archive/(:num)/add-feedback', 'Pages\Conference\Archive::addFeedback/$1/$2', ['name' => 'conference']);
//$routes->get('/(:alphanum)/prof-quiz', 'Pages\Conference\ProfQuiz::index/$1', ['name' => 'conference']);
//$routes->post('/(:alphanum)/prof-quiz/save-answer', 'Pages\Conference\ProfQuiz::saveAnswer/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/region-quiz', 'Pages\Conference\RegionQuiz::index/$1', ['name' => 'conference']);
//$routes->post('/(:alphanum)/region-quiz/save-answer', 'Pages\Conference\RegionQuiz::saveAnswer/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/feedback', 'Pages\Conference\Feedback::index/$1', ['name' => 'conference']);
////$routes->get('/(:alphanum)/member', 'Pages\Conference\Member::index/$1', ['name' => 'conference']);
////$routes->post('/(:alphanum)/member/signing', 'Pages\Conference\Member::signing/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/radio', 'Pages\Conference\Radio::index/$1', ['name' => 'conference']);
//$routes->get('/(:alphanum)/events/(:num)', 'Pages\Conference\Events::about/$1/$2', ['name' => 'conference']);
//$routes->get('/(:alphanum)/events/(:num)/sign-up', 'Pages\Conference\Events::signUp', ['name' => 'conference']);
//$routes->get('/(:alphanum)/events/(:num)/is-sign', 'Pages\Conference\Events::isSign', ['name' => 'conference']);
//$routes->get('/(:alphanum)/management', 'Pages\Conference\Management::index', ['name' => 'conference']);
//$routes->post('/(:alphanum)/management/add-feedback', 'Pages\Conference\Management::addFeedback/$1', ['name' => 'conference']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

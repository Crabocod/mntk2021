<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitSeeder extends Seeder
{
    public function run()
    {
        $conferenceData = [
            'title' => 'МНТК 2021',
            'sub_title' => 'XVI Межрегиональная научно-техническая конференция молодых специалистов ПАО «НК «Роснефть»',
            'logo_file_id' => '1',
            'date' => '10 - 24 ноября 2021 г.',
            'timer' => '2021-12-31 12:00:00',
            'specialist_num' => '362',
            'og_num' => '69',
            'experts_num' => '85',
            'sections_num' => '16',
            'projects_num' => '294',
        ];

        $fileExtData = [
            ['title' => 'PDF', 'file_extension' => 'pdf'],
            ['title' => 'Excel', 'file_extension' => 'xls'],
            ['title' => 'Excel', 'file_extension' => 'xlsx'],
            ['title' => 'Word', 'file_extension' => 'doc'],
            ['title' => 'Word', 'file_extension' => 'docx'],
            ['title' => 'Photoshop', 'file_extension' => 'psd'],
            ['title' => 'Adobe Illustrator', 'file_extension' => 'ai'],
            ['title' => 'Архив', 'file_extension' => 'zip'],
            ['title' => 'Архив', 'file_extension' => 'rar'],
            ['title' => 'Архив', 'file_extension' => '7z'],
            ['title' => 'Изображение', 'file_extension' => 'jpg'],
            ['title' => 'Изображение', 'file_extension' => 'jpeg'],
            ['title' => 'Изображение', 'file_extension' => 'png'],
            ['title' => 'Изображение', 'file_extension' => 'bmp'],
            ['title' => 'Изображение', 'file_extension' => 'webp'],
            ['title' => 'Word', 'file_extension' => 'tiff'],
            ['title' => 'Текстовый файл', 'file_extension' => 'txt'],
            ['title' => 'Изображение', 'file_extension' => 'svg'],
            ['title' => 'Изображение', 'file_extension' => 'gif'],
            ['title' => 'Изображение', 'file_extension' => 'tif'],
            ['title' => 'Изображение', 'file_extension' => 'gfif'],
            ['title' => 'Word', 'file_extension' => 'docm'],
            ['title' => 'Текстовый файл', 'file_extension' => 'text'],
            ['title' => 'Аудио', 'file_extension' => 'flac'],
            ['title' => 'Аудио', 'file_extension' => 'mp3'],
            ['title' => 'Аудио', 'file_extension' => 'ac3'],
            ['title' => 'Аудио', 'file_extension' => 'amr'],
            ['title' => 'Аудио', 'file_extension' => 'aud'],
            ['title' => 'Аудио', 'file_extension' => 'iff'],
            ['title' => 'Аудио', 'file_extension' => 'm3u'],
            ['title' => 'Аудио', 'file_extension' => 'm4a'],
            ['title' => 'Аудио', 'file_extension' => 'm4b'],
            ['title' => 'Аудио', 'file_extension' => 'm4r'],
            ['title' => 'Аудио', 'file_extension' => 'mid'],
            ['title' => 'Аудио', 'file_extension' => 'mpa'],
            ['title' => 'Аудио', 'file_extension' => 'wma'],
            ['title' => 'Аудио', 'file_extension' => 'wav'],
            ['title' => 'Аудио', 'file_extension' => 'temp'],
            ['title' => 'Аудио', 'file_extension' => 'srt'],
            ['title' => 'Аудио', 'file_extension' => 'spl'],
            ['title' => 'Аудио', 'file_extension' => 'ra'],
            ['title' => 'Аудио', 'file_extension' => 'aif'],
            ['title' => 'Аудио', 'file_extension' => 'm3u8'],
            ['title' => 'Аудио', 'file_extension' => 'ogg'],
            ['title' => 'Аудио', 'file_extension' => 'opus'],
            ['title' => 'Аудио', 'file_extension' => 'pls'],
            ['title' => 'Аудио', 'file_extension' => 'wav'],
            ['title' => 'Аудио', 'file_extension' => 'aac'],
            ['title' => 'Презентация', 'file_extension' => 'pptx'],
            ['title' => 'Презентация', 'file_extension' => 'pptm'],
            ['title' => 'Презентация', 'file_extension' => 'ppt'],
            ['title' => 'Презентация', 'file_extension' => 'pdf'],
            ['title' => 'Презентация', 'file_extension' => 'potx'],
            ['title' => 'Презентация', 'file_extension' => 'potm'],
            ['title' => 'Презентация', 'file_extension' => 'ppsx'],
            ['title' => 'Презентация', 'file_extension' => 'odp'],
        ];

        $rolesData = [
            ['title' => 'Администратор'],
            ['title' => 'Модераторы'],
            ['title' => 'Участник']
        ];

        $usersData = [
            [
                'full_name' => 'Администратор',
                'email' => 'admin@mail.ru',
                'password' => '$2y$10$G/nb5hjRndxgwlMku.kYxuPp0xYPGWr0cSmay6asfzfqetw6wdVTm',
                'role_id' => 1,
                'email_confirmed' => 1,
                'is_registered' => 1,
            ]
        ];

        $permissionsData = [
            ['id' => 1, 'title' => 'admin', 'description' => 'Админка'],
            ['id' => 2, 'title' => 'conference', 'description' => 'Конференция'],
        ];

        $userPermData = [
            ['role_id' => 1, 'perm_id' => 1],
            ['role_id' => 1, 'perm_id' => 2],
            ['role_id' => 2, 'perm_id' => 1],
            ['role_id' => 2, 'perm_id' => 2],
            ['role_id' => 3, 'perm_id' => 2],
        ];

        $settingsData = [
            ['name' => 'email_from', 'value' => 'Noreply@mntk2021.ru'],
            ['name' => 'SMTPHost', 'value' => 'smtp.yandex.ru'],
            ['name' => 'SMTPPass', 'value' => '7L!umQi#cMS@r[T]q(j&'],
        ];

        $eventTypesData = [
            ['id' => 1, 'title' => 'Мастер-класс'],
            ['id' => 2, 'title' => 'Время экспертов'],
            ['id' => 3, 'title' => 'Lounge Time'],
            ['id' => 4, 'title' => 'Oil English club'],
        ];

        $chronographQuestionFileTypes = [
            ['id' => 1, 'title' => 'Аудио'],
            ['id' => 2, 'title' => 'Файлы'],
            ['id' => 3, 'title' => 'Изображение'],
        ];

        $filesData = [
            ['id' => 1, 'title' => 'main-logo.png', 'ext_id' => 13, 'link' => 'img/main-logo.png'],
            ['id' => 2, 'title' => 'news', 'ext_id' => 11, 'link' => 'img/news-1.jpg'],
            ['id' => 3, 'title' => 'news', 'ext_id' => 11, 'link' => 'img/news-2.jpg'],
            ['id' => 4, 'title' => 'events', 'ext_id' => 11, 'link' => 'img/programs.jpg'],
            ['id' => 5, 'title' => 'events', 'ext_id' => 13, 'link' => 'img/speak-block.png'],
            ['id' => 6, 'title' => 'chronograph', 'ext_id' => 25, 'link' => 'https://audionerd.ru/mp3/Ly9tb29zaWMubXkubWFpbC5ydS9maWxlLzMyYmY5NWVhNmQ2NDgxMjgwZjVjYWU1ZDU5ZDhlMDZlLm1wMw=='],
            ['id' => 7, 'title' => 'shahmatka.svg', 'ext_id' => 18, 'link' => 'img/shahmatka.svg'],
            // 8-13 занято в TestSeeder
        ];

        $acquaintanceData = [
            'title' => 'ЗНАКОМСТВО',
            'text' => 'Описание мероприятия',
            'youtube_iframe' => '<iframe loading="lazy" type="text/html" width="548" height="374" src="http://www.youtube.com/embed/M7lc1UVf-VE?autoplay=1&amp;origin=http://example.com" frameborder="0"></iframe>'
        ];

        $sortBlocksData = [
            ['id' => 1, 'number' => 1, 'hide' => 0], // Главная
            ['id' => 3, 'number' => 2, 'hide' => 1], // Таймер
            ['id' => 2, 'number' => 3, 'hide' => 0], // Навигация
            ['id' => 6, 'number' => 4, 'hide' => 0], // Шахматка
            ['id' => 4, 'number' => 5, 'hide' => 0], // Лента новостей
            ['id' => 5, 'number' => 6, 'hide' => 0], // Архив мероприятий
        ];

        $chronographData = [
            [
                'text' => 'Как хорошо Вы знаете историю нашей Компании?
Интересовались ли вы, кто стоял у истоков нашей Конференции?
Сколько проектов молодых специалистов были внедрены по результатам МНТК за все 16 лет работы Конференции?',
            ],
        ];

        // Using Query Builder
        $this->db->table('sort_blocks')->insertBatch($sortBlocksData);
        $this->db->table('conference')->insert($conferenceData);
        $this->db->table('file_ext')->insertBatch($fileExtData);
        $this->db->table('roles')->insertBatch($rolesData);
        $this->db->table('users')->insertBatch($usersData);
        $this->db->table('permissions')->insertBatch($permissionsData);
        $this->db->table('role_perm')->insertBatch($userPermData);
        $this->db->table('settings')->insertBatch($settingsData);
        $this->db->table('event_types')->insertBatch($eventTypesData);
        $this->db->table('files')->insertBatch($filesData);
        $this->db->table('chronograph_question_file_types')->insertBatch($chronographQuestionFileTypes);
        $this->db->table('acquaintance')->insert($acquaintanceData);
        $this->db->table('chronograph')->insertBatch($chronographData);
    }
}
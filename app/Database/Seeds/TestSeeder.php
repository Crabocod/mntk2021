<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $chessData = [
            [
                'date' => date('Y-m-d H:i:s', strtotime('-3 day')),
                'type' => 'Мастер класс',
                'title' => '«Эмоциональный интеллект в бизнесе» А.Э. Баснарева',
                'img_file_id' => '0',
                'page_url' => '/test/events/1'
            ],
            [
                'date' => date('Y-m-d H:i:s', strtotime('-2 day')),
                'type' => 'Время эксперата',
                'title' => '«Клиентоориентированность» А.Э. Баснарева',
                'img_file_id' => '0',
                'page_url' => '/test/events/2'
            ],
            [
                'date' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'type' => 'Мастер класс',
                'title' => '«Реализация высокотехнологичных инновационных проектов в Компании» И.В. Доровских',
                'img_file_id' => '0',
                'page_url' => '/test/events/1'
            ],
        ];

        $newsData = [
            [
                'title' => 'Прямой эфир. Открытие МНТК',
                'photo_file_id' => 2,
                'date' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'youtube_iframe' => '<iframe loading="lazy" width="284" height="278" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
            ],
            [
                'title' => 'Прямой эфир. Открытие МНТК 2',
                'photo_file_id' => 3,
                'date' => date('Y-m-d H:i:s', strtotime('-3 day')),
                'youtube_iframe' => '<iframe loading="lazy" width="284" height="278" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
            ],
            [
                'title' => 'Прямой эфир. Открытие МНТК 3',
                'photo_file_id' => 2,
                'date' => date('Y-m-d H:i:s', strtotime('-5 day')),
                'youtube_iframe' => '<iframe loading="lazy" width="284" height="278" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
            ],
        ];

        $archivesData = [
            [
                'title' => 'Архив 1',
                'date_from' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'speaker' => 'Спикер 1',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 0,
                'preview_file_id' => 4,
                'presentation_file_id' => 3,
                'photo_file_id' => 0,
                'youtube_iframe' => '<iframe loading="lazy" width="238" height="134" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            ],
            [
                'title' => 'Архив 2',
                'date_from' => date('Y-m-d H:i:s', strtotime('-3 day')),
                'speaker' => 'Спикер 2',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 1,
                'preview_file_id' => 4,
                'presentation_file_id' => 3,
                'photo_file_id' => 0,
                'youtube_iframe' => '<iframe loading="lazy" width="238" height="134" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            ],
            [
                'title' => 'Архив 3',
                'date_from' => date('Y-m-d H:i:s', strtotime('-5 day')),
                'speaker' => 'Спикер 3',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 1,
                'preview_file_id' => 4,
                'presentation_file_id' => 3,
                'photo_file_id' => 0,
                'youtube_iframe' => '<iframe loading="lazy" width="238" height="134" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            ],
            [
                'title' => 'Архив 3',
                'date_from' => date('Y-m-d H:i:s', strtotime('-5 day')),
                'speaker' => 'Спикер 3',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 1,
                'preview_file_id' => 4,
                'presentation_file_id' => 3,
                'photo_file_id' => 0,
                'youtube_iframe' => '<iframe loading="lazy" width="238" height="134" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            ],
            [
                'title' => 'Архив 3',
                'date_from' => date('Y-m-d H:i:s', strtotime('-5 day')),
                'speaker' => 'Спикер 3',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 1,
                'preview_file_id' => 4,
                'presentation_file_id' => 3,
                'photo_file_id' => 0,
                'youtube_iframe' => '<iframe loading="lazy" width="238" height="134" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            ],
            [
                'title' => 'Архив 3',
                'date_from' => date('Y-m-d H:i:s', strtotime('-5 day')),
                'speaker' => 'Спикер 3',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 1,
                'preview_file_id' => 4,
                'presentation_file_id' => 3,
                'photo_file_id' => 0,
                'youtube_iframe' => '<iframe loading="lazy" width="238" height="134" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            ],
        ];

        $sectionsData = [
            [
                'title' => 'Секция',
                'number' => '1',
                'is_publication' => 1,
            ],
            [
                'title' => 'Секция',
                'number' => '2',
                'is_publication' => 0,
            ],
            [
                'title' => 'Секция',
                'number' => '3',
                'is_publication' => 1,
            ],
            [
                'title' => 'Секция',
                'number' => '3',
                'is_publication' => 1,
            ],
        ];


        $chronographQuestionsData = [
            [
                'number' => '1',
                'text' => 'Докажите, что если у тетраэдра два отрезка, идущие из вершин некоторого ребра, в центры вписанных окружностей противолежащих граней, пересекаются, то отрезки, выпущенные из вершин скрещивающегося с ним ребра в центры вписанных окружностей двух других граней, также пересекаются.',
                'youtube_iframe' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1OJwGRN1BM0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'show' => '1',
            ],
            [
                'number' => '2',
                'text' => 'Докажите, что если у тетраэдра два отрезка, идущие из вершин некоторого ребра, в центры вписанных окружностей противолежащих граней, пересекаются, то отрезки, выпущенные из вершин скрещивающегося с ним ребра в центры вписанных окружностей двух других граней, также пересекаются.',
                'youtube_iframe' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1OJwGRN1BM0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'show' => '1',
            ],
            [
                'number' => '3',
                'text' => 'Докажите, что если у тетраэдра два отрезка, идущие из вершин некоторого ребра, в центры вписанных окружностей противолежащих граней, пересекаются, то отрезки, выпущенные из вершин скрещивающегося с ним ребра в центры вписанных окружностей двух других граней, также пересекаются.',
                'youtube_iframe' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1OJwGRN1BM0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'show' => '1',
            ],
        ];

        $chronographQuestionFilesData = [
            [
                'chronograph_question_id' => '1',
                'type_id' => '3',
                'file_id' => '2',
            ],
            [
                'chronograph_question_id' => '1',
                'type_id' => '1',
                'file_id' => '6',
            ],
            [
                'chronograph_question_id' => '2',
                'type_id' => '3',
                'file_id' => '2',
            ],
            [
                'chronograph_question_id' => '3',
                'type_id' => '3',
                'file_id' => '2',
            ],
        ];

        $businessPrograms = [
            [
                'title' => 'Секция 1',
                'text' => '1 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 1,
                'youtube_iframe' => '<iframe loading="lazy" width="548" height="374" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'date' => '2021-11-20 00:00:00',
            ],
            [
                'title' => 'Секция 2',
                'text' => '2 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 1,
                'youtube_iframe' => '<iframe loading="lazy" width="548" height="374" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'date' => '2021-11-20 00:00:00',
            ],
            [
                'title' => 'Секция 3',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 1,
                'youtube_iframe' => '<iframe loading="lazy" width="548" height="374" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'date' => '2021-11-20 00:00:00',
            ],
            [
                'title' => 'Секция 4',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'is_published' => 0,
                'youtube_iframe' => '<iframe loading="lazy" width="548" height="374" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'date' => '2021-11-20 00:00:00',
            ],
        ];

        $eventsData = [
            [
                'event_type_id' => 1,
                'title' => 'Дизайн-мышление в инновационных проектах type 1',
                'speaker' => 'Иванов Иван Ивнович',
                'date_from' => date('Y-m-d 12:00:00', strtotime('+1 day')),
                'date_to' => date('Y-m-d 18:00:00', strtotime('+1 day')),
                'about_speaker' => 'Спикер — это лицо бизнес-мероприятия: конференции, митапа, бизнес-завтрака, корпоратива. Он помогает сделать деловое мероприятие интересным и сформировать актуальную повестку благодаря своему опыту и харизме, объединяет участников одной идеей и создает ощущение сопричастности.',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'preview_file_id' => 4,
                'presentation_file_id' => 5,
                'photo_file_id' => 4,
                'show_button' => 1,
                'youtube_iframe' => '<iframe loading="lazy" width="448" height="292" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
            ],
            [
                'event_type_id' => 2,
                'title' => 'Дизайн-мышление в инновационных проектах type 2',
                'speaker' => 'Иванов Иван Ивнович',
                'date_from' => date('Y-m-d 12:00:00', strtotime('+1 day')),
                'date_to' => date('Y-m-d 18:00:00', strtotime('+1 day')),
                'about_speaker' => 'Спикер — это лицо бизнес-мероприятия: конференции, митапа, бизнес-завтрака, корпоратива. Он помогает сделать деловое мероприятие интересным и сформировать актуальную повестку благодаря своему опыту и харизме, объединяет участников одной идеей и создает ощущение сопричастности.',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'preview_file_id' => 4,
                'presentation_file_id' => 5,
                'photo_file_id' => 4,
                'show_button' => 1,
                'youtube_iframe' => '<iframe loading="lazy" width="448" height="292" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
            ],
            [
                'event_type_id' => 3,
                'title' => 'Дизайн-мышление в инновационных проектах type 3',
                'speaker' => 'Иванов Иван Ивнович',
                'date_from' => date('Y-m-d 12:00:00', strtotime('+1 day')),
                'date_to' => date('Y-m-d 18:00:00', strtotime('+1 day')),
                'about_speaker' => 'Спикер — это лицо бизнес-мероприятия: конференции, митапа, бизнес-завтрака, корпоратива. Он помогает сделать деловое мероприятие интересным и сформировать актуальную повестку благодаря своему опыту и харизме, объединяет участников одной идеей и создает ощущение сопричастности.',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'preview_file_id' => 4,
                'presentation_file_id' => 5,
                'photo_file_id' => 4,
                'show_button' => 1,
                'youtube_iframe' => '<iframe loading="lazy" width="448" height="292" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
            ],
            [
                'event_type_id' => 4,
                'title' => 'Дизайн-мышление в инновационных проектах type 4',
                'speaker' => 'Иванов Иван Ивнович',
                'date_from' => date('Y-m-d 12:00:00', strtotime('+1 day')),
                'date_to' => date('Y-m-d 18:00:00', strtotime('+1 day')),
                'about_speaker' => 'Спикер — это лицо бизнес-мероприятия: конференции, митапа, бизнес-завтрака, корпоратива. Он помогает сделать деловое мероприятие интересным и сформировать актуальную повестку благодаря своему опыту и харизме, объединяет участников одной идеей и создает ощущение сопричастности.',
                'short_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'full_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet.',
                'preview_file_id' => 4,
                'presentation_file_id' => 5,
                'photo_file_id' => 4,
                'show_button' => 1,
                'youtube_iframe' => '<iframe loading="lazy" width="448" height="292" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
            ],
        ];

        $eventGallery = [
            [
                'event_id' => 1,
                'photo_file_id' => 8,
                'photo_min_file_id' => 8,
            ],
            [
                'event_id' => 1,
                'photo_file_id' => 9,
                'photo_min_file_id' => 9,
            ],
            [
                'event_id' => 1,
                'photo_file_id' => 10,
                'photo_min_file_id' => 10,
            ],
            [
                'event_id' => 1,
                'photo_file_id' => 11,
                'photo_min_file_id' => 11,
            ],
            [
                'event_id' => 1,
                'photo_file_id' => 12,
                'photo_min_file_id' => 12,
            ],
            [
                'event_id' => 1,
                'photo_file_id' => 13,
                'photo_min_file_id' => 13,
            ],
        ];

        $sectionJuryData = [
            ['section_id' => 1, 'speaker' => 'Иванов Иван Иванович 1'],
            ['section_id' => 1, 'speaker' => 'Иванов Иван Иванович 2'],
            ['section_id' => 1, 'speaker' => 'Иванов Иван Иванович 3'],
            ['section_id' => 1, 'speaker' => 'Иванов Иван Иванович 4'],
            ['section_id' => 1, 'speaker' => 'Иванов Иван Иванович 5'],
            ['section_id' => 1, 'speaker' => 'Иванов Иван Иванович 6'],
            ['section_id' => 1, 'speaker' => 'Иванов Иван Иванович 7'],
        ];

        $sectionImagesData = [
            ['section_id' => 1, 'sort_num' => 7, 'img_min_file_id' => 4, 'img_file_id' => 4],
            ['section_id' => 1, 'sort_num' => 6, 'img_min_file_id' => 4, 'img_file_id' => 4],
            ['section_id' => 1, 'sort_num' => 5, 'img_min_file_id' => 4, 'img_file_id' => 4],
            ['section_id' => 1, 'sort_num' => 4, 'img_min_file_id' => 4, 'img_file_id' => 4],
            ['section_id' => 1, 'sort_num' => 3, 'img_min_file_id' => 4, 'img_file_id' => 4],
            ['section_id' => 1, 'sort_num' => 2, 'img_min_file_id' => 4, 'img_file_id' => 4],
            ['section_id' => 1, 'sort_num' => 1, 'img_min_file_id' => 4, 'img_file_id' => 4],
        ];

        $usersData = [
            [
                'full_name' => 'test1',
                'section_id' => 1,
                'phone' => '88005553535',
                'password' => '$2y$10$G/nb5hjRndxgwlMku.kYxuPp0xYPGWr0cSmay6asfzfqetw6wdVTm',
                'role_id' => 3,
                'email_confirmed' => 1,
                'is_registered' => 1,
            ],
            [
                'full_name' => 'test2',
                'section_id' => 1,
                'phone' => '88005553535',
                'password' => '$2y$10$G/nb5hjRndxgwlMku.kYxuPp0xYPGWr0cSmay6asfzfqetw6wdVTm',
                'role_id' => 3,
                'email_confirmed' => 1,
                'is_registered' => 1,
            ],
            [
                'full_name' => 'test3',
                'section_id' => 1,
                'phone' => '88005553535',
                'password' => '$2y$10$G/nb5hjRndxgwlMku.kYxuPp0xYPGWr0cSmay6asfzfqetw6wdVTm',
                'role_id' => 3,
                'email_confirmed' => 1,
                'is_registered' => 1,
            ],
            [
                'full_name' => 'test4',
                'section_id' => 1,
                'phone' => '88005553535',
                'password' => '$2y$10$G/nb5hjRndxgwlMku.kYxuPp0xYPGWr0cSmay6asfzfqetw6wdVTm',
                'role_id' => 3,
                'email_confirmed' => 1,
                'is_registered' => 1,
            ]
        ];

        $adminUsersData = [
            [
                'full_name' => 'Модератор',
                'email' => 'moderator@mail.ru',
                'password' => '$2y$10$G/nb5hjRndxgwlMku.kYxuPp0xYPGWr0cSmay6asfzfqetw6wdVTm',
                'role_id' => 2,
                'email_confirmed' => 1
            ],
            [
                'full_name' => 'Участник',
                'email' => 'member@mail.ru',
                'password' => '$2y$10$G/nb5hjRndxgwlMku.kYxuPp0xYPGWr0cSmay6asfzfqetw6wdVTm',
                'role_id' => 3,
                'email_confirmed' => 1
            ]
        ];

        $chessData = [
            [
                'date' => date('Y-m-d H:i:s', strtotime('-3 day')),
                'type' => 'Мастер класс',
                'title' => '«Эмоциональный интеллект в бизнесе» А.Э. Баснарева',
                'img_file_id' => 7,
                'img_min_file_id' => 7,
                'page_url' => '/test/events/1'
            ],
            [
                'date' => date('Y-m-d H:i:s', strtotime('-2 day')),
                'type' => 'Время эксперата',
                'title' => '«Клиентоориентированность» А.Э. Баснарева',
                'img_file_id' => 7,
                'img_min_file_id' => 7,
                'page_url' => '/test/events/2'
            ],
            [
                'date' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'type' => 'Мастер класс',
                'title' => '«Реализация высокотехнологичных инновационных проектов в Компании» И.В. Доровских',
                'img_file_id' => 0,
                'img_min_file_id' => 0,
                'page_url' => '/test/events/1'
            ],
        ];

        $acquaintanceFeedbackData = [
            [
                'user_id' => '1',
                'grade' => '1',
                'text' => 'ddddddddddddddddddddddddddddddddddddddd',
            ],
            [
                'user_id' => '1',
                'grade' => '0',
                'text' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            ],
            [
                'user_id' => '1',
                'grade' => '1',
                'text' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            ],
            [
                'user_id' => '1',
                'grade' => '0',
                'text' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            ],
        ];

        $filesData = [
            ['id' => 8, 'title' => 'photo-slide-1.jpg', 'ext_id' => 11, 'link' => 'img/photo-slide-1.jpg'],
            ['id' => 9, 'title' => 'photo-slide-1.jpg', 'ext_id' => 11, 'link' => 'img/photo-slide-1.jpg'],
            ['id' => 10, 'title' => 'photo-slide-1.jpg', 'ext_id' => 11, 'link' => 'img/photo-slide-1.jpg'],
            ['id' => 11, 'title' => 'photo-slide-1.jpg', 'ext_id' => 11, 'link' => 'img/photo-slide-1.jpg'],
            ['id' => 12, 'title' => 'photo-slide-1.jpg', 'ext_id' => 11, 'link' => 'img/photo-slide-1.jpg'],
            ['id' => 13, 'title' => 'photo-slide-1.jpg', 'ext_id' => 11, 'link' => 'img/photo-slide-1.jpg'],
        ];

        $userEventFeedbacksData = [
            ['user_id' => 1, 'event_id' => 1, 'grade' => 1, 'text' => 'Было круто! мне очень понравилось. Много интересной и полезной информации. Было круто! мне очень понравилось. Много интересной и полезной информации.'],
            ['user_id' => 2, 'event_id' => 1, 'grade' => 2, 'text' => 'Было круто! мне очень понравилось. Много интересной и полезной информации. Было круто! мне очень понравилось. Много интересной и полезной информации.'],
            ['user_id' => 3, 'event_id' => 1, 'grade' => 2, 'text' => 'Было круто! мне очень понравилось. Много интересной и полезной информации. Было круто! мне очень понравилось. Много интересной и полезной информации.'],
            ['user_id' => 4, 'event_id' => 1, 'grade' => 1, 'text' => 'Было круто! мне очень понравилось. Много интересной и полезной информации. Было круто! мне очень понравилось. Много интересной и полезной информации.'],
            ['user_id' => 5, 'event_id' => 1, 'grade' => 0, 'text' => 'Было круто! мне очень понравилось. Много интересной и полезной информации. Было круто! мне очень понравилось. Много интересной и полезной информации.'],
        ];

        // Using Query Builder
        $this->db->table('files')->insertBatch($filesData);
        $this->db->table('chess')->insertBatch($chessData);
        $this->db->table('users')->insertBatch($usersData);
        $this->db->table('users')->insertBatch($adminUsersData);
        $this->db->table('events')->insertBatch($eventsData);
        $this->db->table('event_gallery')->insertBatch($eventGallery);
        $this->db->table('section_images')->insertBatch($sectionImagesData);
        $this->db->table('business_programs')->insertBatch($businessPrograms);
        $this->db->table('archives')->insertBatch($archivesData);
        $this->db->table('news')->insertBatch($newsData);
        $this->db->table('sections')->insertBatch($sectionsData);
        $this->db->table('section_jury')->insertBatch($sectionJuryData);
        $this->db->table('chronograph_questions')->insertBatch($chronographQuestionsData);
        $this->db->table('chronograph_question_files')->insertBatch($chronographQuestionFilesData);
        $this->db->table('acquaintance_feedback')->insertBatch($acquaintanceFeedbackData);
        $this->db->table('user_event_feedbacks')->insertBatch($userEventFeedbacksData);
    }
}
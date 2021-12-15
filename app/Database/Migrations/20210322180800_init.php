<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Init extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'section_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'password_recovery' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'og_title' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'email_confirmed' => [
                'type' => 'BIT',
                'constraint' => 1,
            ],
            'is_registered' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'user_sync_at TIMESTAMP NULL DEFAULT NULL',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'value' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_confirms');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'ext_id' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'link' => [
                'type' => 'VARCHAR',
                'constraint' => '2048',
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('files');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
            'file_extension' => [
                'type' => 'VARCHAR',
                'constraint' => '64',
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('file_ext');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'description' => [
                'type' => 'TEXT'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('permissions');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'description' => [
                'type' => 'TEXT'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => '11'
            ],
            'perm_id' => [
                'type' => 'INT',
                'constraint' => '11'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('role_perm');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '256'
            ],
            'value' => [
                'type' => 'VARCHAR',
                'constraint' => '256'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'date_from TIMESTAMP NULL DEFAULT NULL',
            'date_to TIMESTAMP NULL DEFAULT NULL',
            'speaker' => [
                'type' => 'VARCHAR',
                'constraint' => '256'
            ],
            'short_text' => [
                'type' => 'TEXT'
            ],
            'full_text' => [
                'type' => 'TEXT'
            ],
            'is_published' => [
                'type' => 'BOOLEAN',
                'default' => 1
            ],
            'preview_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'preview_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'presentation_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'presentation_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'youtube_iframe TEXT CHARACTER SET UTF8MB4',
            'photo_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'photo_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('archives');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'event_type_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'speaker' => [
                'type' => 'VARCHAR',
                'constraint' => '256'
            ],
            'date_from' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'date_to' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'about_speaker TEXT CHARACTER SET UTF8MB4',
            'short_text TEXT CHARACTER SET UTF8MB4',
            'full_text TEXT CHARACTER SET UTF8MB4',
            'preview_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'preview_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'presentation_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'presentation_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'youtube_iframe TEXT CHARACTER SET UTF8MB4',
            'photo_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'photo_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'show_button' => [
                'type' => 'BOOLEAN',
                'default' => 1
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('events');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'event_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'photo_file_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'photo_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'sort_num' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('event_gallery');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('event_types');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'event_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_events');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'event_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'grade' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'text TEXT CHARACTER SET UTF8MB4',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_event_feedbacks');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'date' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'short_text TEXT CHARACTER SET UTF8MB4',
            'full_text TEXT CHARACTER SET UTF8MB4',
            'youtube_iframe TEXT CHARACTER SET UTF8MB4',
            'photo_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'photo_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'is_publication' => [
                'type' => 'BOOLEAN',
                'default' => 1
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('news');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'number' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'protection_date' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'is_publication' => [
                'type' => 'BOOLEAN',
                'default' => 1
            ],
            'preview_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'preview_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'youtube_iframe TEXT CHARACTER SET UTF8MB4',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sections');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'section_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'grade' => [
                'type' => 'BOOLEAN',
            ],
            'text TEXT CHARACTER SET UTF8MB4',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('section_feedbacks');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'section_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'sort_num' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'img_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'img_file_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('section_images');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'section_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'speaker' => [
                'type' => 'VARCHAR',
                'constraint' => 256,
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('section_jury');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'user_email' => [
                'type' => 'VARCHAR',
                'constraint' => '256'
            ],
            'text' => [
                'type' => 'VARCHAR',
                'constraint' => 1024,
            ],
            'subject' => [
                'type' => 'VARCHAR',
                'constraint' => 524,
            ],
            'send_date' => [
                'type' => 'TIMESTAMP',
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mailer');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'request' => [
                'type' => 'VARCHAR',
                'constraint' => 1024,
            ],
            'data' => [
                'type' => 'VARCHAR',
                'constraint' => 1024,
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('logs');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ],
            'sync_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('groups');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_group');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ],
            'text TEXT CHARACTER SET UTF8MB4',
            'is_published' => [
                'type' => 'BOOLEAN',
            ],
            'date TIMESTAMP NULL DEFAULT NULL',
            'photo_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'photo_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'youtube_iframe TEXT CHARACTER SET UTF8MB4',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('business_programs');

        /**
         * Знакомство
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ],
            'text TEXT CHARACTER SET UTF8MB4',
            'youtube_iframe TEXT CHARACTER SET UTF8MB4',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('acquaintance');

        /**
         * Отзывы на странице знакомств
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'grade' => [
                'type' => 'BOOLEAN',
            ],
            'text TEXT CHARACTER SET UTF8MB4',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('acquaintance_feedback');

        /**
         * Основные данные конференции
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ],
            'sub_title' => [
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ],
            'logo_file_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'logo_min_file_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'date' => [
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ],
            'specialist_num' => [
                'type' => 'VARCHAR',
                'constraint' => '524',
            ],
            'og_num' => [
                'type' => 'VARCHAR',
                'constraint' => '524',
            ],
            'experts_num' => [
                'type' => 'VARCHAR',
                'constraint' => '524',
            ],
            'sections_num' => [
                'type' => 'VARCHAR',
                'constraint' => '524',
            ],
            'projects_num' => [
                'type' => 'VARCHAR',
                'constraint' => '524',
            ],
            'eventicious_api_key' => [
                'type' => 'VARCHAR',
                'constraint' => '524',
            ],
            'timer TIMESTAMP NULL DEFAULT NULL',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('conference');

        /**
         * Сортировка блоков на главной странице
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'number' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'hide' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 1
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sort_blocks');

        /**
         * Сортировка элементов навигации
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'number' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sort_navigation_block_items');

        /**
         * Шахматка на главной странице
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'date' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'page_url' => [
                'type' => 'VARCHAR',
                'constraint' => '1024'
            ],
            'img_file_id' => [
                'type' => 'VARCHAR',
                'constraint' => '1024'
            ],
            'img_min_file_id' => [
                'type' => 'VARCHAR',
                'constraint' => '1024'
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('chess');

        /**
         * Хронограф
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'text TEXT CHARACTER SET UTF8MB4',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('chronograph');

        /**
         * Вопросы на странице хронграфа
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'number' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'text TEXT CHARACTER SET UTF8MB4',
            'youtube_iframe TEXT CHARACTER SET UTF8MB4',
            'show' => [
                'type' => 'BOOLEAN',
                'default' => 0
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('chronograph_questions');

        /**
         * Файлы вопросов на странице хронграфа
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'chronograph_question_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'type_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'file_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('chronograph_question_files');

        /**
         * Типы файлов вопросов на странице хронографа
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '512'
            ],
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('chronograph_question_file_types');

        /**
         * Ответы на вопросы на странице хронографа
         */
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'chronograph_question_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'text TEXT CHARACTER SET UTF8MB4',
            'deleted_at TIMESTAMP NULL DEFAULT NULL',
            'updated_at TIMESTAMP NULL DEFAULT NULL',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('chronograph_question_answers');
    }

    public function down()
    {
        $this->forge->dropTable('users');
        $this->forge->dropTable('user_confirms');
        $this->forge->dropTable('files');
        $this->forge->dropTable('file_ext');
        $this->forge->dropTable('permissions');
        $this->forge->dropTable('roles');
        $this->forge->dropTable('role_perm');
        $this->forge->dropTable('settings');
        $this->forge->dropTable('archives');
        $this->forge->dropTable('events');
        $this->forge->dropTable('event_gallery');
        $this->forge->dropTable('user_events');
        $this->forge->dropTable('user_event_feedbacks');
        $this->forge->dropTable('news');
        $this->forge->dropTable('sections');
        $this->forge->dropTable('section_feedbacks');
        $this->forge->dropTable('section_images');
        $this->forge->dropTable('section_jury');
        $this->forge->dropTable('mailer');
        $this->forge->dropTable('logs');
        $this->forge->dropTable('user_sync');
        $this->forge->dropTable('groups');
        $this->forge->dropTable('user_group');
        $this->forge->dropTable('business_programs');
        $this->forge->dropTable('acquaintance');
        $this->forge->dropTable('acquaintance_feedback');
        $this->forge->dropTable('conference');
        $this->forge->dropTable('sort_blocks');
        $this->forge->dropTable('sort_navigation_block_items');
        $this->forge->dropTable('chess');
        $this->forge->dropTable('chronograph');
        $this->forge->dropTable('chronograph_questions');
        $this->forge->dropTable('chronograph_question_files');
        $this->forge->dropTable('chronograph_question_file_types');
        $this->forge->dropTable('chronograph_question_answers');
    }
}
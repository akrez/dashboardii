<?php

use yii\db\Migration;

class m220922_180933_create_table_menu_visits extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%menu_visits}}',
            [
                'id' => $this->bigPrimaryKey()->unsigned(),
                'user_id' => $this->bigInteger()->unsigned(),
                'menu_id' => $this->bigInteger()->unsigned(),
                'submenu' => $this->string(),
                'user_agent' => $this->string(2048),
                'created_at' => $this->timestamp(),
            ],
            $tableOptions
        );

        $this->createIndex('user_id', '{{%menu_visits}}', ['user_id']);
        $this->createIndex('menu_id', '{{%menu_visits}}', ['menu_id']);

        $this->addForeignKey(
            'menu_visits_ibfk_1',
            '{{%menu_visits}}',
            ['menu_id'],
            '{{%menus}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'menu_visits_ibfk_2',
            '{{%menu_visits}}',
            ['user_id'],
            '{{%users}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%menu_visits}}');
    }
}

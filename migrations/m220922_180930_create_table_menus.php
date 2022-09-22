<?php

use yii\db\Migration;

class m220922_180930_create_table_menus extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%menus}}',
            [
                'id' => $this->bigPrimaryKey()->unsigned(),
                'title' => $this->string()->notNull(),
                'user_id' => $this->bigInteger()->unsigned()->notNull(),
                'headers' => $this->text(),
                'submenu' => $this->string(12),
                'grid_where_like' => $this->string(12),
                'deleted_at' => $this->timestamp()->null(),
                'created_at' => $this->timestamp()->null(),
                'updated_at' => $this->timestamp()->null(),
            ],
            $tableOptions
        );

        $this->createIndex('user_id', '{{%menus}}', ['user_id']);

        $this->addForeignKey(
            'menus_ibfk_1',
            '{{%menus}}',
            ['user_id'],
            '{{%users}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%menus}}');
    }
}

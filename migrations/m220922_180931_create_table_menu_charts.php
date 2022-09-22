<?php

use yii\db\Migration;

class m220922_180931_create_table_menu_charts extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%menu_charts}}',
            [
                'id' => $this->bigPrimaryKey()->unsigned(),
                'title' => $this->string()->notNull(),
                'chart_aggregation' => $this->string(12),
                'chart_axis_x' => $this->string(12),
                'chart_where_like' => $this->string(12),
                'chart_axis_y' => $this->string(12),
                'priority' => $this->integer(),
                'chart_type' => $this->string(12)->notNull(),
                'menu_id' => $this->bigInteger()->unsigned()->notNull(),
                'chart_width_12' => $this->tinyInteger(4)->notNull(),
                'deleted_at' => $this->timestamp()->null(),
                'created_at' => $this->timestamp()->null(),
                'updated_at' => $this->timestamp()->null(),
            ],
            $tableOptions
        );

        $this->createIndex('menu_id', '{{%menu_charts}}', ['menu_id']);

        $this->addForeignKey(
            'menu_charts_ibfk_1',
            '{{%menu_charts}}',
            ['menu_id'],
            '{{%menus}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%menu_charts}}');
    }
}

<?php

use yii\db\Migration;

class m220922_180932_create_table_menu_contents extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%menu_contents}}',
            [
                'id' => $this->bigPrimaryKey()->unsigned(),
                'menu_id' => $this->bigInteger()->unsigned()->notNull(),
                'step' => $this->integer()->notNull(),
                'deleted_at' => $this->timestamp(),
                'created_at' => $this->timestamp(),
                'updated_at' => $this->timestamp(),
                'column_a' => $this->string(),
                'column_b' => $this->string(),
                'column_c' => $this->string(),
                'column_d' => $this->string(),
                'column_e' => $this->string(),
                'column_f' => $this->string(),
                'column_g' => $this->string(),
                'column_h' => $this->string(),
                'column_i' => $this->string(),
                'column_j' => $this->string(),
                'column_k' => $this->string(),
                'column_l' => $this->string(),
                'column_m' => $this->string(),
                'column_n' => $this->string(),
                'column_o' => $this->string(),
                'column_p' => $this->string(),
                'column_q' => $this->string(),
                'column_r' => $this->string(),
                'column_s' => $this->string(),
                'column_t' => $this->string(),
                'column_u' => $this->string(),
                'column_v' => $this->string(),
                'column_w' => $this->string(),
                'column_x' => $this->string(),
                'column_y' => $this->string(),
                'column_z' => $this->string(),
            ],
            $tableOptions
        );

        $this->createIndex('menu_id', '{{%menu_contents}}', ['menu_id']);

        $this->addForeignKey(
            'menu_contents_ibfk_1',
            '{{%menu_contents}}',
            ['menu_id'],
            '{{%menus}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%menu_contents}}');
    }
}

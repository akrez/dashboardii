<?php

use yii\db\Migration;

class m220922_180929_create_table_users extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%users}}',
            [
                'id' => $this->bigPrimaryKey()->unsigned(),
                'name' => $this->string()->notNull(),
                'email' => $this->string()->notNull(),
                'email_verified_at' => $this->timestamp(),
                'password' => $this->string()->notNull(),
                'remember_token' => $this->string(100),
                'api_token' => $this->string(80),
                'mobile' => $this->string(15)->notNull(),
                'created_at' => $this->timestamp(),
                'updated_at' => $this->timestamp(),
            ],
            $tableOptions
        );

        $this->createIndex('api_token', '{{%users}}', ['api_token'], true);
        $this->createIndex('users_email_unique', '{{%users}}', ['email'], true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}

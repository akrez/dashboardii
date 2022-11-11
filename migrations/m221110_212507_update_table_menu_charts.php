<?php

use yii\db\Migration;

class m221110_212507_update_table_menu_charts extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%menu_charts}}', 'chart_group_by', $this->string(12)->after('chart_axis_y'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%menu_charts}}', 'chart_group_by');
    }
}

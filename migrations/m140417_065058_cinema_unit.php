<?php

class m140417_065058_cinema_unit extends \yii\db\Migration
{
    public function up()
    {
        return $this->createTable('cinema_unit', array(
            'id'    => 'pk',
            'title' => 'string'
        ));
    }

    public function down()
    {
        return $this->dropTable('cinema_unit');
    }
}

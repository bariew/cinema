<?php

class m140417_081300_cinema_hall extends \yii\db\Migration
{
    public function up()
    {
        return $this->createTable('cinema_hall', array(
            'id'            => 'pk',
            'unit_id'       => 'integer',
            'title'         => 'string',
            'places'        => 'text'
        ));
    }

    public function down()
    {
        return $this->dropTable('cinema_hall');
    }
}

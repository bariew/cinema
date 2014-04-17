<?php

class m140417_081321_cinema_session extends \yii\db\Migration
{
    public function up()
    {
        return $this->createTable('cinema_session', array(
            'id'            => 'pk',
            'unit_id'       => 'integer',
            'hall_id'       => 'integer',
            'film_id'       => 'integer',
            'places'        => 'text',
            'starttime'     => 'datetime',
            'length'        => 'integer',
            'unit_title'    => 'string',
            'hall_title'    => 'string',
            'film_title'    => 'string',
        ));
    }

    public function down()
    {
        return $this->dropTable('cinema_session');
    }
}

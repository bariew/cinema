<?php

class m140417_081329_cinema_order extends \yii\db\Migration
{
    public function up()
    {
        return $this->createTable('cinema_order', array(
            'id'            => 'string UNIQUE PRIMARY KEY',
            'unit_id'       => 'integer',
            'session_id'    => 'integer',
            'places'        => 'text',
            'cost'          => 'DECIMAL(10,2) DEFAULT 0'
        ));
    }

    public function down()
    {
        return $this->dropTable('cinema_order');
    }
}

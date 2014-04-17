<?php
class m140417_081307_cinema_film extends \yii\db\Migration
{
    public function up()
    {
        return $this->createTable('cinema_film', array(
            'id'            => 'pk',
            'title'         => 'string',
            'length'        => 'integer',
            'image'         => 'string',
            'description'   => 'text'
        ));
    }

    public function down()
    {
        return $this->dropTable('cinema_film');
    }
}

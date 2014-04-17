<?php

class m140417_102941_cinema_data extends \yii\db\Migration
{
    private $units = [
        ['Alpha'], ['Beta'], ['Gamma'], ['Delta'], ['Epsilon']
    ];
    
    private $halls = [
        ['N1'], ['N2'], ['N3'], ['N4'], ['N5']
    ];
    
    private $films = [
        ['Star Wars I', '120'],
        ['Indiana Jones', '100'],
        ['Lion King', '90'],
        ['Psycho', '110'],
        ['Kung fu hustle', '105'],
        ['Moulin Rouge', '120'],
        ['Titanic', '95'],
        ['First Blood', '102'],
    ];
    
    private $places = [
        1 => [1,2,3,4,5,6,7,8],
        2 => [1,2,3,4,5,6,7,8,9],
        3 => [1,2,3,4,5,6,7,8,9,10],
        4 => [1,2,3,4,5,6,7,8,9,10],
        5 => [1,2,3,4,5,6,7,8,9,10],
    ];
    
    
    public function up()
    {
        $places = $this->places;
        $this->batchInsert('{{cinema_unit}}', ['title'], $this->units);
        $this->batchInsert('{{cinema_film}}', ['title', 'length'], $this->films);
        // generating halls
        $allHalls = array();
        foreach(app\modules\cinema\models\Unit::find()->all() as $unit){
            $halls = $this->halls;
            array_walk($halls, function(&$var) use($unit, $places){
                $var[] = $unit->id;
                $var[] = json_encode($places);
            });
            $allHalls = array_merge($allHalls, $halls);
        }
        $this->batchInsert('{{cinema_hall}}', ['title', 'unit_id', 'places'], $allHalls);
        // generating sessions
        $films = app\modules\cinema\models\Film::find()->all();
        $units = yii\helpers\ArrayHelper::index(
            app\modules\cinema\models\Unit::find()->all(),
        'id');
        $sessions = [];
        foreach(app\modules\cinema\models\Hall::find()->all() as $hall){
            $hour = '09';
            shuffle($films);
            foreach($films as $film){
                $sessions[] = [
                    $hall->unit_id, $hall->id, $film->id, 
                    json_encode($places), date("Y-m-d {$hour}:00"), 
                    $units[$hall->unit_id]->title, $hall->title, 
                    $film->title, $film->length
                ];
                $hour +=2;
            }
        }
        $this->batchInsert(
            '{{cinema_session}}', 
            ['unit_id', 'hall_id', 'film_id', 'places', 'starttime', 'unit_title', 'hall_title', 'film_title', 'length'], 
            $sessions
        );
    }

    public function down()
    {
        foreach (['{{cinema_unit}}', '{{cinema_hall}}', '{{cinema_film}}', '{{cinema_session}}'] as $table){
            $this->truncateTable($table);
        }
    }
}

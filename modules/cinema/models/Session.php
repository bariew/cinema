<?php

namespace app\modules\cinema\models;

/**
 * This is the model class for table "cinema_session".
 *
 * @property integer $id
 * @property integer $unit_id
 * @property integer $hall_id
 * @property integer $film_id
 * @property string $places
 * @property string $starttime
 * @property integer $length
 * @property string $hall_title
 * @property string $film_title
 */
class Session extends \yii\db\ActiveRecord
{
    public function savePlaces($add = [], $remove = [])
    {
        $allPlaces = $this->places;
        $busy = [];
        foreach ($add as $key => $places){
            $this->addPlaces($allPlaces, $key, array_merge($allPlaces[$key], $places));
        }
        foreach ($remove as $key => $places) {
            if(count(array_intersect($places, $allPlaces[$key])) != count($places)){
                $busy[$key] = array_diff($places, $allPlaces[$key]);
            }
            $this->addPlaces($allPlaces, $key, array_diff($allPlaces[$key], $places));
        }
        if($busy){
            throw new \yii\web\HttpException(400, "Some places are already busy: " . json_encode($busy));
        }
        $this->places = $allPlaces;
        $this->save();
    }
    
    private function addPlaces(&$places, $key, $data)
    {
        $data = array_unique($data);
        asort($data);
        $places[$key] = array_values($data);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cinema_session';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id', 'hall_id', 'film_id', 'length'], 'integer'],
            [['places'], 'safe'],
            [['starttime'], 'safe'],
            [['hall_title', 'film_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'hall_id' => 'Hall ID',
            'film_id' => 'Film ID',
            'places' => 'Places',
            'starttime' => 'Starttime',
            'length' => 'Length',
            'hall_title' => 'Hall Title',
            'film_title' => 'Film Title',
        ];
    }
    
    public function behaviors()
    {
        return [
            'queueBehavior'     => [
                'class' => \app\components\QueueArBehavior::className(),
            ],
            'stringifyBehavior' => [
                'class' => \app\components\StringBehavior::className(),
                'attributes' => ['places'],
            ],
        ];
    }
}

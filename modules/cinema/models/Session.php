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
        $searchPlaces = json_encode($this->places);
        foreach ($remove as $key => $places) {
            $this->places[$key] = array_diff($this->places[$key], $places);
        }
        foreach ($add as $key => $places){
            $this->places[$key] = array_values(array_unique(array_merge($this->places[$key], $places)));
        }
        if(!$this->updateAll(['places'=>json_encode($this->places)], "id={$this->id} AND places='{$searchPlaces}'")){
            throw new \yii\web\HttpException(400, 'Places are busy!');
        }
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
            'stringifyBehavior' => [
                'class' => \app\components\StringBehavior::className(),
                'attributes' => ['places'],
            ],
        ];
    }
}

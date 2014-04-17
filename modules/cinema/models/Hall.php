<?php

namespace app\modules\cinema\models;

use Yii;

/**
 * This is the model class for table "cinema_hall".
 *
 * @property integer $id
 * @property integer $unit_id
 * @property string $title
 * @property string $places
 */
class Hall extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cinema_hall';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id'], 'integer'],
            [['places'], 'safe'],
            [['title'], 'string', 'max' => 255]
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
            'title' => 'Title',
            'places' => 'Places',
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

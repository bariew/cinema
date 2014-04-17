<?php

namespace app\modules\cinema\models;

use Yii;

/**
 * This is the model class for table "cinema_film".
 *
 * @property integer $id
 * @property string $title
 * @property integer $length
 * @property string $image
 * @property string $description
 */
class Film extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cinema_film';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['length'], 'integer'],
            [['description'], 'string'],
            [['title', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'length' => 'Length',
            'image' => 'Image',
            'description' => 'Description',
        ];
    }
}

<?php

namespace app\modules\cinema\models;

/**
 * This is the model class for table "cinema_order".
 *
 * @property integer $id
 * @property integer $unit_id
 * @property integer $session_id
 * @property string $token
 * @property string $places
 * @property string $cost
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cinema_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id', 'session_id'], 'integer'],
            [['places'], 'safe'],
            [['cost'], 'number'],
            [['token'], 'string', 'max' => 255]
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
            'session_id' => 'Session ID',
            'token' => 'Token',
            'places' => 'Places',
            'cost' => 'Cost',
        ];
    }
    
    public function behaviors()
    {
        return [
            'stringifyBehavior' => [
                'class' => \app\components\StringBehavior::className(),
                'attributes' => ['places'],
            ],
            'oldAttributesBehavior' => [
                'class' => \app\components\AttributesBehavior::className(),
            ],
        ];
    }
    
    public function getSession()
    {
        return $this->hasOne(\app\modules\cinema\models\Session, ['id'=>'session_id']);
    }
    
    public function beforeSave($insert) 
    {
        if(!parent::beforeSave($insert)){
            return false;
        }
        if($this->isNewRecord){
            $this->token = $this->generateToken();
        }
        if($this->oldAttributesBehavior->changed('places')){
            $this->getSession()
                ->savePlaces($this->oldAttributesBehavior->attributes, $this->places);
        }
        
        //return true;
    }
    
    public function beforeDelete() 
    {
        if(!parent::beforeDelete()){
            return false;
        }
        $limitDate = date('Y-m-d H:i', strtotime('+1hour'));
        if(!$session = $this->getSession()){
            return true;
        }
        if($session->starttime < $limitDate){
            throw new \yii\web\HttpException(403, 'Deletion denied due to session start time limit');
        }else{
            $session->savePlaces($this->places);
        }
        return true;
    }
    
    private function generateToken()
    {
        return time() . substr(md5($this->places . microtime()), 0, 7);
    }
}
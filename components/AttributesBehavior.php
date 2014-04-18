<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class AttributesBehavior extends Behavior
{
    public $oldAttributes2 = array();
    
    public function events() 
    {
        return [
            ActiveRecord::EVENT_INIT            => 'setOldAttributes',
            ActiveRecord::EVENT_AFTER_FIND      => 'setOldAttributes',
        ];
    }
    
    public function setOldAttributes()
    {
        $this->oldAttributes2 = $this->owner->attributes;
    }
    
    public function attributeChanged($attribute)
    {
        return $this->oldAttributes2[$attribute] !== $this->owner->attributes[$attribute];
    }
}

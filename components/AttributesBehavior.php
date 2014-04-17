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
    public $attributes = array();
    
    public function events() 
    {
        return [
            ActiveRecord::EVENT_INIT            => 'setOldAttributes',
            ActiveRecord::EVENT_AFTER_FIND      => 'setOldAttributes',
        ];
    }
    
    public function setOldAttributes()
    {
        $this->attributes = $this->owner->attributes;
    }
    
    public function changed($attribute)
    {
        return $this->attributes[$attribute] !== $this->owner->attributes[$attribute];
    }
}

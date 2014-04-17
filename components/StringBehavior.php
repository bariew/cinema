<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StringBehavior extends Behavior
{
    public $attributes = array();
    
    public function events() 
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT   => 'stringify',
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'stringify',
            ActiveRecord::EVENT_AFTER_FIND      => 'unstringify',
            ActiveRecord::EVENT_AFTER_INSERT    => 'unstringify',
            ActiveRecord::EVENT_AFTER_UPDATE    => 'unstringify',
        ];
    }
    
    public function stringify()
    {
        foreach ($this->attributes as $attribute) {
            $this->owner->$attribute = json_encode($this->owner->$attribute);
        }
    }
    
    public function unstringify()
    {
        foreach ($this->attributes as $attribute) {
            $this->owner->$attribute = json_decode($this->owner->$attribute);
        }
    }
}

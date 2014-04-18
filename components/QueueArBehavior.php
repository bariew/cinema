<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class QueueArBehavior extends Behavior
{
       
    public function events() 
    {
        return array_merge(parent::events(), [
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'setQueue',
            ActiveRecord::EVENT_AFTER_UPDATE    => 'unsetQueue',
        ]);
    }
    
    public function setQueue()
    {
        if(Yii::$app->cache->exists($this->getKey())){
            throw new \yii\web\HttpException(400, 'Saving is busy with another process');
        }
        Yii::$app->cache->add($this->getKey(), 1, 1);
    }
    
    public function unsetQueue()
    {
        Yii::$app->cache->delete($this->getKey());
    }
    
    private function getKey()
    {
        return get_class($this->owner). $this->owner->id . get_class($this);
    }
}

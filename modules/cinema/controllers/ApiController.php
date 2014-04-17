<?php

namespace app\modules\cinema\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

class ApiController extends ActiveController
{
    public function init() 
    {
        $this->setModelClass();
        parent::init();    
    }
    
    public function actions() 
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = array($this, 'filterIndex');
        return $actions;
    }
    
    public function filterIndex()
    {
        $modelClass = $this->modelClass;
        return new ActiveDataProvider([
            'query' => $modelClass::find()->where(@$_GET[$this->getShortModelClass()]),
        ]);
    }
    
    public function setModelClass()
    {
        return $this->modelClass = str_replace(
            ['controllers', 'Controller'], 
            ['models', ''], 
            get_called_class()
        );
    }
    
    public function getShortModelClass()
    {
        return end(explode('\\', $this->modelClass));
    }
}

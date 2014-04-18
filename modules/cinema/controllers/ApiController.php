<?php

namespace app\modules\cinema\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use Yii;

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
        $params = array_diff_key(
            Yii::$app->request->queryParams,
            array_flip(['q', 'page', 'per-page'])
        );
        return new ActiveDataProvider([
            'query' => $modelClass::find()->where($params),
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
}

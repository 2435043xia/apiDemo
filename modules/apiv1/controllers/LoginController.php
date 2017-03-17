<?php

class LoginController extends \yii\rest\ActiveController
{
    public $modelClass = "app\models\user";

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionCreate()
    {
    }
}
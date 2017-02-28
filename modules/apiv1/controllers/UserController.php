<?php
namespace api\modules\apiv1\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $ModelClass = "app\models\User";
}
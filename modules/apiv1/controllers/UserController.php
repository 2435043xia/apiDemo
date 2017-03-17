<?php
namespace app\modules\apiv1\controllers;

use Yii;
use app\models\User;
use app\models\SignupForm;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;

class UserController extends ActiveController
{
    public $modelClass = "app\models\user";

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }
    public function bahaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }
    public function actionCreate()
    {
        Yii::$app->response->headers->add("Access-Control-Allow-Origin","*");
        Yii::$app->response->headers->add("Access-Control-Allow-Methods","*");
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post(),'')){
            if($user = $model->signup()){
                return ['code' => true,'message' => 'Congratulation! Sign up!'];
            }else{
                return ['code' => false,'message' => 'Sorry'];
            }
        }else{
        }
    }
}
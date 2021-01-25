<?php

namespace backend\controllers;

use backend\models\Admin;
use common\base\BaseController;
use common\base\MyViewAction;
use common\models\form\LoginForm;
use common\tools\Code;
use common\tools\Tool;
use common\traits\BaseAction;
use Yii;
use yii\rest\ViewAction;

class AdminController extends BaseController
{
//    public function actions()
//    {
//        $this->id = \Yii::$app->user->identity->id;
//        $actions = [
//            'view' => [
//                'class' => MyViewAction::class,
//                'modelClass' => $this->modelClass,
//                'checkAccess' => [$this, 'checkAccess'],
//                'id' =>  $this->id
//            ],
//        ];
//        return $actions;
//    }
    public function actionInfo()
    {
        return Admin::find()->where(['id' => $this->id])->select('username,head_portrait')->getArrayOne();
    }

    public function actionLogout()
    {
        $redisKey = 'ADMIN:LOGIN:' . $this->id;
        return Yii::$app->redis->del($redisKey);
    }


}

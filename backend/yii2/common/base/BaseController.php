<?php

namespace common\base;


use backend\models\Admin;
use common\models\base\OperationLog;
use common\tools\Code;
use common\tools\Common;
use common\tools\Tool;
use common\traits\BaseAction;
use frontend\models\User;
use Yii;
use yii\rest\ActiveController;
use yii\rest\Serializer;

class BaseController extends ActiveController
{
    use BaseAction;
    public $id;

    public $serializer = [
        'class' => Serializer::class,
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();
        // 禁用 "delete" 和 "create" 动作
        unset($actions['delete'], $actions['create'], $actions['view'], $actions['update']);
        // 使用 "prepareDataProvider()" 方法自定义数据 provider
        $actions['index']['prepareDataProvider'] = [$this, 'index'];
        return $actions;
    }

    /**
     * Created by Mr.亮先生.
     * program: love
     * FuncName:verbs
     * status:
     * User: Mr.liang
     * Date: 2021/6/2
     * Time: 15:06
     * Email:1695699447@qq.com
     * @return array
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'POST'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['POST'],
            'delete' => ['GET'],
        ];
    }

    public function checkToken()
    {
        $token = $this->headers['x-token'] ?? null;
        if (!$token) {
            echo json_encode(['code' => Code::getTokenCode(), 'message' => '请检查Token重试']);
            exit();
        }
        $token = base64_decode($token);
        $tokenArray = explode(':&:', $token);
        if (count($tokenArray) !== 3) {
            echo json_encode(['code' => Code::getTokenCode(), 'message' => '非法Token']);
            exit();
        }
        if ($tokenArray[1] < time()) {
            echo json_encode(['code' => Code::getTokenCode(), 'message' => '登陆过期请从新登陆']);
            exit();
        }
        $modelClass = null;
        if (Yii::$app->id === 'love-backend') {
            $redisKey = "ADMIN:LOGIN:" . $tokenArray[2];
            $modelClass = Admin::class;
        } else {
            $redisKey = "USER:LOGIN:" . $tokenArray[2];
            $modelClass = User::class;
        }
        $info = Yii::$app->redis->get($redisKey);
        if (!$info) {
            echo json_encode(['code' => Code::getTokenCode(), 'message' => '登陆过期请从新登陆']);
            exit();
        }
        $info = $modelClass::findIdentity($tokenArray[2]);
        if ((int)$info->status !== 1) {
            echo json_encode(['code' => Code::getTokenCode(), 'message' => '该账号状态异常']);
            exit();
        }
        Yii::$app->user->login($info);
        $this->id = $info->id;
    }
}

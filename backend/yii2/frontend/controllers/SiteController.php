<?php

namespace frontend\controllers;

use common\tools\Code;
use frontend\models\RegisterForm;
use frontend\models\User;
use common\models\form\LoginForm;
use common\tools\Tool;
use common\traits\BaseAction;
use yii\web\Controller;


/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends Controller
{
    use BaseAction;


    /**
     * 登陆
     * Created by Mr.亮先生.
     * program: love
     * FuncName:actionLogin
     * status:
     * User: Mr.liang
     * Date: 2021/1/25
     * Time: 15:04
     * Email:1695699447@qq.com
     * @return array
     */
    public function actionLogin(): array
    {
        $model = new LoginForm();
        $model->setScenario('user');
        $model->load(Tool::getRequestData(), '');
        if ($model->validate()) {
            return Tool::success('登陆成功', $model->getAccessToken());
        }
        $msg = Tool::getFirstErrorMessage($model->firstErrors);
        return Tool::notice($msg);
    }

    /**
     * 注册
     * Created by Mr.亮先生.
     * program: love
     * FuncName:actionRegister
     * status:
     * User: Mr.liang
     * Date: 2021/1/25
     * Time: 15:04
     * Email:1695699447@qq.com
     * @return array
     */
    public function actionRegister(): array
    {
        $model = new RegisterForm();
        $model->load(Tool::getRequestData(), '');
        if ($model->validate()) {
            return $model->save();
        }
        $msg = Tool::getFirstErrorMessage($model->firstErrors);
        return Tool::notice($msg);
    }

    public function actionError(): array
    {
        return ['code' => Code::getNoFindCode(), 'message' => '该页面没找到'];
    }
}

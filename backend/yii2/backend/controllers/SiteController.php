<?php

namespace backend\controllers;

use backend\models\Admin;
use common\models\form\LoginForm;
use common\tools\Code;
use common\tools\Tool;
use common\traits\BaseAction;
use yii\rest\Controller;

class SiteController extends Controller
{
    use BaseAction;

    public function actionLogin(): array
    {
        $model = new LoginForm();
        $model->load(Tool::getRequestData(), '');
        if ($model->validate()) {
            return Tool::success('登陆成功', $model->getAccessToken());
        }
        $msg = Tool::getFirstErrorMessage($model->firstErrors);
        return Tool::notice($msg);
    }

    public function actionIndex(): string
    {
        return 'api';
    }

    public function actionError(): array
    {
        return ['code' => Code::getNoFindCode(), 'message' => '该页面没找到'];
    }

}

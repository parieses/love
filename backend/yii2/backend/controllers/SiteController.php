<?php

namespace backend\controllers;

use common\tools\Code;
use common\tools\Tool;
use common\traits\BaseAction;
use yii\web\Controller;


class SiteController extends Controller
{
    use BaseAction;

    public function actionLogin()
    {

    }

    public function actionError(): array
    {
        return ['code' => Code::getNoFindCode(), 'message' => '该页面没找到'];
    }
}

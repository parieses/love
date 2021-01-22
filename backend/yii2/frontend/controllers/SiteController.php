<?php

namespace frontend\controllers;

use common\traits\BaseAction;
use yii\web\Controller;


/**
 * Site controller
 */
class SiteController extends Controller
{
    use BaseAction;


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $a = 0;
        for ($i = 0; $i < 10000000000; $i++) {
            $a += $i;
        }
        return $a;
    }
}

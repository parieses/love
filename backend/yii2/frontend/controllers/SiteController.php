<?php

namespace frontend\controllers;

use common\models\UserGroup;
use common\tools\Code;
use Exception;
use frontend\models\RegisterForm;
use frontend\models\User;
use common\models\form\LoginForm;
use common\tools\Tool;
use common\traits\BaseAction;
use Yii;
use yii\base\UserException;
use yii\web\Controller;


/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends Controller
{
    use BaseAction;
    public $defaultAction = 'synopsis';

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
    public function actionRegister()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new RegisterForm();
            $data = Tool::getRequestData();
            $model->load($data, '');
            if (!$model->validate()) {
                $msg = Tool::getFirstErrorMessage($model->firstErrors);
                throw new UserException($msg);
            }
            if (!$model->save()) {
                $msg = Tool::getFirstErrorMessage($model->firstErrors);
                throw new UserException($msg);
            }
            $msg = '';
            //判断是否有邀请码
            if (isset($data['code']) && $id = Yii::$app->redis->get($data['code'])) {
                $originator = User::findOne(['id' => $id, 'status' => [0, 1]]);
                if (!$originator) {
                    $msg = ',该邀请人不存在';
                } else {
                    if ($originator->gender == $data['gender']) {
                        $msg = ',不能和同性别组队';
                    } else {
                        $groupModel = UserGroup::findOne(['originator_id' => $id, 'status' => 0, 'join_id' => 0]);
                        if ($groupModel) {
                            $groupModel->join_id = $model->id;
                            if (!$groupModel->save()) {
                                $msg = Tool::getFirstErrorMessage($groupModel->firstErrors);
                                throw new UserException($msg);
                            } else {
                                $msg = ',并组队成功';
                            }
                        } else {
                            $msg = ',该邀请链接不存在或已组队成功';
                        }
                    }
                }
            }
            $transaction->commit();
            return Tool::success('注册成功' . $msg);
        } catch (Exception $e) {
            $transaction->rollBack();
            return Tool::notice($e->getMessage());
        }
    }

    public function actionError(): array
    {
        return ['code' => Code::getNoFindCode(), 'message' => '该页面没找到'];
    }

    public function actionSynopsis()
    {
        return 'API';
    }
}

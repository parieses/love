<?php

namespace backend\controllers;

use backend\models\MenuForm;
use common\tools\Tool;
use Yii;
use common\models\Menu;
use common\models\MenuSearch;
use common\base\BaseController;
use yii\base\UserException;
use yii\web\NotFoundHttpException;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends BaseController
{
    public $modelClass = Menu::class;//默认一个值

    public function index()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Tool::getRequestData());
        return $dataProvider;
    }


    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuForm();
        $model->setScenario('created');
        $model->load(Tool::getRequestData(), '');
        if ($model->validate() && $model->save()) {
            return Tool::success('创建成功');
        }
        $msg = Tool::getFirstErrorMessage($model->firstErrors);
        return Tool::error('创建失败', $msg);
    }


    public function actionUpdate()
    {
        $data = Tool::getRequestData();
        $model = MenuForm::findOne($data['id']);
        $model->setScenario('update');
        $model->load(Tool::getRequestData(), '');
        if ($model->validate() && $model->save()) {
            return Tool::success('修改成功');
        }
        $msg = Tool::getFirstErrorMessage($model->firstErrors);
        return Tool::error('修改失败', $msg);
    }

    /**
     * Created by Mr.亮先生.
     * program: love
     * FuncName:actionDelete
     * status:
     * User: Mr.liang
     * Date: 2021/6/2
     * Time: 15:10
     * Email:1695699447@qq.com
     * @param $id
     * @return array
     * @throws UserException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = -1;
        return $model->save() ? Tool::success('删除成功') : Tool::error('删除失败');
    }

    /**
     * Created by Mr.亮先生.
     * program: love
     * FuncName:findModel
     * status:
     * User: Mr.liang
     * Date: 2021/6/2
     * Time: 14:54
     * Email:1695699447@qq.com
     * @param $id
     * @return Menu|null
     * @throws UserException
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new UserException('不存在该记录');
    }
}

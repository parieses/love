<?php

namespace frontend\controllers;

use common\base\BaseController;
use common\models\UserGroup;
use common\tools\Tool;


class UserGroupController extends BaseController
{

    public $modelClass = UserGroup::class;

    public function actionCreate()
    {
        $data = Tool::getRequestData();
        $model = UserGroup::findOne(['originator_id' => $this->id]) ?? new UserGroup();
        $data['originator_id'] = $this->id;
        $model->setAttributes($data);
        return $model->save() ? Tool::success('创建成功') : Tool::error('创建失败');
    }

    public function actionView()
    {
        $model = UserGroup::find()->status()->forMe()->asArray()->one();
        if ($model) {
            $model['is_change'] = $model['originator_id'] == $this->id;
            return $model;
        }
        return Tool::error('没有队伍或者队伍已解散');
    }

    public function actionChange($id)
    {
        $model = UserGroup::findOne($id);
        if ($model != $this->id) {
            return Tool::error('只能管理者可转让');
        }
        $originator_id = $model['originator_id'];
        $model->originator_id = $model['join_id'];
        $model->join_id = $originator_id;
        return $model->save() ? Tool::success('转让成功') : Tool::error('转让失败');
    }

    public function actionDissolution($id)
    {
        $model = UserGroup::findOne($id);
        if ($model != $this->id) {
            return Tool::error('只能管理者解散');
        }
        $model->status = -1;
        return $model->save() ? Tool::success('解散成功') : Tool::error('解散失败');
    }

}

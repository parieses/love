<?php

namespace frontend\controllers;

use common\base\BaseController;
use common\models\UserGroup;
use common\tools\Common;
use common\tools\Tool;
use frontend\models\User;
use Yii;


class UserGroupController extends BaseController
{

    public $modelClass = UserGroup::class;


    public function actionView()
    {
        $model = UserGroup::find()->status()->forMe()->asArray()->one();
        if ($model) {
            $host = Yii::$app->request->hostInfo . '/site/image?id=';
            $model['is_change'] = $model['originator_id'] == $this->id;
            $model['group'] = true;
            $originator = User::findOne($model['originator_id']);
            $model['originator'] = $originator->nickname ?? $originator->gender == 1 ? '老公' : '老婆';
            $model['originator_pic'] = $originator->head_portrait ? $host . $originator->head_portrait : '';
            $join = User::findOne($model['join_id']);
            $model['join'] = $join->nickname ?? $join->gender == 1 ? '老公' : '老婆';
            $model['join_pic'] = $join->head_portrait ? $host . $join->head_portrait : '';
            return $model;
        }
        $model['group'] = false;
        $loveCode = Yii::$app->redis->hmget('loveCode', $this->id)[0];
        if (!$loveCode) {
            $loveCode = Common::random(8);
            Yii::$app->redis->hmset('loveCode', $this->id, $loveCode);
        }
        return Tool::error('没有队伍或者队伍已解散', $loveCode);
    }

    public function actionJoin()
    {
        $loveCode = Tool::getRequestData('loveCode');
        if (!$loveCode) {
            return Tool::notice('请填写爱情码');
        }
        $loveCodeArr = Yii::$app->redis->HGETALL('loveCode');
        $len = Yii::$app->redis->HLEN('loveCode');
        $data = Common::formatRedisHash($loveCodeArr, $len);
        if (!in_array($loveCode, $data)) {
            return Tool::notice('该爱情码不存在或者已经组队成功');
        }
        $originator_id = array_flip($data)[$loveCode];
        $join_id = $this->id;
        if ($originator_id == $join_id) {
            return Tool::notice('不能使用自己的爱情码');
        }
        $list = User::find()->where(['id' => [$originator_id . $join_id]])->indexBy('gender')->asArray()->all();
        if (count($list) == 1) {
            return Tool::notice('同性别不能组队');
        }
        $create = UserGroup::create($originator_id, $join_id);
        if (is_numeric($create)) {
            Yii::$app->redis->HDEL('loveCode', $originator_id);
            return '加入成功';
        }
        return Tool::error('加入失败');
    }

    public function actionChange($id)
    {
        $model = UserGroup::findOne($id);
        if ($model != $this->id) {
            return Tool::error('只能管理者可转让');
        }
        $originator_id = $model->originator_id;
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

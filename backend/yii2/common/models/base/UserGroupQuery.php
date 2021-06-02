<?php

namespace common\models\base;

use Yii;

/**
 * This is the ActiveQuery class for [[UserGroup]].
 *
 * @see UserGroup
 */
class UserGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function status($status = 0){
        return $this->andWhere(['status'=>$status]);
    }

    public function forMe()
    {
        return $this->andWhere(['or', ['originator_id' => Yii::$app->user->identity->id], ['join_id' => Yii::$app->user->identity->id]]);
    }
}

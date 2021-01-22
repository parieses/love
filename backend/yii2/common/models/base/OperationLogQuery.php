<?php

namespace common\models\base;

/**
 * This is the ActiveQuery class for [[OperationLog]].
 *
 * @see OperationLog
 */
class OperationLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OperationLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OperationLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

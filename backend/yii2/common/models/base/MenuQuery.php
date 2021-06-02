<?php

namespace common\models\base;

use yii\data\ActiveDataProvider;

/**
 * This is the ActiveQuery class for [[Menu]].
 *
 * @see Menu
 */
class MenuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Menu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Menu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function list($limit)
    {
        $query = $this->asArray();
        return new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => $limit,
                ]
            ]
        );
    }
}

<?php

namespace common\models;


use common\tools\Tool;
use common\traits\Time;

class UserGroup extends \common\models\base\UserGroup
{
    use Time;

    public static function create($originator_id, $join_id)
    {
        $model = new self();
        $model->originator_id = $originator_id;
        $model->join_id = $join_id;
        return $model->save() ? $model->id :  Tool::getFirstErrorMessage($model->firstErrors);
    }
}

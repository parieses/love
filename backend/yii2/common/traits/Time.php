<?php
namespace common\traits;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

trait Time
{
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

}
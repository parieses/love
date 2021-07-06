<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%user_group}}".
 *
 * @property int $id
 * @property int $originator_id 发起人
 * @property int $join_id 加入人
 * @property int $head_portrait 头像图片库id
 * @property int $background_image 背景 图片库id
 * @property string $nickname 昵称
 * @property string $address 默认地址
 * @property string $describe 描述
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $status 状态[-1:解散;0:正常]
 */
class UserGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['originator_id', 'join_id', 'head_portrait', 'background_image', 'created_at', 'updated_at','status'], 'integer'],
            [['nickname'], 'string', 'max' => 10],
            [['address', 'describe'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'originator_id' => '发起人',
            'join_id' => '加入人',
            'head_portrait' => '头像图片库id',
            'background_image' => '背景 图片库id',
            'nickname' => '昵称',
            'address' => '默认地址',
            'describe' => '描述',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'status' => '状态[-1:解散;0:正常]',
        ];
    }

    /**
     * @inheritdoc
     * @return UserGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserGroupQuery(get_called_class());
    }
}

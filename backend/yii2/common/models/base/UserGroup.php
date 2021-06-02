<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%user_group}}".
 *
 * @property int $id
 * @property int $originator_id 发起人
 * @property int $join_id 加入人
 * @property string $head_portrait 头像
 * @property string $background_image 头像
 * @property string $nickname 昵称
 * @property string $address 默认地址
 * @property string $describe 菜单描述
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
            [['originator_id', 'join_id', 'created_at', 'updated_at','status'], 'integer'],
            [['head_portrait'], 'string', 'max' => 255],
            [['background_image'], 'string', 'max' => 1000],
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
            'originator_id' => 'Originator ID',
            'join_id' => 'Join ID',
            'head_portrait' => 'Head Portrait',
            'background_image' => 'Background Image',
            'nickname' => 'Nickname',
            'address' => 'Address',
            'describe' => 'Describe',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
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

<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property int $id
 * @property int $type 类型[0:一级菜单;1:二级菜单;2列表;3:按钮和功能]
 * @property string $url 菜单路由
 * @property string $describe 菜单描述
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property int $menu_status 状态[0:私有;1:公开]
 * @property int $pid 级别
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['type', 'status', 'menu_status', 'pid'], 'string', 'max' => 4],
            [['url', 'describe'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型[0:一级菜单;1:二级菜单;2列表;3:按钮和功能]',
            'url' => '菜单路由',
            'describe' => '菜单描述',
            'status' => '状态[-1:删除;0:禁用;1启用]',
            'menu_status' => '状态[0:私有;1:公开]',
            'pid' => '级别',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}

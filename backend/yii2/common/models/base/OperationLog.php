<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%operation_log}}".
 *
 * @property int $id
 * @property int $method 0:get;1post
 * @property string $module 模块
 * @property string $controller 控制器
 * @property string $action 方法
 * @property string $ip
 * @property int $user_id 根据提交模块不同对应人员不同
 * @property int $created_at 创建时间
 * @property string $description 修改数据
 * @property string $table 操作表名称
 * @property int $type 类型0:INSERT;1:UPDATE;2:DELETE
 * @property string $source 设备来源
 * @property string $app_id 应用id
 * @property int $alter_id 修改相关数据的id
 * @property int $merchant_id 商户id
 */
class OperationLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%operation_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'alter_id', 'merchant_id'], 'integer'],
            [['description'], 'string'],
            [['method', 'type'], 'string', 'max' => 1],
            [['module', 'controller', 'action', 'table'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 16],
            [['source', 'app_id'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'method' => '0:get;1post',
            'module' => '模块',
            'controller' => '控制器',
            'action' => '方法',
            'ip' => 'Ip',
            'user_id' => '根据提交模块不同对应人员不同',
            'created_at' => '创建时间',
            'description' => '修改数据',
            'table' => '操作表名称',
            'type' => '类型0:INSERT;1:UPDATE;2:DELETE',
            'source' => '设备来源',
            'app_id' => '应用id',
            'alter_id' => '修改相关数据的id',
            'merchant_id' => '商户id',
        ];
    }

    /**
     * @inheritdoc
     * @return OperationLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OperationLogQuery(get_called_class());
    }
}

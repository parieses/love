<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $password_hash 密码
 * @property string $realname 真实姓名
 * @property string $nickname 昵称
 * @property string $head_portrait 头像
 * @property int $gender 性别[0:未知;1:男;2:女]
 * @property string $qq qq
 * @property string $email 邮箱
 * @property string $birthday 生日
 * @property int $province_id 省
 * @property int $city_id 城市
 * @property int $area_id 地区
 * @property string $address 默认地址
 * @property string $mobile 手机号码
 * @property string $home_phone 家庭号码
 * @property int $visit_count 访问次数
 * @property int $last_time 最后一次登录时间
 * @property string $last_ip 最后一次登录ip
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthday'], 'safe'],
            [['province_id', 'city_id', 'area_id', 'visit_count', 'last_time', 'created_at', 'updated_at','gender','status'], 'integer'],
            [['password_hash'], 'string', 'max' => 150],
            [['realname', 'nickname'], 'string', 'max' => 10],
            [['head_portrait'], 'string', 'max' => 255],
            [['qq', 'home_phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 60],
            [['address'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 11],
            [['last_ip'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'password_hash' => '密码',
            'realname' => '真实姓名',
            'nickname' => '昵称',
            'head_portrait' => '头像',
            'gender' => '性别[0:未知;1:男;2:女]',
            'qq' => 'qq',
            'email' => '邮箱',
            'birthday' => '生日',
            'province_id' => '省',
            'city_id' => '城市',
            'area_id' => '地区',
            'address' => '默认地址',
            'mobile' => '手机号码',
            'home_phone' => '家庭号码',
            'visit_count' => '访问次数',
            'last_time' => '最后一次登录时间',
            'last_ip' => '最后一次登录ip',
            'status' => '状态[-1:删除;0:禁用;1启用]',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}

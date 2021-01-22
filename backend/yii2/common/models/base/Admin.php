<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property int $id
 * @property string $username 帐号
 * @property string $password_hash 密码
 * @property string $auth_key 授权令牌
 * @property string $password_reset_token 密码重置令牌
 * @property int $type 1:普通管理员;10超级管理员
 * @property string $realname 真实姓名
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
 * @property string $dingtalk_robot_token 钉钉机器人token
 * @property int $visit_count 访问次数
 * @property int $last_time 最后一次登录时间
 * @property string $last_ip 最后一次登录ip
 * @property int $role 权限
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property string $access_token token
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthday'], 'safe'],
            [['province_id', 'city_id', 'area_id', 'visit_count', 'last_time', 'role', 'created_at', 'updated_at'], 'integer'],
            [['username', 'qq', 'home_phone'], 'string', 'max' => 20],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 150],
            [['auth_key'], 'string', 'max' => 32],
            [['type'], 'string', 'max' => 1],
            [['realname'], 'string', 'max' => 10],
            [['head_portrait', 'access_token'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 3],
            [['email'], 'string', 'max' => 60],
            [['address', 'dingtalk_robot_token'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 11],
            [['last_ip'], 'string', 'max' => 16],
            [['status'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'type' => 'Type',
            'realname' => 'Realname',
            'head_portrait' => 'Head Portrait',
            'gender' => 'Gender',
            'qq' => 'Qq',
            'email' => 'Email',
            'birthday' => 'Birthday',
            'province_id' => 'Province ID',
            'city_id' => 'City ID',
            'area_id' => 'Area ID',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'home_phone' => 'Home Phone',
            'dingtalk_robot_token' => 'Dingtalk Robot Token',
            'visit_count' => 'Visit Count',
            'last_time' => 'Last Time',
            'last_ip' => 'Last Ip',
            'role' => 'Role',
            'status' => 'Status',
            'access_token' => 'Access Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return AdminQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminQuery(get_called_class());
    }
}

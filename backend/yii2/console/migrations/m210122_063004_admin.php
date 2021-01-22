<?php

use yii\db\Schema;
use yii\db\Migration;

class m210122_063004_admin extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%admin}}',
            [
                'id' => $this->primaryKey(10)->unsigned(),
                'username' => $this->string(20)->notNull()->defaultValue('')->comment('帐号'),
                'password_hash' => $this->string(150)->notNull()->defaultValue('')->comment('密码'),
                'auth_key' => $this->string(32)->notNull()->defaultValue('')->comment('授权令牌'),
                'password_reset_token' => $this->string(150)->null()->defaultValue('')->comment('密码重置令牌'),
                'type' => $this->tinyInteger(1)->null()->defaultValue(1)->comment('1:普通管理员;10超级管理员'),
                'realname' => $this->string(10)->null()->defaultValue('')->comment('真实姓名'),
                'head_portrait' => $this->string(255)->null()->defaultValue('')->comment('头像'),
                'gender' => $this->tinyInteger(3)->unsigned()->null()->defaultValue(0)->comment('性别[0:未知;1:男;2:女]'),
                'qq' => $this->string(20)->null()->defaultValue('')->comment('qq'),
                'email' => $this->string(60)->null()->defaultValue('')->comment('邮箱'),
                'birthday' => $this->date()->null()->defaultValue(null)->comment('生日'),
                'province_id' => $this->smallInteger(6)->null()->defaultValue(0)->comment('省'),
                'city_id' => $this->smallInteger(6)->null()->defaultValue(0)->comment('城市'),
                'area_id' => $this->smallInteger(6)->null()->defaultValue(0)->comment('地区'),
                'address' => $this->string(100)->null()->defaultValue('')->comment('默认地址'),
                'mobile' => $this->char(11)->null()->defaultValue('')->comment('手机号码'),
                'home_phone' => $this->string(20)->null()->defaultValue('')->comment('家庭号码'),
                'dingtalk_robot_token' => $this->string(100)->null()->defaultValue('')->comment('钉钉机器人token'),
                'visit_count' => $this->smallInteger(5)->unsigned()->null()->defaultValue(0)->comment('访问次数'),
                'last_time' => $this->integer(11)->null()->defaultValue(0)->comment('最后一次登录时间'),
                'last_ip' => $this->string(16)->null()->defaultValue('')->comment('最后一次登录ip'),
                'role' => $this->bigInteger(20)->null()->defaultValue(0)->comment('权限'),
                'status' => $this->tinyInteger(4)->null()->defaultValue(1)->comment('状态[-1:删除;0:禁用;1启用]'),
                'access_token' => $this->string(255)->null()->defaultValue('')->comment('token'),
                'created_at' => $this->integer(10)->unsigned()->null()->defaultValue(0)->comment('创建时间'),
                'updated_at' => $this->integer(10)->unsigned()->null()->defaultValue(0)->comment('修改时间'),
            ],
            $tableOptions
        );
        $this->createIndex('idx_access_token', '{{%admin}}', ['access_token'], false);
        $this->createIndex('idx_mobile', '{{%admin}}', ['mobile'], false);
        $this->createIndex('idx_username', '{{%admin}}', ['username'], false);
        $this->batchInsert(
            '{{%backend_admin}}',
            [
                "id",
                "username",
                "password_hash",
                "auth_key",
                "password_reset_token",
                "type",
                "realname",
                "head_portrait",
                "gender",
                "qq",
                "email",
                "birthday",
                "province_id",
                "city_id",
                "area_id",
                "address",
                "mobile",
                "home_phone",
                "dingtalk_robot_token",
                "visit_count",
                "last_time",
                "last_ip",
                "role",
                "status",
                "access_token",
                "created_at",
                "updated_at"
            ],
            [
                [
                    'id' => '1',
                    'username' => 'admin',
                    'password_hash' => '$2y$13$5ZIhQOrOp.SLkAUzas8AVediljA2..Hzwi8ck8PnV8mATjEPay/hS',
                    'auth_key' => 'fMBce3sJQRyyu25y1OmVdjN_r3MaYWeN',
                    'password_reset_token' => 'v8yvcFDPUijMkaT9pYRmsocLDVh1wMBO',
                    'type' => '10',
                    'realname' => '',
                    'head_portrait' => '',
                    'gender' => '0',
                    'qq' => '',
                    'email' => 'admin@email.com',
                    'birthday' => null,
                    'province_id' => '0',
                    'city_id' => '0',
                    'area_id' => '0',
                    'address' => '',
                    'mobile' => '11111111111',
                    'home_phone' => '',
                    'dingtalk_robot_token' => '',
                    'visit_count' => '18',
                    'last_time' => '1604279485',
                    'last_ip' => '117.159.13.118',
                    'role' => '0',
                    'status' => '1',
                    'access_token' => '86K-IU2A0Yh4Cna5PYbZZ-jzRxuFK3dK_1605143415',
                    'created_at' => '1603330476',
                    'updated_at' => '1604279485',
                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->dropIndex('idx_access_token', '{{%admin}}');
        $this->dropIndex('idx_mobile', '{{%admin}}');
        $this->dropIndex('idx_username', '{{%admin}}');
        $this->dropTable('{{%admin}}');
    }
}

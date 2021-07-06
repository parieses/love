<?php

use common\tools\Tool;
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
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="管理员"';
        $this->createTable(
            '{{%admin}}',
            [
                'id' => $this->primaryKey(11)->unsigned(),
                'username' => $this->string(20)->notNull()->defaultValue('')->comment('帐号'),
                'password_hash' => $this->string(150)->notNull()->defaultValue('')->comment('密码'),
                'auth_key' => $this->string(32)->notNull()->defaultValue('')->comment('授权令牌'),
                'password_reset_token' => $this->string(150)->null()->defaultValue('')->comment('密码重置令牌'),
                'type' => $this->tinyInteger(1)->null()->defaultValue(1)->comment('1:普通管理员;10超级管理员'),
                'realname' => $this->string(10)->null()->defaultValue('')->comment('真实姓名'),
                'head_portrait' => $this->integer(11)->null()->defaultValue(0)->comment('图片库id'),
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
                'created_at' => $this->integer(11)->unsigned()->null()->defaultValue(0)->comment('创建时间'),
                'updated_at' => $this->integer(11)->unsigned()->null()->defaultValue(0)->comment('修改时间'),
            ],
            $tableOptions
        );
        $this->createIndex('idx_mobile', '{{%admin}}', ['mobile'], false);
        $this->createIndex('idx_username', '{{%admin}}', ['username'], false);
        $this->batchInsert(
            '{{%admin}}',
            [

                "username",
                "password_hash",
                'type',
                "status",
                "created_at",
                "updated_at"
            ],
            [
                [
                    'username' => 'admin',
                    'password_hash' => Tool::setPassword('admin'),
                    'type' => 10,
                    'status' => 1,
                    'created_at' => time(),
                    'updated_at' => time()

                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->dropIndex('idx_mobile', '{{%admin}}');
        $this->dropIndex('idx_username', '{{%admin}}');
        $this->dropTable('{{%admin}}');
    }
}

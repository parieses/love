<?php

use yii\db\Migration;

/**
 * Class m210125_032322_user
 */
class m210125_032322_user extends Migration
{
    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="用户"';

        $this->createTable(
            '{{%user}}',
            [
                'id' => $this->primaryKey(11)->unsigned(),
                'password_hash' => $this->string(150)->notNull()->defaultValue('')->comment('密码'),
                'realname' => $this->string(10)->null()->defaultValue('')->comment('真实姓名'),
                'nickname' => $this->string(10)->null()->defaultValue('')->comment('昵称'),
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
                'visit_count' => $this->smallInteger(5)->unsigned()->null()->defaultValue(0)->comment('访问次数'),
                'last_time' => $this->integer(11)->null()->defaultValue(0)->comment('最后一次登录时间'),
                'last_ip' => $this->string(16)->null()->defaultValue('')->comment('最后一次登录ip'),
                'status' => $this->tinyInteger(4)->null()->defaultValue(1)->comment('状态[-1:删除;0:禁用;1启用]'),
                'created_at' => $this->integer(10)->unsigned()->null()->defaultValue(0)->comment('创建时间'),
                'updated_at' => $this->integer(10)->unsigned()->null()->defaultValue(0)->comment('修改时间'),
            ],
            $tableOptions
        );
        $this->createIndex('idx_mobile', '{{%user}}', ['mobile'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_mobile', '{{%user}}');
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210125_032322_user cannot be reverted.\n";

        return false;
    }
    */
}

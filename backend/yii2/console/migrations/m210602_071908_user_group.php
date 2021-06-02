<?php

use yii\db\Migration;

/**
 * Class m210125_032322_user
 */
class m210602_071908_user_group extends Migration
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
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%user_group}}',
            [
                'id' => $this->primaryKey(11)->unsigned(),
                'originator_id' => $this->integer(11)->null()->defaultValue(0)->comment('发起人'),
                'join_id' => $this->integer(11)->null()->defaultValue(0)->comment('加入人'),
                'head_portrait' => $this->string(255)->null()->defaultValue('')->comment('头像'),
                'background_image' => $this->string(1000)->null()->defaultValue('')->comment('头像'),
                'nickname' => $this->string(10)->null()->defaultValue('')->comment('昵称'),
                'address' => $this->string(100)->null()->defaultValue('')->comment('默认地址'),
                'describe' => $this->string(100)->notNull()->defaultValue('')->comment('菜单描述'),
                'created_at' => $this->integer(10)->unsigned()->null()->defaultValue(0)->comment('创建时间'),
                'updated_at' => $this->integer(10)->unsigned()->null()->defaultValue(0)->comment('修改时间'),
                'status' => $this->tinyInteger(4)->notNull()->defaultValue(0)->comment('状态[-1:解散;0:正常]'),
            ],
            $tableOptions
        );
        $this->createIndex('idx_originator_id', '{{%user_group}}', ['originator_id'], false);
        $this->createIndex('idx_join_id', '{{%user_group}}', ['join_id'], false);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_group}}');
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

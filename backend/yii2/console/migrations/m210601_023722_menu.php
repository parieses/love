<?php

use yii\db\Migration;

/**
 * Class m210601_023722_menu
 */
class m210601_023722_menu extends Migration
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
            '{{%menu}}',
            [
                'id' => $this->primaryKey(11)->unsigned(),
                'type' => $this->tinyInteger(4)->notNull()->defaultValue(0)->comment('类型[0:一级菜单;1:二级菜单;2列表;3:按钮和功能]'),
                'url' => $this->string(50)->notNull()->defaultValue('')->comment('菜单路由'),
                'describe' => $this->string(50)->notNull()->defaultValue('')->comment('菜单描述'),
                'status' => $this->tinyInteger(4)->notNull()->defaultValue(1)->comment('状态[-1:删除;0:禁用;1启用]'),
                'menu_status' => $this->tinyInteger(4)->notNull()->defaultValue(0)->comment('状态[0:私有;1:公开]'),
                'pid' => $this->tinyInteger(4)->unsigned()->notNull()->defaultValue(0)->comment('级别'),
                'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
                'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),
            ],
            $tableOptions
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210601_023722_menu cannot be reverted.\n";

        return false;
    }
    */
}

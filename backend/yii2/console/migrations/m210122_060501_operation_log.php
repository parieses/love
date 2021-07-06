<?php

use yii\db\Schema;
use yii\db\Migration;

class m210122_060501_operation_log extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="操作日志"';


        $this->createTable(
            '{{%operation_log}}',
            [
                'id'=> $this->primaryKey(11)->unsigned(),
                'method'=> $this->tinyInteger(1)->notNull()->defaultValue(0)->comment('0:get;1post'),
                'module'=> $this->string(50)->notNull()->defaultValue('')->comment('模块'),
                'controller'=> $this->string(50)->notNull()->defaultValue('')->comment('控制器'),
                'action'=> $this->string(50)->notNull()->defaultValue('')->comment('方法'),
                'ip'=> $this->string(16)->notNull()->defaultValue(''),
                'user_id'=> $this->integer(11)->unsigned()->null()->defaultValue(0)->comment('根据提交模块不同对应人员不同'),
                'created_at'=> $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
                'description'=> $this->text()->null()->defaultValue(null)->comment('修改数据'),
                'table'=> $this->string(50)->notNull()->defaultValue('')->comment('操作表名称'),
                'type'=> $this->tinyInteger(1)->notNull()->defaultValue(0)->comment('类型0:INSERT;1:UPDATE;2:DELETE'),
                'source'=> $this->string(11)->null()->defaultValue('')->comment('设备来源'),
                'app_id'=> $this->string(20)->null()->defaultValue('')->comment('应用id'),
                'alter_id'=> $this->integer(20)->unsigned()->null()->defaultValue(0)->comment('修改相关数据的id'),
                'merchant_id'=> $this->integer(11)->unsigned()->null()->defaultValue(0)->comment('商户id'),
            ],$tableOptions
        );
        $this->createIndex('user_id','{{%operation_log}}',['user_id'],false);
        $this->createIndex('app_id','{{%operation_log}}',['app_id'],false);
        $this->createIndex('module','{{%operation_log}}',['module'],false);
        $this->createIndex('controller','{{%operation_log}}',['controller'],false);
        $this->createIndex('action','{{%operation_log}}',['action'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('user_id', '{{%operation_log}}');
        $this->dropIndex('app_id', '{{%operation_log}}');
        $this->dropIndex('module', '{{%operation_log}}');
        $this->dropIndex('controller', '{{%operation_log}}');
        $this->dropIndex('action', '{{%operation_log}}');
        $this->dropTable('{{%operation_log}}');
    }
}

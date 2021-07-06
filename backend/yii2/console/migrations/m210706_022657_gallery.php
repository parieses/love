<?php

use yii\db\Migration;

/**
 * Class m210706_022657_gallery
 */
class m210706_022657_gallery extends Migration
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
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="库片库"';

        $this->createTable(
            '{{%gallery}}',
            [
                'id' => $this->primaryKey(11)->unsigned(),
                'status' => $this->tinyInteger(4)->notNull()->defaultValue(0)->comment('状态[0:正常;-1:删除]'),
                'md5' => $this->string(200)->notNull()->defaultValue('')->comment('文件md5'),
                'type' => $this->tinyInteger(1)->notNull()->defaultValue(0)->comment('类型0:本地1:网络图片'),
                'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
                'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('修改时间'),
                'count' => $this->smallInteger(5)->unsigned()->null()->defaultValue(0)->comment('引用次数'),
                'url'=> $this->string(500)->notNull()->defaultValue('')->comment('图片'),
            ],
            $tableOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%gallery}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210706_022657_gallery cannot be reverted.\n";

        return false;
    }
    */
}

<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%gallery}}".
 *
 * @property int $id
 * @property int $status 状态[0:正常;-1:删除]
 * @property string $md5 文件md5
 * @property int $type 类型0:本地1:网络图片
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $count 引用次数
 * @property string $url 图片
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gallery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'count','type','status'], 'integer'],
            [['md5'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => '状态[0:正常;-1:删除]',
            'md5' => '文件md5',
            'type' => '类型0:本地1:网络图片',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'count' => '引用次数',
            'url' => '图片',
        ];
    }

    /**
     * @inheritdoc
     * @return GalleryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GalleryQuery(get_called_class());
    }
}

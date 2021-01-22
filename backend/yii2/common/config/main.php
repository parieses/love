<?php

use yii\caching\FileCache;
use services\Application;
use yii\web\JsonParser;
use yii\base\Event;
use yii\db\BaseActiveRecord;
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'bootstrap' => [
        'log',
        static function(){
            Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_INSERT, ['common\components\AdminLog', 'log']);
            Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_UPDATE, ['common\components\AdminLog', 'log']);
            Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_DELETE, ['common\components\AdminLog', 'log']);
        },
    ],
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        /** ------ 服务层 ------ **/
        'services' => [
            'class' => Application::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
];

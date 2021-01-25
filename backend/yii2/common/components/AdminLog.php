<?php


namespace common\components;


use common\models\base\OperationLog;
use Yii;
use yii\db\ActiveRecord;

class AdminLog
{
    public static $noInsert = ['updated_at', 'password_hash'];

    public static function log($event): void
    {
        if ($event->sender instanceof OperationLog  || !$event->sender->primaryKey() ) {
            return;
        }
        $attributeLabels = (new $event->sender())->attributeLabels();
        $data['table'] = $event->sender->tableSchema->name;
        if ($event->name === ActiveRecord::EVENT_AFTER_INSERT) {
            $data['type'] = 0;
        } elseif ($event->name === ActiveRecord::EVENT_AFTER_UPDATE) {
            $data['type'] = 1;
        } else {
            $data['type'] = 2;
        }
        $data['app_id'] = Yii::$app->id;
        $data['method'] = empty(Yii::$app->request->method)?:Yii::$app->request->method;
        $data['module'] = Yii::$app->controller->module->id ?? '';
        $data['controller'] = Yii::$app->controller->id ?? '';
        $data['action'] = Yii::$app->controller->action->id ?? '';
        $data['ip'] = empty(Yii::$app->request->userIP)?:(string)ip2long(Yii::$app->request->userIP);
        $data['source'] = empty(Yii::$app->request->headers)?:Yii::$app->request->headers->get('source');
        $desc = [];
        if (!empty($event->changedAttributes)) {
            foreach ($event->changedAttributes as $name => $value) {
                $newValue = $event->sender->getAttribute($name);
                if (isset($newValue) && $value != $newValue && !in_array($name, self::$noInsert)) {//当发生更改才会记录
                    //中文名称 //老的值 //新的值 //对应的数据库字段后续关联可使用
                    $desc[] = ['name' => $attributeLabels[$name], 'old' => $value ?? '', 'new' => $newValue, 'key' => $name];
                }
            }
        }
        $data['description'] = json_encode($desc);
        $data['user_id'] = Yii::$app->user->identity->id ?? 0;
        $data['alter_id'] = is_array($event->sender->getPrimaryKey()) ? current(
            $event->sender->getPrimaryKey()
        ) : $event->sender->getPrimaryKey();
        $data['merchant_id'] = Yii::$app->user->identity->merchant_id ?? 0;
        $data['created_at'] = time();
        if ($desc) {
            Yii::$app->db->createCommand()->insert(OperationLog::tableName(), $data)->execute();
        }
    }
}
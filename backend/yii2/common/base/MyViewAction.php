<?php


namespace common\base;


use common\tools\Tool;
use Yii;
use yii\base\InvalidConfigException;
use yii\rest\ViewAction;

class MyViewAction extends ViewAction
{
    public function runWithParams($params)
    {
        if (!method_exists($this, 'run')) {
            throw new InvalidConfigException(get_class($this) . ' must define a "run()" method.');
        }
        $args = $this->controller->bindActionParams($this, ['id' =>$this->id]);
        Yii::debug('Running action: ' . get_class($this) . '::run()', __METHOD__);
        if (Yii::$app->requestedParams === null) {
            Yii::$app->requestedParams = $args;
        }
        if ($this->beforeRun()) {
            $result = call_user_func_array([$this, 'run'], $args);
            $this->afterRun();

            return $result;
        }
        return null;
    }
}
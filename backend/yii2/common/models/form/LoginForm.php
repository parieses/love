<?php


namespace common\models\form;


use backend\models\Admin;
use common\tools\Common;
use common\tools\Tool;
use frontend\models\User;
use ReflectionClass;
use Yii;

use function GuzzleHttp\Psr7\str;

class LoginForm extends \yii\base\Model
{
    public $username;
    public $password;
    public $mobile;
    private $_user;
    private $_access_token;


    public function rules(): array
    {
        return [
            ['username', 'required', 'on' => 'admin', 'message' => '请填写用户名'],
            ['mobile', 'required', 'on' => 'user', 'message' => '请填写手机号'],
            ['password', 'required', 'message' => '请填写密码'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params): void
    {
        if (!$this->hasErrors()) {
            if ($this->getScenario() === 'user') {
                $this->_user = User::findByMobile($this->mobile);
            } else {
                $this->_user = Admin::findByUserName($this->username);
            }
            $redisKey = strtoupper($this->getScenario() . ':login:');
            if (!$this->_user) {
                $this->addError($attribute, '用户不存在');
                return;
            }
            if (!$this->_user->validatePassword($this->password)) {
                $this->addError($attribute, '密码错误');
                return;
            }
            $this->_access_token = Common::generateAccessToken($this->_user, $redisKey);
            $this->_user->last_ip = Yii::$app->request->getUserIP();
            $this->_user->visit_count++;
            if (!$this->_user->save()) {
                $this->addError($attribute, Tool::getErrorMessage($this->_user->errors));
            }
        }
    }

    public function getAccessToken()
    {
        return $this->_access_token;
    }

}
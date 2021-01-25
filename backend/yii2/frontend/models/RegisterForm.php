<?php


namespace frontend\models;


use common\tools\Tool;
use yii\base\Model;

class RegisterForm extends Model
{
    public $password;
    public $mobile;

    public function rules(): array
    {
        return [
            ['mobile', 'filter', 'filter' => 'trim'],
            ['mobile', 'required', 'message' => '请填写手机号'],
            ['password', 'required', 'message' => '请填写密码'],
            ['password', 'string', 'min' => 6, 'message' => '最少六位数'],
            ['mobile', 'unique', 'targetClass' => User::class, 'message' => '手机号已存在'],
        ];
    }

    public function save(): array
    {
        $model = new User();
        $model->mobile = $this->mobile;
        $model->password_hash = Tool::setPassword($this->password);
        if (!$model->save()) {
            return Tool::error(Tool::getFirstErrorMessage($model->firstErrors));
        }
        return Tool::success('注册成功');
    }
}
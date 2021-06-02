<?php


namespace frontend\models;


use common\tools\Tool;
use yii\base\Model;
use yii\base\UserException;

class RegisterForm extends Model
{
    public $password;
    public $mobile;
    public $gender;
    public $id;

    public function rules(): array
    {
        return [
            ['mobile', 'filter', 'filter' => 'trim'],
            ['mobile', 'required', 'message' => '请填写手机号'],
            ['password', 'required', 'message' => '请填写密码'],
            ['password', 'required', 'message' => '请填写密码'],
            ['gender', 'required', 'message' => '性别必填'],
            ['mobile', 'unique', 'targetClass' => User::class, 'message' => '手机号已存在'],
        ];
    }

    /**
     * Created by Mr.亮先生.
     * program: love
     * FuncName:save
     * status:
     * User: Mr.liang
     * Date: 2021/6/2
     * Time: 16:42
     * Email:1695699447@qq.com
     * @return User
     * @throws UserException
     */
    public function save(): User
    {
        $model = new User();
        $model->mobile = $this->mobile;
        $model->password_hash = Tool::setPassword($this->password);
        $model->gender = $this->gender;
        if (!$model->save()) {
            throw new UserException(Tool::getFirstErrorMessage($model->firstErrors));
        }
        $this->id = $model->id;
        return $model;
    }
}
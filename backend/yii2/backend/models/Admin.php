<?php

namespace backend\models;


use common\enums\StatusEnum;
use common\tools\Common;
use Yii;
use yii\web\IdentityInterface;


class Admin extends \common\models\base\Admin implements IdentityInterface
{

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
       return self::findOne(['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function findByUserName($username)
    {
        return self::findOne(['username' => $username, 'status' => StatusEnum::ENABLED]);
    }

    public static function isAccessTokenValid($token = null): bool
    {
        if (!empty($token)) {
            $timestamp = (int)substr($token, strrpos($token, '_') + 1);
            return $timestamp > time();
        }
        return false;
    }

}

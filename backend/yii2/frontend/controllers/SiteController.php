<?php

namespace frontend\controllers;

use common\models\Gallery;
use common\tools\Code;
use common\tools\Common;
use Exception;
use frontend\models\RegisterForm;
use common\models\form\LoginForm;
use common\tools\Tool;
use common\traits\BaseAction;
use Yii;
use yii\base\UserException;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;


/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends Controller
{
    use BaseAction;
    public $defaultAction = 'synopsis';

    /**
     * @api            {post} /site/login
     * @apiDescription 登陆获取用户token
     * @apiGroup       用户
     * @apiName        登陆
     * @apiHeader {String} source = APP 请求头必须携带来源字段
     * @apiParam {Number} mobile 手机号
     * @apiParam {String} password 密码
     * @apiVersion     0.1.0
     * @apiExample {curl} 访问示例：
     * curl -i http://127.0.0.1:8888/site/login
     * @apiError {String} message 错误信息
     * @apiError {Number} code 0 报错 2 提醒
     * @apiErrorExample  {json} error-example
     * {
     * "code": 2,
     * "message": "请填写手机号",
     * "data": null,
     * "duration": 78
     * }
     * @apiSuccess {Number} code 1 成功
     * @apiSuccess {String} message 提示语
     * @apiSuccess {String} data 登陆成功的token
     * @apiSuccessExample  {json} success-example
     * {
     * "code": 1,
     * "message": "登陆成功",
     * "data": "VE1lTk05NnpLZktwRDdURGpOWVZNSzNnQ3gxZElWcjc6JjoxNjI2Mzk4NjM3OiY6MQ==",
     * "duration": 742
     * }
     */
    public function actionLogin(): array
    {
        $model = new LoginForm();
        $model->setScenario('user');
        $model->load(Tool::getRequestData(), '');
        if ($model->validate()) {
            return Tool::success('登陆成功', $model->getAccessToken());
        }
        $msg = Tool::getFirstErrorMessage($model->firstErrors);
        return Tool::notice($msg);
    }

    /**
     * @api            {post} /site/register
     * @apiDescription 用户注册
     * @apiGroup       用户
     * @apiName        注册
     * @apiHeader {String} source = APP 请求头必须携带来源字段
     * @apiParam {Number} mobile 手机号
     * @apiParam {String} password 密码
     * @apiParam {Number} gender 性别:1男2女
     * @apiVersion     0.1.0
     * @apiExample {curl} 访问示例：
     * curl -i http://127.0.0.1:8888/site/register
     * @apiError {String} message 错误信息
     * @apiError {Number} code 0 报错 2 提醒
     * @apiErrorExample  {json} error-example
     * {
     * "code": 2,
     * "message": "请填写手机号",
     * "data": null,
     * "duration": 78
     * }
     * @apiSuccess {Number} code  1 成功
     * @apiSuccess {String} message 提示语
     * @apiSuccess {String} data 注册成功返回的的token
     * @apiSuccessExample  {json} success-example
     * {
     * "code": 1,
     * "message": "注册成功",
     * "data": "aUNJMjhZOUdQdHZOSFJ2S3FBWlFWMnlKN2p2QU9rS0s6JjoxNjI2Mzk5NzI3OiY6Mw==",
     * "duration": 697
     * }
     */
    public function actionRegister()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new RegisterForm();
            $data = Tool::getRequestData();
            $model->load($data, '');
            if (!$model->validate()) {
                $msg = Tool::getFirstErrorMessage($model->firstErrors);
                throw new UserException($msg);
            }
            if (!$model->save()) {
                $msg = Tool::getFirstErrorMessage($model->firstErrors);
                throw new UserException($msg);
            }
            $access_token = Common::generateAccessToken($model, "USER:LOGIN:" . $model->id);
            $transaction->commit();
            return Tool::success('注册成功', $access_token);
        } catch (Exception $e) {
            $transaction->rollBack();
            return Tool::notice($e->getMessage());
        }
    }

    public function actionError(): array
    {
        return ['code' => Code::getNoFindCode(), 'message' => '该页面没找到'];
    }

    public function actionSynopsis()
    {
        return 'API';
    }

    /**
     * @api            {post} /site/upload-image
     * @apiDescription 上传图片
     * @apiGroup       公共
     * @apiName        上传图片
     * @apiHeader {String} source = APP 请求头必须携带来源字段
     * @apiParam {File} image 图片
     * @apiVersion     0.1.0
     * @apiExample {curl} 访问示例：
     * curl -i http://127.0.0.1:8888/site/upload-image
     * @apiError {String} message 错误信息
     * @apiError {Number} code 0 报错 2 提醒
     * @apiErrorExample  {json} error-example
     * {
     * "code": 2,
     * "message": "请填写手机号",
     * "data": null,
     * "duration": 78
     * }
     * @apiSuccess {Number} code  =1 成功
     * @apiSuccess {String} message 提示语
     * @apiSuccess {String} data 上传成功的id
     * @apiSuccessExample  {json} success-example
     * {
     * "code": 1,
     * "message": "上传成功",
     * "data": 2,
     * "duration": 269
     * }
     */
    public function actionUploadImage()
    {
        $file = UploadedFile::getInstanceByName('image');
        $path = Yii::getAlias('@upload') . '/' . date('y-m-d') . '/';
        FileHelper::createDirectory($path);
        $filePath = $path . time() . $file->name;
        $file->saveAs($filePath);
        $file_md5 = md5_file($filePath);
        $gallery = Gallery::findOne(['md5' => $file_md5]);
        if ($gallery) {
            FileHelper::unlink($filePath);
            return Tool::success('已存在', $gallery->id);
        }
        $create = Gallery::create($file_md5, $filePath);
        if (is_numeric($create)) {
            return Tool::success('上传成功', $create);
        }
        FileHelper::unlink($filePath);
        return Tool::error($create);
    }

    /**
     * @api            {post} /site/image
     * @apiDescription 查看图片
     * @apiGroup       公共
     * @apiName        查看图片
     * @apiParam {Number} id 上传图片的id
     * @apiVersion     0.1.0
     * @apiExample {curl} 访问示例：
     * curl -i http://127.0.0.1:8888/site/image
     */
    public function actionImage()
    {
        $id = Tool::getRequestData('id');
        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->format = Response::FORMAT_RAW;
        $imgFullPath = Gallery::findOne($id)->url;
        $response->stream = fopen($imgFullPath, 'r');
        return $response->send();
    }
}

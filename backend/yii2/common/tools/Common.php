<?php


namespace common\tools;

use common\container\FuncContainer;
use common\exceptions\ApiException;
use common\models\BackendAdminQuery;
use common\models\CustomerDepartment;
use common\models\CustomerVenue;
use common\models\MerchantCustomer;
use xingfufit\lib_service\common\Upload;
use Yii;
use yii\base\Exception;

class Common
{
    public const TOKEN_EXPIRE = 10 * 24 * 60 * 60; //用户token过期时间设置
    public const DAY_TIMESTAMP = 60 * 60 * 24;     //一天的时间戳
    public const DEFAULT_LIMIT = 10;               //全局默认分页数量

    /**
     * 根据键合并值
     * Created by Mr.亮先生.
     * program: love
     * FuncName:mergeValuesByKey
     * status:static
     * User: Mr.liang
     * Date: 2021/1/22
     * Time: 10:13
     * Email:1695699447@qq.com
     * @param      $data
     * @param      $key
     * @param null $value
     * @return array
     */
    public static function mergeValuesByKey($data, $key, $value = null): array
    {
        $result = [];
        foreach ($data as $k => $v):
            $result[$v[$key]][] = $value ? $v[$value] : $v;
        endforeach;
        return $result;
    }

    /**
     * Created by Mr.亮先生.
     * program: love
     * FuncName:getItems
     * status:static
     * User: Mr.liang
     * Date: 2021/1/22
     * Time: 10:13
     * Email:1695699447@qq.com
     * @param $all
     * @param $ids
     * @param $field
     * @return array
     */
    public static function getItems($all, $ids, $field): array
    {
        $data = [];
        foreach ($all as $key => $value):
            if (in_array($value['id'], $ids, true)) {
                $data[] = $value;
            }
        endforeach;
        return $data;
    }

    /**
     * Created by Mr.亮先生.
     * program: love
     * FuncName:generateAccessToken
     * status:static
     * User: Mr.liang
     * Date: 2021/1/22
     * Time: 10:13
     * Email:1695699447@qq.com
     * @param $id
     * @param $timestamp
     * @return string
     * @throws Exception
     */
    public static function generateAccessToken($id, $timestamp): string
    {
        return Yii::$app->security->generateRandomString() . ':&:' . $timestamp . ':&:' . $id;
    }

    /**
     * Created by Mr.亮先生.
     * program: love
     * FuncName:getMillisecond
     * status:static
     * User: Mr.liang
     * Date: 2021/1/22
     * Time: 10:13
     * Email:1695699447@qq.com
     * @return float
     */
    public static function getMillisecond(): float
    {
        [$s1, $s2] = explode(' ', microtime());
        return (float)sprintf('%.0f', ((float)$s1 + (float)$s2) * 1000);
    }
}
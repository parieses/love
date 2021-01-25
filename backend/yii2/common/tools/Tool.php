<?php

namespace common\tools;

use common\helpers\ArrayHelper;
use Exception;
use Yii;

class Tool
{

    public static function getFirstErrorMessage($errors)
    {
        foreach ($errors as $err):
            return $err;
        endforeach;
    }

    public static function getErrorMessage($errors)
    {
        foreach ($errors as $err):
            return $err[0];
        endforeach;
    }

    public static function setPassword($password): string
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    public static function error($msg, $data = null): array
    {
        return ['code' => Code::getErrorCode(), 'message' => $msg, 'data' => $data];
    }

    public static function notice($msg, $data = null): array
    {
        return ['code' => Code::getNoticeCode(), 'message' => $msg, 'data' => $data];
    }

    public static function success($msg, $data = null): array
    {
        return ['code' => Code::getSuccessCode(), 'message' => $msg, 'data' => $data];
    }

    public static function params()
    {
        return array_merge(Yii::$app->request->get(), Yii::$app->request->post());
    }

    public static function getExceptions(Exception $e): array
    {
        return ['code' => 0, 'message' => $e->getMessage(), 'data' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine(), 'string' => $e->getTraceAsString()]];
    }

    /**
     * debug使用
     * Created by Mr.亮先生.
     * program: new-saas-api
     * FuncName:P
     * status:static
     * User: Mr.liang
     * Date: 2020/8/20
     * Time: 14:59
     * Email:1695699447@qq.com
     * @param mixed ...$array
     */
    public static function P(...$array): void
    {
        echo "<pre>";
        if (count($array) === 1) {
            print_r($array[0]);
        } else {
            print_r($array);
        }
        echo '</pre>';
        die();
    }


    /**
     * 获取两个点之间的距离
     * Created by Mr.亮先生.
     * program: new-saas-api
     * FuncName:getTheDistance
     * status:static
     * User: Mr.liang
     * Date: 2020/8/20
     * Time: 14:22
     * Email:1695699447@qq.com
     * @param     $lat1     :纬度1
     * @param     $lng1     :经度1
     * @param     $lat2     :纬度2
     * @param     $lng2     :经度2
     * @param int $len_type :输出类型(m?km)
     * @param int $decimal  :保留小数位
     * @return float
     */
    public static function getTheDistance($lat1, $lng1, $lat2, $lng2, $len_type = 2, $decimal = 2): float
    {
        $radLat1 = $lat1 * M_PI / 180.0;
        $radLat2 = $lat2 * M_PI / 180.0;
        $a = $radLat1 - $radLat2;
        $b = ($lng1 * M_PI / 180.0) - ($lng2 * M_PI / 180.0);
        $s = 2 * asin(sqrt((sin($a / 2) ** 2) + cos($radLat1) * cos($radLat2) * (sin($b / 2) ** 2)));
        $s *= 6378.137;
        $s = round($s * 1000);
        if ($len_type > 1) {
            $s /= 1000;
        }
        return round($s, $decimal);
    }

    /**
     * 根据身份证获取性别[0:未知;1:男;2:女]
     * Created by Mr.亮先生.
     * program: new-saas-api
     * FuncName:getSexByIdCard
     * status:static
     * User: Mr.liang
     * Date: 2020/8/20
     * Time: 14:30
     * Email:1695699447@qq.com
     * @param $idCard :身份证号
     * @return int
     */
    public static function getSexByIdCard($idCard): int
    {
        if (empty($idCard)) {
            return 0;
        }
        return ((int)substr($idCard, 16, 1)) % 2 === 0 ? 2 : 1;
    }

    /**
     * 根据身份证获取出生年月
     * Created by Mr.亮先生.
     * program: new-saas-api
     * FuncName:getBirthdayByIdCard
     * status:static
     * User: Mr.liang
     * Date: 2020/8/20
     * Time: 14:35
     * Email:1695699447@qq.com
     * @param        $idCard    :身份证号
     * @param string $connector :连接符
     * @return string|null
     */
    public static function getBirthdayByIdCard($idCard, $connector = '-'): ?string
    {
        if (empty($idCard)) {
            return null;
        }
        $bir = substr($idCard, 6, 8);
        $year = (int)substr($bir, 0, 4);
        $month = (int)substr($bir, 4, 2);
        $day = (int)substr($bir, 6, 2);
        return $year . $connector . $month . $connector . $day;
    }


    /**
     * http客户端
     * Created by Mr.亮先生.
     * program: new-saas-api
     * FuncName:httpClient
     * status:
     * User: Mr.liang
     * Date: 2020/8/20
     * Time: 17:19
     * Email:1695699447@qq.com
     * @param string $url       请求的地址
     * @param string $type      POST/GET/post/get
     * @param array  $data      要传输的数据
     * @param int    $timeout   超时时间
     * @param array  $cert_info 证书信息
     * @return mixed
     */
    public static function httpClient($url, $type = "GET", $data = [], $timeout = 20, $cert_info = [])
    {
        $type = strtoupper($type);
        $option = [];
        if ($data) {
            if ($type === 'POST') {
                $option[CURLOPT_POSTFIELDS] = $data;
            } elseif ($type === 'GET') {
                $data = http_build_query($data);
                $url = strpos($url, '?') !== false ? $url . '&' . $data : $url . '?' . $data;
            }
        }
        $option[CURLOPT_URL] = $url;
        $option[CURLOPT_FOLLOWLOCATION] = true;
        $option[CURLOPT_POST] = $type === 'POST' ? 1 : 0;
        $option[CURLOPT_MAXREDIRS] = 4;
        $option[CURLOPT_RETURNTRANSFER] = true;//是否要求返回数据
        $option[CURLOPT_TIMEOUT] = $timeout;
        //设置证书信息
        if (!empty($cert_info) && !empty($cert_info['cert_file'])) {
            $option[CURLOPT_SSLCERT] = $cert_info['cert_file'];      //证书存放路径
            $option[CURLOPT_SSLCERTPASSWD] = $cert_info['cert_pass'];//证书密码
            $option[CURLOPT_SSLCERTTYPE] = $cert_info['cert_type'];  //证书类型，"PEM" (default), "DER", and"ENG".
        }
        //设置CA
        if (!empty($cert_info['ca_file'])) {
            // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
            $option[CURLOPT_SSL_VERIFYPEER] = true;         //是否检测服务器的证书是否由正规浏览器认证过的授权CA颁发的
            $option[CURLOPT_CAINFO] = $cert_info['ca_file'];//.crt文件
        } else {
            // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
            $option[CURLOPT_SSL_VERIFYPEER] = false;
        }

        $ch = curl_init();
        curl_setopt_array($ch, $option);
        $response = curl_exec($ch);
        $curl_no = curl_errno($ch);
        $curl_err = curl_error($ch);
        curl_close($ch);

        if ($curl_no > 0) {
            return '(' . $curl_no . ')' . $curl_err;
        }
        return $response;
    }

    /**
     * 通过生日过去年纪
     * Created by Mr.亮先生.
     * program: new-saas-api
     * FuncName:acquireAge
     * status:static
     * User: Mr.liang
     * Date: 2020/11/7
     * Time: 15:54
     * Email:1695699447@qq.com
     * @param $birthday
     * @return false|mixed|string
     */
    public static function acquireAge($birthday)
    {
        [$year, $month, $day] = explode("-", $birthday);
        $year_diff = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff = date("d") - $day;
        if ($day_diff < 0 || $month_diff < 0) {
            $year_diff--;
        }
        return $year_diff;
    }

    public static function getRequestData($name = null, $defaultValue = null)
    {
        $request = Yii::$app->request;
        $data = array_merge($request->getBodyParams(), $request->getQueryParams());
        if (!is_null($name)) {
            return isset($data[$name]) && $data[$name] != '' ? $data[$name] : $defaultValue;
        }
        return $data;
    }
}
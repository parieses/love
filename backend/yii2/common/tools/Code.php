<?php


namespace common\tools;

//api错误码定义 http://so.chatm.com/code
class Code
{
    private const ERROR_CODE = 0;     //失败码
    private const SUCCESS_CODE = 1;   //成功码
    private const NOTICE_CODE = 2;    //警示码
    private const SOURCE_CODE = 3;    //来源错误码
    private const ACCESS_CODE = 4;    //权限错误码
    private const TOKEN_CODE = 5 ;     //非法
    private const IP_CODE = 6;
    Private const NO_FIND_CODE = 404;


    /**
     * @return int
     */
    public static function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }

    /**
     * @return int
     */
    public static function getSuccessCode(): int
    {
        return self::SUCCESS_CODE;
    }

    /**
     * @return int
     */
    public static function getTokenCode(): int
    {
        return self::TOKEN_CODE;
    }

    /**
     * @return int
     */
    public static function getSourceCode(): int
    {
        return self::SOURCE_CODE;
    }

    public static function getAccessToken(): int
    {
        return self::ACCESS_CODE;
    }

    public static function getIpCode(): int
    {
        return self::IP_CODE;
    }

    public static function getNoFindCode(): int
    {
        return self::NO_FIND_CODE;
    }

    public static function getNoticeCode(): int
    {
        return self::NOTICE_CODE;
    }
}
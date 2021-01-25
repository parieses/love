<?php

namespace common\enums;

/**
 * 状态枚举
 *
 * Class StatusEnum
 * @package common\enums
 */
class StatusEnum extends BaseEnum
{
    public const ENABLED = 1;
    public const DISABLED = 0;
    public const DELETE = -1;

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::ENABLED => '启用',
            self::DISABLED => '禁用',
            self::DELETE => '已删除',
        ];
    }
}
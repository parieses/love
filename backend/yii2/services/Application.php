<?php

namespace services;

use common\components\Service;

/**
 * Class Application
 * @package services
 * @property \services\TestService $test 菜单
 */
class Application extends Service
{
    /**
     * @var array
     */
    public $childService = [
        'test' => 'services\TestService',
    ];
}
<?php


namespace services;


use common\components\Service;

class TestService extends Service
{
    public function test(): int
    {
        return 12;
    }
}
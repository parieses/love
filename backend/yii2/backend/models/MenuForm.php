<?php

namespace backend\models;

use common\models\Menu;


class MenuForm extends Menu
{

    private $model;

    /**
     * @desc 验证规则
     */
    public function rules(): array
    {
        return [
            ['id', 'integer'],
            ['id', 'required', 'on' => ['update']],
            [['url','type','describe','pid'], 'required'],
            ['url', 'unique', 'targetClass' => Menu::class, 'message' => '路由已存在', 'on' => 'create'],
        ];
    }

}
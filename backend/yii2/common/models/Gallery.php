<?php

namespace common\models;


use common\tools\Tool;
use common\traits\Time;

class Gallery extends \common\models\base\Gallery
{
    use Time;

    public static function create($file_md5, $path, $type = 1)
    {
        $gallery = new Gallery();
        $gallery->md5 = $file_md5;
        $gallery->type = $type;
        $gallery->url = $path;
        return $gallery->save() ? $gallery->id : Tool::getFirstErrorMessage($gallery->firstErrors);
    }

    public static function changeCount($id, $type = 1)
    {
        $gallery = Gallery::findOne($id);
        if ($type == 1) {
            $gallery->count++;
        } else {
            $gallery->count--;
        }
        if ($gallery->count == 0) {
            $gallery->status = -1;
        }
        return $gallery->save();
    }
}

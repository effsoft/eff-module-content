<?php

namespace effsoft\eff\module\content\modules\admin\controllers;

use effsoft\eff\EffActiveRecord;

class CategoryModel extends EffActiveRecord{

    public static function collectionName()
    {
        return 'Category';
    }

    public function attributes()
    {
        return [
            '_id',
            'name',
            'parent'
        ];
    }
}
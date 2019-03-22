<?php

namespace effsoft\eff\module\content\modules\admin\models;

use effsoft\eff\EffModel;

class CategoryCreateForm extends EffModel{
    public $name;
    public $parent;

    public function rules(){
        return [
            ['name','required','message' => '请填写分类名称！'],

        ];
    }
}
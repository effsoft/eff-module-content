<?php

namespace effsoft\eff\module\content\models;

use effsoft\eff\EffModel;

class CategoryForm extends EffModel{
    public $name;
    public $parent_id;
    public $description;

    public function rules(){
        return [
            ['name','required','message' => '请填写分类名称！'],
            ['parent_id','string'],
            ['description', 'string'],
        ];
    }
}
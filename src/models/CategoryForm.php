<?php

namespace effsoft\eff\module\content\models;

use effsoft\eff\EffModel;

class CategoryCreateForm extends EffModel{
    public $name;
    public $parent_id;
    public $description;
//    public $extra_key;
//    public $extra_value;

    public function rules(){
        return [
            ['name','required','message' => '请填写分类名称！'],
            ['parent_id','string'],
            ['description', 'string'],
//            ['extra_key', 'each', 'rule' => ['string']],
//            ['extra_value', 'each', 'rule' => ['string']],
        ];
    }
}
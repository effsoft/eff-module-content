<?php

namespace effsoft\eff\module\content\models;

use effsoft\eff\EffModel;

class CategoryForm extends EffModel
{
    public $name;
    public $type;
    public $parent_id;
    public $description;

    public function rules()
    {
        return [
            ['name', 'required'],
            [['name','description','type','parent_id'], 'trim'],
            ['type', 'required'],
            ['parent_id', 'string'],
            ['description', 'string'],
        ];
    }
}
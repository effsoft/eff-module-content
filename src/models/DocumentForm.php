<?php
namespace effsoft\eff\module\content\models;

use effsoft\eff\EffModel;

class DocumentForm extends EffModel{

    public $subject;
    public $category;
    public $introduction;
    public $content;

    public function rules(){
        return [
            ['subject','required','message' => '请填写文章标题！'],
            ['category','string'],
            ['introduction', 'string'],
            ['content', 'string'],
        ];
    }
}
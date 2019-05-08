<?php
namespace effsoft\eff\module\content\models;

use effsoft\eff\EffModel;

class DocumentForm extends EffModel{

    public $subject;
    public $category;
    public $author;
    public $cover;
    public $carousel;
    public $introduction;
    public $content;

    public function rules(){
        return [
            ['subject', 'required'],
            ['category', 'string'],
            ['author', 'safe'],
            ['cover', 'safe'],
            ['carousel', 'safe'],
            ['introduction', 'string'],
            ['content', 'string'],
        ];
    }
}
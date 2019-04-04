<?php
namespace effsoft\eff\module\content\services;

use effsoft\eff\EffService;
use effsoft\eff\helpers\Ids;

class CategoryService extends EffService{

    public static function get_category($id,$categories){
        foreach ($categories as $category){
            if ($id == strval($category->_id)){
                return $category;
            }
        }
    }
}
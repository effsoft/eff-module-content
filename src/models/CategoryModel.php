<?php

namespace effsoft\eff\module\content\models;

use effsoft\eff\EffActiveRecord;
use effsoft\eff\EffMysqlActiveRecord;
use effsoft\eff\helpers\Ids;
use yii\helpers\ArrayHelper;

class CategoryModel extends EffMysqlActiveRecord
{

//    public static function collectionName()
//    {
//        return 'Category';
//    }

    public static function tableName()
    {
        return 'category';
    }

    public function rules()
    {
        return [
            [['order','type'], 'integer'],
        ];
    }



    public function attributes()
    {
        return [
            'id',
            'uid',
            'name',
            'type',
            'description',
            'parent_id',
            'order',
        ];
    }

//    public function beforeSave($insert)
//    {
//        if(parent::beforeSave($insert)){
//            if($this->isNewRecord){
//
//            }
//            return true;
//        }
//        return false;
//    }

//    public function getParentDropdownCategories(){
//        $array = self::find()->where(['parent_id'=>''])->orderBy(['order' => SORT_DESC])->asArray()->all();
//        $array = self::buildTree($array);
//        $array = ArrayHelper::map($array, function ($model) {
//            return Ids::encodeId((string)$model['_id']);
//        }, 'name');
//        return $array;
//    }
//
//    public function getDropdownCategories()
//    {
//        $array = self::find()->orderBy(['order' => SORT_DESC])->asArray()->all();
//        $array = self::buildTree($array);
//        $array = ArrayHelper::map($array, function ($model) {
//            return Ids::encodeId((string)$model['_id']);
//        }, 'name');
//        return $array;
//    }
//
//
//    private function buildTree($array, $parentId = null, $preWord = '')
//    {
//        if (!empty($preWord))
//            $preWord .= '-';
//
//        $tmpArray = [];
//        foreach ($array as $element) {
//            if ($element['parent_id'] == $parentId) {
//                $tmpArray[] = ['_id' => $element['_id'], 'name' => $preWord . $element['name']];
//                $tmp = self::buildTree($array, $element['_id'], '-');
//                if (!empty($tmp) && is_array($tmp)) {
//                    foreach ($tmp as $item) {
//                        $tmpArray[] = ['_id' => $item['_id'], 'name' => $item['name']];
//                    }
//                }
//            }
//        }
//        return $tmpArray;
//    }
}
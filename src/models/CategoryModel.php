<?php

namespace effsoft\eff\module\content\models;

use effsoft\eff\EffActiveRecord;
use yii\helpers\ArrayHelper;

class CategoryModel extends EffActiveRecord
{

    public static function collectionName()
    {
        return 'Category';
    }

    public function attributes()
    {
        return [
            '_id',
            'name',
            'description',
            'parent_id',
            'order',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->order = CategoryModel::find()->count();
            }
            return true;
        }
        return false;
    }

    public function getDropdownCategories()
    {
        $array = self::find()->orderBy(['order' => SORT_DESC])->asArray()->all();
        $array = self::buildTree($array);
        $array = ArrayHelper::map($array, function ($model) {
            return (string)$model['_id'];
        }, 'name');
        return $array;
    }


    private function buildTree($array, $parentId = null, $preWord = '')
    {
        if (!empty($preWord))
            $preWord .= '-';

        $tmpArray = [];
        foreach ($array as $element) {
            if ($element['parent_id'] == $parentId) {
                $tmpArray[] = ['_id' => $element['_id'], 'name' => $preWord . $element['name']];
                $tmp = self::buildTree($array, $element['_id'], '-');
                if (!empty($tmp) && is_array($tmp)) {
                    foreach ($tmp as $item) {
                        $tmpArray[] = ['_id' => $item['_id'], 'name' => $item['name']];
                    }
                }
            }
        }
        return $tmpArray;
    }
}
<?php
namespace effsoft\eff\module\content\models;

use effsoft\eff\EffActiveRecord;
use yii\helpers\ArrayHelper;

class DocumentModel extends EffActiveRecord{

    public static function collectionName()
    {
        return 'Document';
    }

    public function attributes()
    {
        return [
            '_id',
            'uid',
            'subject',
            'category',
            'author',
            'cover',
            'carousel',
            'introduction',
            'content',
            'date_created',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->date_created = time();
            }
            return true;
        }
        return false;
    }
}
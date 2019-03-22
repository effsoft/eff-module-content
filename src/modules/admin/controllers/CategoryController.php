<?php
namespace effsoft\eff\module\content\modules\admin\controllers;

use effsoft\eff\EffController;


class CategoryController extends EffController{

    public function init(){
        parent::init();
        $this->pushBreadcrumbLink([
            'label' => \Yii::t('eff-module-content/app', 'Category'),
            'url' => ['/content/admin/category/manage'],
        ]);
    }

    public function actionManage(){
        $this->pushBreadcrumbLink([
            'label' => \Yii::t('eff-module-content/app', 'Manage'),
        ]);
        return $this->render('//content/admin/category/manage');
    }

    public function actionCreate(){
        $this->pushBreadcrumbLink([
            'label' => \Yii::t('eff-module-content/app', 'Create'),
        ]);
        return $this->render('//content/admin/category/create');
    }
}
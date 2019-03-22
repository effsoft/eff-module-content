<?php

namespace effsoft\eff\module\content\modules\admin\controllers;

use effsoft\eff\EffController;
use effsoft\eff\module\content\modules\admin\models\CategoryCreateForm;
use effsoft\eff\module\content\modules\admin\models\CategoryModel;
use yii\filters\AccessControl;
use yii\helpers\Url;


class CategoryController extends EffController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['manage', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function init()
    {
        parent::init();
        $this->pushBreadcrumbLink([
            'label' => \Yii::t('eff-module-content/app', 'Category'),
            'url' => ['/content/admin/category/manage'],
        ]);
    }

    public function actionManage()
    {
        $this->pushBreadcrumbLink([
            'label' => \Yii::t('eff-module-content/app', 'Manage'),
        ]);
        return $this->render('//content/admin/category/manage');
    }

    public function actionCreate()
    {
        $this->pushBreadcrumbLink([
            'label' => \Yii::t('eff-module-content/app', 'Create'),
        ]);

        $category_create_form = new CategoryCreateForm();

        if (\Yii::$app->request->isPost) {
            $category_create_form->load(\Yii::$app->request->post());
            if (!$category_create_form->validate()) {
                return $this->render('//content/admin/category/create',
                    [
                        'category_create_form' => $category_create_form,
                    ]);
            }

            $category = CategoryModel::findOne(['name' => $category_create_form->name]);
            if (!empty($category)) {
                $category_create_form->addError('db', '该分类名已被占用！');
                return $this->render('//content/admin/category/create',
                    [
                        'login_form' => $category_create_form,
                    ]);
            }

            $category = new CategoryModel();
            $category->name = $category_create_form->name;
            $category->parent_id = $category_create_form->parent_id;
            if (!$category->save()) {
                $category_create_form->addError('db', '无法保存新的分类！');
                return $this->render('//content/admin/category/create',
                    [
                        'login_form' => $category_create_form,
                    ]);
            }

            return \Yii::$app->response->redirect(Url::to(['/content/admin/category/manage']));

        }

        return $this->render('//content/admin/category/create',
            [
                'category_create_form' => $category_create_form,
            ]);
    }
}
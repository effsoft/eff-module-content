<?php

namespace effsoft\eff\module\content\modules\admin\controllers;

use effsoft\eff\EffController;
use effsoft\eff\helpers\Ids;
use effsoft\eff\module\content\models\CategoryForm;
use effsoft\eff\module\content\models\CategoryModel;
use effsoft\eff\response\JsonResult;
use MongoDB\BSON\Regex;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Response;


class CategoryController extends EffController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['manage', 'create', 'delete', 'edit'],
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
            'label' => \Yii::t('content/app', 'Category'),
            'url' => ['/content/admin/category/manage'],
        ]);
    }

    public function actionManage()
    {
        $this->pushBreadcrumbLink([
            'label' => \Yii::t('content/app', 'Manage'),
        ]);
        return $this->render('//content/admin/category/manage');
    }

    public function actionCreate()
    {
        $this->pushBreadcrumbLink([
            'label' => \Yii::t('content/app', 'Create'),
        ]);

        $category_form = new CategoryForm();

        if (\Yii::$app->request->isPost) {
            $category_form->load(\Yii::$app->request->post());
            if (!$category_form->validate()) {
                return $this->render('//content/admin/category/create',
                    [
                        'category_form' => $category_form,
                    ]);
            }

            $category = CategoryModel::findOne(['name' => new Regex("^$category_form->name$", 'i')]);
            if (!empty($category)) {
                $category_form->addError('db', '该分类名已被占用！');
                return $this->render('//content/admin/category/create',
                    [
                        'category_form' => $category_form,
                    ]);
            }

            $category = new CategoryModel();
            $category->name = $category_form->name;
            $category->parent_id = Ids::decodeId($category_form->parent_id);
            $category->description = $category_form->description;
            if (!$category->save()) {
                $category_form->addError('db', '无法保存新的分类！');
                return $this->render('//content/admin/category/create',
                    [
                        'category_form' => $category_form,
                    ]);
            }

            return \Yii::$app->response->redirect(Url::to(['/content/admin/category/manage']));

        }

        return $this->render('//content/admin/category/create',
            [
                'category_form' => $category_form,
            ]
        );
    }

    public function actionDelete()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!\Yii::$app->request->isAjax) {
            return JsonResult::getNewInstance()->setStatus(101)
                ->setMessage('Bad request!')
                ->getResponse();
        }

        if (!\Yii::$app->request->validateCsrfToken()) {
            return JsonResult::getNewInstance()->setStatus(102)
                ->setMessage('Bad csrf token!')
                ->getResponse();
        }

        $category_id = Ids::decodeId(\Yii::$app->request->post('category_id'));
        if (empty($category_id)) {
            return JsonResult::getNewInstance()->setStatus(103)
                ->setMessage('Bad parameters!')
                ->getResponse();
        }

        //check child cateogry
        $sub_cates = CategoryModel::findAll(['parent_id' => $category_id]);
        if (!empty($sub_cates)) {
            return JsonResult::getNewInstance()->setStatus(104)
                ->setMessage('Delete sub categories first!')
                ->getResponse();
        }

        if (!CategoryModel::deleteAll(['_id' => $category_id])) {
            return JsonResult::getNewInstance()->setStatus(105)
                ->setMessage('DB error!')
                ->getResponse();
        }

        //success
        return JsonResult::getNewInstance()->setStatus(0)
            ->setMessage('')
            ->getResponse();
    }

    public function actionEdit()
    {
        $this->pushBreadcrumbLink([
            'label' => \Yii::t('content/app', 'Edit'),
        ]);

        $category_form = new CategoryForm();

        $category_id = Ids::decodeId(\Yii::$app->request->get('id'));
        if (empty($category_id)) {
            return $this->redirect(\Yii::$app->request->getReferrer());
        }
        $category = CategoryModel::findOne(['_id' => $category_id]);
        if (empty($category_id)) {
            return $this->redirect(\Yii::$app->request->getReferrer());
        }

        if (\Yii::$app->request->isPost) {
            $category_form->load(\Yii::$app->request->post());
            if (!$category_form->validate()) {
                return $this->render('//content/admin/category/create',
                    [
                        'category_form' => $category_form,
                    ]);
            }

            $category->name = $category_form->name;
            $category->description = $category_form->description;
            $category->parent_id = Ids::decodeId($category_form->parent_id);

            if (!$category->save()) {

            }

            return \Yii::$app->response->redirect(Url::to(['/content/admin/category/manage']));
        }

        $category_form->setAttributes([
            '_id' => $category->_id,
            'name' => $category->name,
            'description' => $category->description,
            'parent_id' => $category->parent_id,
        ]);

        return $this->render('//content/admin/category/edit',
            [
                'category_form' => $category_form,
            ]);
    }

}
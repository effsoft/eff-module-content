<?php

namespace effsoft\eff\module\content\modules\admin\controllers;

use Couchbase\Document;
use effsoft\eff\EffController;
use effsoft\eff\module\content\models\CategoryModel;
use effsoft\eff\module\content\models\DocumentForm;
use effsoft\eff\module\content\models\DocumentModel;
use effsoft\eff\module\media\models\MediaModel;
use effsoft\eff\response\JsonResult;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DocumentController extends EffController{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['manage', 'create', 'validate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    function actionManage(){
        return $this->render('//content/admin/document/manage',[]);
    }

    function actionValidate(){

        \Yii::$app->response->format = Response::FORMAT_JSON;

        if(!\Yii::$app->request->isAjax || !\Yii::$app->request->isPost){
            return JsonResult::getNewInstance()->setStatus(101)
                ->setMessage('Bad request!')
                ->getResponse();
        }

        if (!\Yii::$app->request->validateCsrfToken()) {
            return JsonResult::getNewInstance()->setStatus(102)
                ->setMessage('Bad csrf token!')
                ->getResponse();
        }

        $action = \Yii::$app->request->get('a');
        if (empty($action)){
            return JsonResult::getNewInstance()->setStatus(103)
                ->setMessage('Bad parameters!')
                ->getResponse();
        }

        switch ($action){
            case 'create':
                $model = new DocumentForm();
                break;
            default:
                return JsonResult::getNewInstance()->setStatus(104)
                    ->setMessage('Bad parameters!')
                    ->getResponse();
        }
        $model->load(\Yii::$app->request->post());
        return ActiveForm::validate($model);

    }

    function actionCreate(){
        $document_form = new DocumentForm();

        if(\Yii::$app->request->isAjax){
            \Yii::$app->response->format = Response::FORMAT_JSON;

            if(!\Yii::$app->request->isAjax || !\Yii::$app->request->isPost){
                return JsonResult::getNewInstance()->setStatus(101)
                    ->setMessage('Bad request!')
                    ->getResponse();
            }

            if (!\Yii::$app->request->validateCsrfToken()) {
                return JsonResult::getNewInstance()->setStatus(102)
                    ->setMessage('Bad csrf token!')
                    ->getResponse();
            }

            if(\Yii::$app->request->isPost && $document_form->load(\Yii::$app->request->post())){

                $document_model = new DocumentModel();
                $document_model->uid = strval(\Yii::$app->user->identity->getId());
                $document_model->subject = $document_form->subject;
                $document_model->category = $document_form->category;
                $document_model->author = $document_form->author;
                if (!empty($document_form->cover)) {
                    $document_model->cover = MediaModel::findOne(['_id' => $document_form->cover])->toArray();
                }
                if (!empty($document_form->carousel)){
                    $document_model->carousel = ArrayHelper::toArray(MediaModel::findAll(['_id' =>  $document_form->carousel]));
                }
                $document_model->introduction = $document_form->introduction;
                $document_model->content = $document_form->content;

                $document_model->save();

                return JsonResult::getNewInstance()->setStatus(0)
                    ->setMessage('')
                    ->getResponse();
            }
        }

        return $this->render('//content/admin/document/create',[
            'document_form' => $document_form,
        ]);
    }
}
<?php

namespace effsoft\eff\module\content\modules\admin\controllers;

use effsoft\eff\EffController;
use effsoft\eff\module\content\models\DocumentForm;
use yii\filters\AccessControl;

class DocumentController extends EffController{

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

    function actionManage(){
        return $this->render('//content/admin/document/manage',[]);
    }

    function actionCreate(){
        $document_form = new DocumentForm();

        return $this->render('//content/admin/document/create',[
            'document_form' => $document_form,
        ]);
    }
}
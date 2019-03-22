<?php

namespace effsoft\eff\module\content;

use effsoft\eff\EffModule;

class Module extends EffModule {

    public $module_name = 'eff-module-content';

    public function init(){
        parent::init();

        \Yii::setAlias('@'.$this->module_name, __DIR__);

        $this->registTranslations();
        $this->registSubModules();
    }

    public function registSubModules(){
        $this->modules = [
            'admin' => [
                'class' => 'effsoft\eff\module\content\modules\admin\Module',
            ],
        ];
    }

    public function registTranslations()
    {
        \Yii::$app->i18n->translations[$this->module_name .'/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => __DIR__ . '\\messages',
            'fileMap' => [
                $this->module_name .'/app' => 'app.php',
                $this->module_name .'/error' => 'error.php',
            ],
        ];
    }
}
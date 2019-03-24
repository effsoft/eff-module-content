<?php

namespace effsoft\eff\module\content;

use effsoft\eff\EffModule;

class Module extends EffModule {

    public $module_name = 'content';
    public $dir = __DIR__;

    public function init(){
        parent::init();

        \Yii::setAlias('@'.$this->module_name, __DIR__);

        $this->registAlias();

        $this->registerThemes();

        $this->registTranslations();

        $this->registSubModules(
            [
                'admin' =>
                    [
                        'class' => 'effsoft\eff\module\content\modules\admin\Module',
                    ],
            ]
        );
    }
}
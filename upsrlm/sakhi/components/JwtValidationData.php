<?php

namespace sakhi\components;

use Yii;

class JwtValidationData extends \sizeg\jwt\JwtValidationData {

    /**
     * @inheritdoc
     */
    public function init() {
//        print_r($this->validationData);exit;
        $this->validationData->setIssuer(\Yii::$app->params['app_url']['sakhi']);
        $this->validationData->setAudience(\Yii::$app->params['app_url']['sakhi']);
        $this->validationData->setId('4f1g23a12aa');

        parent::init();
    }

}

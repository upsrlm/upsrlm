<?php

namespace common\components;

class JwtValidationData extends \sizeg\jwt\JwtValidationData
{
 
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->validationData->setIssuer(\Yii::$app->params['app_url']['sakhi']);
        $this->validationData->setAudience(\Yii::$app->params['app_url']['sakhi']);
        $this->validationData->setId('4f1g23a12aa');

        parent::init();
    }
}    
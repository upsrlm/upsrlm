<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class MissingBCMapForm extends \yii\base\Model {

    public $bc_application_id;
    public $bc_application_model;

    public function __construct($missing_model) {
        
    }

    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['bc_application_id'], 'integer'],
            ['bc_application_id', function ($attribute, $params) {
                    $bc=SrlmBcApplication::findOne(['id' => $this->$attribute]);
                    if ($bc==null) {
                        $this->addError($attribute, 'BC Application Id Invalid');
                    }
                }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bc_application_id' => 'BC Application Id',
        ];
    }

}

<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class RevertFundsTransferForm extends \yii\base\Model {

    public $revert;
    public $application_model;
    public $shg_model;
    public function __construct($application_model) {
        $this->application_model = $application_model;
        $this->shg_model = \cbo\models\Shg::findOne($this->application_model->cbo_shg_id);
    }

    public function rules() {
        return [
            [['revert'], 'required', 'requiredValue' => 1, 'message' => 'Please checked the revert checkbox'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'revert' => 'Revert BC-SHG payment status',
        ];
    }

}

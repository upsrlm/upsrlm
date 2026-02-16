<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class BC194AcForm extends \yii\base\Model {

    public $bc_settlement_ac_194n;
    public $bc_settlement_ac_194n_date;
    public $bc_settlement_ac_194n_by;
    public $bc_model;

    public function __construct($model) {
        $this->bc_model = $model;
    }

    public function rules() {
        return [
            [['bc_settlement_ac_194n'], 'required'],
            [['bc_settlement_ac_194n'], 'compare', 'compareValue' => true, 'message' => 'Please tick BC settlement a/c tagged for 194N'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bc_settlement_ac_194n' => 'BC settlement a/c tagged for 194N',
        ];
    }

}

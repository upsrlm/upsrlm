<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class BCBlockedForm extends \yii\base\Model {

    public $blocked;
    public $blocked_option;
    public $bc_model;

    public function __construct($model) {
        $this->blocked_option = [SrlmBcApplication::BLOCKED_STATUS_BC_GP => 'GP Mismatch'];
        $this->bc_model = $model;
    }

    public function rules() {
        return [
            [['blocked'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'blocked' => 'Blocked Reason',
        ];
    }

}

<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class TransactionDateValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class TransactionDateValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        $minimu_date_alowed = '2021-01-01';
        $maximum_date_alowed = date('Y-m-d');
        if (isset($model->transaction_datetime)) {
            if (strtotime($model->transaction_datetime) < strtotime($minimu_date_alowed)) {
                $this->addError($model, $attribute, 'Transaction date time ' . $model->transaction_datetime . ' not allowed');
            }
            if (strtotime($model->transaction_datetime) > strtotime($maximum_date_alowed)) {
                $this->addError($model, $attribute, 'Transaction date time ' . $model->transaction_datetime . ' not allowed');
            }
            $dv = \common\helpers\Utility::validateDateFormat($model->transaction_datetime);
            if (!$dv) {
                $this->addError($model, $attribute, 'Transaction date time ' . $model->transaction_datetime . ' not allowed');
            }
        }
    }
}

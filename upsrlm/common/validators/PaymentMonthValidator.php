<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class PaymentMonthValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class PaymentMonthValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        $minimu_date_alowed = '2021-01-01';
        $maximum_date_alowed = date('Y-m-d');
        if (isset($model->$attribute) and $model->$attribute != '') {
            if (strtotime($model->$attribute) < strtotime($minimu_date_alowed)) {
                $this->addError($model, $attribute, 'Payment month ' . $model->$attribute . ' not allowed');
            }
//            if (strtotime($model->$attribute) > strtotime($maximum_date_alowed)) {
//                $this->addError($model, $attribute, 'Payment month ' . $model->$attribute . ' not allowed');
//            }
        }
    }

}

<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class UnwillingReasionValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BankUnwillingValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->unwilling_reason)) {
            if (in_array(20, $model->unwilling_reason)) {

                if (count($model->unwilling_reason) > 1) {
                    $this->addError($model, $attribute, 'केवल बीसी सखी की मृत्यु हो गई है चुने');
                }
            }
        }
    }

}

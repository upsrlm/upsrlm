<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class UnwillingReasionValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UnwillingReasionValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->unwilling_reason)) {
            if (in_array(7, $model->unwilling_reason)) {

                
            }
        }
    }

}

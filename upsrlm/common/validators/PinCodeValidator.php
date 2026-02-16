<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class PinCodeValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class PinCodeValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if ($model->$attribute != '') {
            if (!preg_match('/^[0-9]{6}+$/', $model->$attribute)) {
                $this->addError($model, $attribute, 'In valid pin code');
            }
        }
    }

}

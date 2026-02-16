<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class BankAccountNoValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BankAccountNoValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if ($model->$attribute) {
            if (!preg_match("/^[0-9]{9,18}+$/", $model->$attribute)) {
                $this->addError($model, $attribute, 'Invalid Bank Account No');
            }
        }
    }

}

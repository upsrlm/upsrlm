<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class BankAccountNoValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BankIFSCValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if ($model->$attribute) {
            if (!preg_match("/^[A-Z]{4}0[A-Z0-9]{6}$/", $model->$attribute)) {
                $this->addError($model, $attribute, 'Invalid Bank IFSC Code');
            }
        }
    }

}

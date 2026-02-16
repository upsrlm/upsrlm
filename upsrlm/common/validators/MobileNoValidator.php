<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class MobleNoValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class MobileNoValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->$attribute) and $model->$attribute != '') {
            if (!preg_match('/^[456789]\d{9}$/', $model->$attribute)) {
                $this->addError($model, $attribute, 'In Valid Mobile No');
            }
        }
    }

}

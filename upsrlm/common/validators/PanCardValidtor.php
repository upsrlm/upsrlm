<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class PanCardValidtor
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class PanCardValidtor extends Validator {

    public function validateAttribute($model, $attribute) {
        if ($model->$attribute != '') {
            if (!preg_match('/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/', $model->$attribute)) {
                $this->addError($model, $attribute, 'In Valid PAN number');
            }
        }
    }

}

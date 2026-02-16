<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class GstinValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class GstinValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        //"/^(0[1-9]|[1-2][0-9]|3[0-5])([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([a-zA-Z0-9]){1}([a-zA-Z]){1}([0-9]){1}?$/"
         $regex = "/^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/";
        if ($model->$attribute) {
            if (!preg_match($regex, $model->$attribute)) {
                $flag = "Invalid GST number ";
                $this->addError($model, $attribute, 'Invalid GST number');
            }
        }
    }

}

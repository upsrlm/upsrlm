<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Voter ID Card Number Validtor
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */
class VoterIDValidator extends Validator
{

    public function validateAttribute($model, $attribute)
    {
        if ($model->$attribute != '') {
            if (!preg_match('/^([a-zA-Z]){3}([0-9]){7}?$/', $model->$attribute)) {
                $this->addError($model, $attribute, 'In Valid Voter ID number');
            }
        }
    }
}

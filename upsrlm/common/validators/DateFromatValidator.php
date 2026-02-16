<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class DateFromatValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class DateFromatValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->$attribute)) {
            if (!$this->validateDate($model->$attribute)) {
                $this->addError($model, $attribute, 'Invalid date format  not allowed');
            }
        }
    }

    public function validateDate($date, $format = 'Y-m-d') {
        $d = \DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

}

<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class Fbpo99Validator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Fbpo99Validator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->principal_occupation)) {
            if (in_array(99, $model->principal_occupation)) {
                if ($model->principal_occupation99_text == '') {
                    $this->addError($model, 'principal_occupation99_text', 'Required');
                }
            }
        }
    }

}

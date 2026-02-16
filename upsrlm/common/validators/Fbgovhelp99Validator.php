<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class Fbgovhelp99Validator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Fbgovhelp99Validator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->what_can_government_help)) {
            if (in_array(99, $model->what_can_government_help)) {
                if ($model->what_can_government_help99_text == '') {
                    $this->addError($model, 'what_can_government_help99_text', 'Required');
                }
            }
        }
    }

}

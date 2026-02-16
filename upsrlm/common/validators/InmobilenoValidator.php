<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class InmobilenoValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class InmobilenoValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->$attribute) and $model->$attribute != '') {
            if (!preg_match('/^[6789]\d{9}$/', $model->$attribute)) {
                $this->addError($model, $attribute, 'अमान्य मोबाइल नंबर');
            }
        }
    }

}

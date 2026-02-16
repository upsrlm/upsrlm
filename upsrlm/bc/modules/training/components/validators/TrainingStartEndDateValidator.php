<?php

namespace bc\modules\training\components\validators;

use yii\validators\Validator;

/**
 * Class TrainingStartEndDateValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class TrainingStartEndDateValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if ($model->training_start_date != '' && $model->training_end_date != '') {
            if (strtotime($model->training_end_date) < strtotime($model->training_start_date)) {
                $this->addError($model, 'training_end_date', "$model->training_end_date end date can not less than $model->training_start_date start date");
            }
        }
    }

}

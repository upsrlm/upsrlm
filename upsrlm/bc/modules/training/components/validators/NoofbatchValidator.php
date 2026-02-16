<?php

namespace bc\modules\training\components\validators;

use yii\validators\Validator;

/**
 * Class TrainingStartEndDateValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class NoofbatchValidator extends Validator {

    public function validateAttribute($model, $attribute) {
//        if ($model->center_training_model->no_of_batch < $model->no_of_batch) {
//            $this->addError($model, 'no_of_batch', " no of batch can not less than " . $model->center_training_model->no_of_batch);
//        }
    }

}

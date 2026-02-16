<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class StartDateAndEndDareValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class StartDateAndEndDateValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if ($model->work_start_date != '' && $model->work_end_date != '') {
            if (strtotime($model->work_end_date) < strtotime($model->work_start_date)) {
                $this->addError($model, 'work_end_date', "To date not less than from date");
            }
        }
    }

}

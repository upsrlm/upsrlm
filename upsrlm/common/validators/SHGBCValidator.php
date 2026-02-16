<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class SHGBCValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class SHGBCValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->shg_model->id)) {
            $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne(['cbo_shg_id' => $model->shg_model->id]);
            if ($bc_model != null) {
               // $this->addError($model, 'name_of_shg', 'You can not update this SHG.This SHG assigned with BC Sakhi');
            }
        }
    }

}

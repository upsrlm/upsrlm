<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;

/**
 * Class WadaOfficerValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class WadaOfficerValidator extends Validator {

    public function validateAttribute($model, $attribute) {

        if ($model->scenario == 'section4') {
            if ($model->existing_member == 1) {
                if (($model->officer1 + $model->officer2 + $model->officer3 + $model->officer4 + $model->officer5 + $model->officer6 + $model->officer7 + $model->officer8 + $model->officer9 + $model->officer10 + $model->officer11 + $model->officer12) == 0) {
                    $this->addError($model, $attribute, 'अगर हाँ तो क्या चुने ');
                }
            }
        }
    }

}

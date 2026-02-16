<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class SbiDistrictBlockedValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class SbiDistrictBlockedValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        $sbi_districts = [124, 134, 145, 152, 158, 167, 168, 169, 172, 177, 660, 181, 131, 178, 182, 137, 148, 160, 164];
        $user_model = \Yii::$app->user->identity;
        if ($model->bc_application_model->gp->master_partner_bank_id != $user_model->master_partner_bank_id) {
            $this->addError($model, $attribute, $model->bc_application_model->name . ' assign to '.$model->bc_application_model->gp->cbank->bank_name);
        }
    }
}

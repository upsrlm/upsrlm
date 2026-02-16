<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\User;
use bc\modules\selection\models\SrlmBcSelectionUser;

/**
 * Class BcMobileNoValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BcMobileNoValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->$attribute) and $model->$attribute != '') {
            $bc_sel_user = SrlmBcSelectionUser::findOne(['mobile_no' => $model->$attribute]);
            if ($bc_sel_user != null) {
                if ($bc_sel_user->id == $model->bc_selection_user_model->id) {
                    
                } else {
                    $this->addError($model, $attribute, 'This mobile no. already use another BC Sackhi');
                }
            }
            $user = User::findOne(['username' => $model->$attribute]);
            if ($user != null) {
                if (isset($model->bc_user_model) and $model->bc_user_model->id == $user->id) {
                    
                } else {
                    $this->addError($model, $attribute, 'This mobile no. already use another user');
                }
            }
        }
    }

}

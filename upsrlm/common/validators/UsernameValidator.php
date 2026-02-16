<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\User;

/**
 * Class BcMobileNoValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UsernameValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->$attribute) and $model->$attribute != '') {
            $user = User::findOne(['username' => $model->$attribute]);
            if ($user != null) {
                if (!in_array($user->role, $model->alow_role))
                    $this->addError($model, $attribute, 'This mobile no. does not exist');
            }
        }
    }
}

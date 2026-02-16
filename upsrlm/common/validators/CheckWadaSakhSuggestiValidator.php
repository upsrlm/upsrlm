<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;

/**
 * Class CheckWadaSakhSuggestiValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CheckWadaSakhSuggestiValidator extends Validator {

    public $member_model;

    public function validateAttribute($model, $attribute) {
        if (isset($model->$attribute) and $model->$attribute != '') {
            $this->member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::findOne($model->$attribute);
            $ch_bc = \common\models\User::find()->joinWith(['cboprofile'])->where(['user.username' => $this->member_model->mobile])->andWhere(['=', 'user.role', 100])->andWhere(['=', 'cbo_member_profile.bc', 1])->one();
            $ch = \common\models\User::find()->where(['username' => $this->member_model->mobile])->andWhere(['!=', 'role', 100])->count();
            if ($ch) {
                $this->addError($model, $attribute, $this->member_model->name . ' वाड़ा सखी के रूप में अनुमति नहीं है ');
            }
            if ($ch_bc != null) {
                if ($this->member_model->gram_panchayat_code != $ch_bc->gram_panchayat_code) {
                    $this->addError($model, $attribute, $this->member_model->name . ' वाड़ा सखी के रूप में अनुमति नहीं है मोबाइल नंबर बदलें');
                }
            }
        }
    }

}

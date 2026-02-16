<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;

/**
 * Class WadaMemberValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class WadaMemberValidator extends Validator {

    public function validateAttribute($model, $attribute) {

        if ($model->scenario == 'section4') {
            if ($model->applicant_member_other_organization == 1) {
                if (($model->applicant_member_other_organization1 + $model->applicant_member_other_organization2 + $model->applicant_member_other_organization3 + $model->applicant_member_other_organization4 + $model->applicant_member_other_organization5 + $model->applicant_member_other_organization6) == 0) {
                    $this->addError($model, $attribute, 'संगठन के सदस्य या पदाधिकारी हैं चुने ');
                }
            }
        }
    }

}

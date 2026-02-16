<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;

/**
 * Class CheackcboroleValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CheackcboroleValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if ($model->$attribute) {
            // shg member
            if (($model->shg_chairperson + $model->shg_secretary + $model->shg_treasurer + $model->shg_member) > 1) {
                
            }
            
            // vo member
            if (($model->vo_chairperson + $model->vo_secretary + $model->vo_treasurer + $model->vo_member) > 1) {
                
            }
            
            // clf member
            
            if (($model->clf_chairperson + $model->clf_secretary + $model->clf_treasurer + $model->clf_member) > 1) {
                
            }
        }
    }

}

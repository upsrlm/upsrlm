<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;

/**
 * Class TravelWithinGpValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class TravelWithinGpValidator extends Validator {

    public function validateAttribute($model, $attribute) {

        if ($model->scenario == 'section2') {

            if (($model->travel_within_gp1 + $model->travel_within_gp2 + $model->travel_within_gp3 + $model->travel_within_gp4 + $model->travel_within_gp5 + $model->travel_within_gp6 + $model->travel_within_gp7 + $model->travel_within_gp8 + $model->travel_within_gp9 + $model->travel_within_gp10) == 0) {
//                $this->addError($model, 'travel_within_gp1', '');
//                $this->addError($model, 'travel_within_gp2', '');
//                $this->addError($model, 'travel_within_g3', '');
//                $this->addError($model, 'travel_within_gp4', '');
                $this->addError($model, $attribute, 'ग्राम पंचायत के अंदर कैसे यातायात करती हैं चुने ');
            }
        }
    }

}

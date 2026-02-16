<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;

/**
 * Class FeedbackQValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class FeedbackQValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if ($model->$attribute) {
            if (isset($model->$attribute) and count($model->$attribute) > 2) {
                $this->addError($model, $attribute, 'अधिकतम दो विकल्पों पर टिक कर सकते हैं'); 
            }
        }
    }
}

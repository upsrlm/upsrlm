<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;

/**
 * Class WadaElectionFutureValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class WadaElectionFutureValidator extends Validator {

    public function validateAttribute($model, $attribute) {

        if ($model->scenario == 'section4') {
            if ($model->election_in_future == 1) {
                if (($model->election_in_future1 + $model->election_in_future2 + $model->election_in_future3 + $model->election_in_future4 + $model->election_in_future5 + $model->election_in_future6 + $model->election_in_future7 + $model->election_in_future8 + $model->election_in_future9) == 0) {
                    $this->addError($model, $attribute, 'अगर हाँ, तो क्यों  चुने ');
                }
                
            }
        }
    }

}

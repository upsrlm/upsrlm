<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;

/**
 * Class WadaVehicleDriveValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class WadaVehicleDriveValidator extends Validator {

    public function validateAttribute($model, $attribute) {

        if ($model->scenario == 'section2') {

            if (($model->vehicle_drive1 + $model->vehicle_drive2 + $model->vehicle_drive3 + $model->vehicle_drive4 + $model->vehicle_drive5 + $model->vehicle_drive6) == 0) {
                $this->addError($model, $attribute, 'आप किन वाहनों को चलाना जानती है चुने ');
            }
        }
    }

}

<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;

/**
 * Class WadaDeficienciesValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class WadaDeficienciesValidator extends Validator {

    public function validateAttribute($model, $attribute) {

        if ($model->scenario == 'section4') {

            if (($model->major_deficiencies_applicant_competent_leadership1 + $model->major_deficiencies_applicant_competent_leadership2 + $model->major_deficiencies_applicant_competent_leadership3 + $model->major_deficiencies_applicant_competent_leadership4 + $model->major_deficiencies_applicant_competent_leadership5 + $model->major_deficiencies_applicant_competent_leadership6 + $model->major_deficiencies_applicant_competent_leadership7 + $model->major_deficiencies_applicant_competent_leadership8) < 3) {
                $this->addError($model, $attribute, 'सक्षम नेतृत्व करने के लिए आप में प्रमुख तीन कमी चुने ');
            }
        }
    }

}

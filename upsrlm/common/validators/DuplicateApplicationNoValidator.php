<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwApplicant;

/**
 * Class DuplicateApplicationNoValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class DuplicateApplicationNoValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        if (isset($model->$attribute) and $model->application_number != '' and $model->bocw_reg_no and $model->scheme_id) {
            $bocw_model = DbtBeneficiarySchemeBocwApplicant::find()->where(['application_number' => $model->application_number, 'scheme_id' => $model->scheme_id])->limit(1)->one();
            //$bocw_model = DbtBeneficiarySchemeBocwApplicant::find()->where(['application_number' => $model->application_number, 'bocw_reg_no' => $model->bocw_reg_no, 'scheme_id' => $model->scheme_id])->limit(1)->one();
            if (isset($bocw_model) and!empty($bocw_model)) {
                $this->addError($model, $attribute, 'यह आवेदन संख्या पहले ही लिया जा चुका है');
            }
        }
    }

}

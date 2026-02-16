<?php

namespace common\validators;

use yii\validators\Validator;
use common\models\CboMembers;
use bc\modules\selection\models\SrlmBcApplication;

/**
 * Class BCTrainingStatusValidator
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BCTrainingStatusValidator extends Validator {

    public $gp_bc;
    public $rest_gp_bc;

    public function validateAttribute($model, $attribute) {

        if (isset($model->$attribute) and $model->$attribute != '') {
            $this->gp_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->participant_model->gram_panchayat_code, 'status' => 2])->count();
            if ($this->gp_bc == '1') {
                
            } elseif ($this->gp_bc > '1') {

                if (in_array($model->participant_model->training_status, [2])) {
                    
                } else {
                    //$this->addError($model, $attribute, 'You can not change status'); 
                    $this->rest_gp_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->participant_model->gram_panchayat_code, 'status' => 2])->andWhere(['!=', 'id', $model->participant_model->participant->id])->all();
                    foreach ($this->rest_gp_bc as $bc_model) {
                        if (in_array($bc_model->training_status, [0, 1, 2, 3])) {

                            $this->addError($model, $attribute, 'You can not change status');
                        }
                    }
                }
            }
        }
    }

}

<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use common\models\CboMembers;
use common\models\CboMemberProfile;

class RevertBCSHGMapping extends \yii\base\Model {

    public $revert_bc_shg;
    public $bc_model;
    public $cbo_shg_id;

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->cbo_shg_id = $bc_model->cbo_shg_id;
    }

    public function rules() {
        return [
            [['revert_bc_shg'], 'compare', 'compareValue' => true, 'message' => 'Please tick Revert BC SHG Mapping'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'revert_bc_shg' => 'Revert BC SHG Mapping',
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        if ($this->revert_bc_shg) {
            if (!in_array($this->bc_model->bc_shg_funds_status, [1])) {
                $this->bc_model->cbo_shg_id = null;
                $this->bc_model->shg_bank = 0;
                $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_REVERT_BC_SHG_MAPPING;
                if ($this->bc_model->save()) {
                    $model = \common\models\CboMembers::findOne(['cbo_id' => $this->cbo_shg_id, 'user_id' => $this->bc_model->user_id, 'cbo_type' => CboMembers::CBO_TYPE_SHG]);
                    if (isset($model)) {
                        if (($model->shg_chairperson + $model->shg_secretary + $model->shg_treasurer + $model->shg_member + $model->bc_sakhi + $model->samuh_sakhi + $model->wada_sakhi + $model->accountant) > 1) {
                            $model->bc_sakhi = 0;
                            $model->save();
                        } else {
                            $model->bc_sakhi = 0;
                            $model->status = -1;
                            $model->save();
                        }
                    }
                    try {
                        $shg_model = \cbo\models\Shg::findOne($this->cbo_shg_id);
                        $shg_model->bc_user_id = null;
                        $shg_model->save();
                    } catch (\Exception $ex) {
                        
                    }
                    // \common\models\CboMembers::deleteAll('cbo_id = :cbo_id AND user_id = :user_id AND cbo_type = :cbo_type', [':cbo_type' => CboMembers::CBO_TYPE_SHG, ':user_id' => $this->bc_model->user_id, ':cbo_id' => $this->cbo_shg_id]);
                    $condition = ['and',
                        ['=', 'user_id', $this->bc_model->user_id]
                    ];
                    CboMemberProfile::updateAll([
                        'shg' => 0,
                            ], $condition);
                }
            }
        }
        return $this;
    }

}

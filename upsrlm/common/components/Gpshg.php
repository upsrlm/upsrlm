<?php

namespace common\components;

use yii;
use cbo\models\Shg;
use sakhi\components\App;
use common\models\base\GenralModel;
use common\models\User;
use common\models\CboMembers;
use bc\modules\selection\models\SrlmBcApplication;
use common\models\wada\WadaApplication;

class Gpshg extends \yii\base\Component {

    public function assignbc($bc_model, $user_model) {
        try {
            $model_gp = \common\models\master\MasterGramPanchayat::find()->where(['gram_panchayat_code' => $bc_model->gram_panchayat_code])->one();
            $user_gp_model = \common\models\RelationUserGramPanchayat::find()->where(['gram_panchayat_code' => $bc_model->gram_panchayat_code, 'user_id' => $user_model->id])->one();
            if ($user_gp_model == NULL) {
                $user_gp_model = new \common\models\RelationUserGramPanchayat();
            }
            $user_gp_model->user_id = $bc_model->user_id;
            $user_gp_model->primary_user_id = $bc_model->user_id;
            $user_gp_model->district_code = (string) $bc_model->district_code;
            $user_gp_model->block_code = (string) $bc_model->block_code;
            $user_gp_model->gram_panchayat_code = (string) $bc_model->gram_panchayat_code;
            $user_gp_model->master_gram_panchayat_id = $model_gp->id;
            $user_gp_model->status = 1;
            if ($user_gp_model->save()) {
                $shg_models = Shg::find()->where(['gram_panchayat_code' => $bc_model->gram_panchayat_code, 'dummy_column' => $user_model->dummy_column])->andWhere(['!=', 'status', -1])->all();
                if ($shg_models != null) {
                    foreach ($shg_models as $shg) {
                        $bc_gp_shg = CboMembers::find()->where(['user_id' => $user_model->id, 'cbo_type' => 1, 'cbo_id' => $shg->id])->one();
                        if ($bc_gp_shg == null) {
                            $bc_gp_shg = new CboMembers();
                        }
                        $bc_gp_shg->user_id = $user_model->id;
                        $bc_gp_shg->cbo_type = CboMembers::CBO_TYPE_SHG;
                        $bc_gp_shg->cbo_id = $shg->id;
                        $bc_gp_shg->entry_type = 1;
                        $bc_gp_shg->bc_sakhi = 1;
                        $bc_gp_shg->status = 1;
                        if ($bc_gp_shg->save()) {
                            
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
//            echo "<pre>";
//            print_r($ex->getFile());exit;
        }
    }

    public function assignwada($wada_model, $user_model) {
        try {
            $model_gp = \common\models\master\MasterGramPanchayat::find()->where(['gram_panchayat_code' => $wada_model->gram_panchayat_code])->one();
            $user_gp_model = \common\models\RelationUserGramPanchayat::find()->where(['gram_panchayat_code' => $wada_model->gram_panchayat_code, 'user_id' => $user_model->id])->one();
            if ($user_gp_model == NULL) {
                $user_gp_model = new \common\models\RelationUserGramPanchayat();
            }
            $user_gp_model->user_id = $user_model->id;
            $user_gp_model->primary_user_id = $user_model->id;
            $user_gp_model->district_code = (string) $wada_model->district_code;
            $user_gp_model->block_code = (string) $wada_model->block_code;
            $user_gp_model->gram_panchayat_code = (string) $wada_model->gram_panchayat_code;
            $user_gp_model->master_gram_panchayat_id = $model_gp->id;
            $user_gp_model->status = 1;
            if ($user_gp_model->save()) {
                $shg_models = Shg::find()->where(['gram_panchayat_code' => $wada_model->gram_panchayat_code, 'dummy_column' => $user_model->dummy_column])->andWhere(['!=', 'status', -1])->all();
                if ($shg_models != null) {
                    foreach ($shg_models as $shg) {
                        $wada_gp_shg = CboMembers::find()->where(['user_id' => $user_model->id, 'cbo_type' => 1, 'cbo_id' => $shg->id])->one();
                        if ($wada_gp_shg == null) {
                            $wada_gp_shg = new CboMembers();
                        }
                        $wada_gp_shg->user_id = $user_model->id;
                        $wada_gp_shg->cbo_type = CboMembers::CBO_TYPE_SHG;
                        $wada_gp_shg->cbo_id = $shg->id;
                        $wada_gp_shg->entry_type = 1;
                        $wada_gp_shg->wada_sakhi = 1;
                        $wada_gp_shg->status = 1;
                        if ($wada_gp_shg->save()) {
                            
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
//            echo "<pre>";
//            print_r($ex->getFile());exit;
        }
    }

    public function assignshgtobcandwada($shg) {
        $bc_model = SrlmBcApplication::find()->where(['training_status' => 3, 'blocked' => 0, 'gram_panchayat_code' => $shg->gram_panchayat_code])->andWhere(['NOT', ['user_id' => null]])->one();
        $wada_applications = WadaApplication::find()->joinWith(['user'])->where(['wada_application.gram_panchayat_code' => $shg->gram_panchayat_code, 'wada_application.wada_status' => 1])->all();
    }

}

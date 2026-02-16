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

class Gp extends \yii\base\Component {

    public function urban($gram_panchayat_code) {
        try {
            $model_gp = \common\models\master\MasterGramPanchayat::find()->where(['gram_panchayat_code' => $gram_panchayat_code, 'gp_covert_urban' => 0])->one();
            if ($model_gp != NULL) {
                $condition = ['and',
                    ['=', 'gram_panchayat_code', $model_gp->gram_panchayat_code],
                ];
                \bc\models\master\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 2,
                    'status' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\master\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 2,
                    'status' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\dynamicdb\cbo_detail\master\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 2,
                    'status' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \bc\modules\transaction\models\summary\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 2,
                    'status' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\online\master\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 2,
                    'status' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \bc\modules\selection\models\SrlmBcApplication::updateAll([
                    'urban_shg' => 1,
                    'blocked' => SrlmBcApplication::BLOCKED_STATUS_URBAN_TWO,
                    'blocked_by' => 1,
                    'blocked_date' => new \yii\db\Expression('NOW()')
                        ], $condition);
                \common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey::updateAll([
                    'urban_gp' => 1,
                        ], $condition);
                \cbo\models\Shg::updateAll([
                    'urban_shg' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\dynamicdb\cbo_detail\RishtaShg::updateAll([
                    'urban_shg' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \cbo\models\CboVo::updateAll([
                    'urban_vo' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\dynamicdb\cbo_detail\RishtaVo::updateAll([
                    'urban_vo' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \bc\models\master\MasterVillage::updateAll([
                    'urban' => 1,
                    'status' => 0,
                        ], $condition);
                \common\models\master\MasterVillage::updateAll([
                    'urban' => 1,
                    'status' => 0,
                        ], $condition);
                \common\models\dynamicdb\cbo_detail\master\MasterVillage::updateAll([
                    'urban' => 1,
                    'status' => 0,
                        ], $condition);
                \bc\modules\transaction\models\summary\MasterVillage::updateAll([
                    'urban' => 1,
                    'status' => 0,
                        ], $condition);
                \common\models\online\master\MasterVillage::updateAll([
                    'urban' => 1,
                    'status' => 0,
                        ], $condition);
                \common\models\master\GramPanchayatDetailUltraPoor::updateAll([
                    'gp_covert_urban' => 2,
                    'status' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\master\GramPanchayatDetailUltraPoorHistory::updateAll([
                    'gp_covert_urban' => 2,
                    'status' => 0,
                    'updated_at' => time(),
                        ], $condition);
            }
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            print_r($ex->getFile());
            exit;
        }
        return true;
    }

    public function reverrural($gram_panchayat_code) {
        try {
            $model_gp = \common\models\master\MasterGramPanchayat::find()->where(['gram_panchayat_code' => $gram_panchayat_code, 'gp_covert_urban' => 2])->one();
            if ($model_gp != NULL) {
                $condition = ['and',
                    ['=', 'gram_panchayat_code', $model_gp->gram_panchayat_code],
                ];
                \bc\models\master\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 0,
                    'status' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\master\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 0,
                    'status' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\dynamicdb\cbo_detail\master\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 0,
                    'status' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \bc\modules\transaction\models\summary\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 0,
                    'status' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\online\master\MasterGramPanchayat::updateAll([
                    'gp_covert_urban' => 0,
                    'status' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \bc\modules\selection\models\SrlmBcApplication::updateAll([
                    'urban_shg' => 0,
                    'blocked' => 0,
                    'blocked_by' => null,
                    'blocked_date' => null
                        ], $condition);
                \cbo\models\Shg::updateAll([
                    'urban_shg' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\dynamicdb\cbo_detail\RishtaShg::updateAll([
                    'urban_shg' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \cbo\models\CboVo::updateAll([
                    'urban_vo' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\dynamicdb\cbo_detail\RishtaVo::updateAll([
                    'urban_vo' => 0,
                    'updated_at' => time(),
                        ], $condition);
                \bc\models\master\MasterVillage::updateAll([
                    'urban' => 0,
                    'status' => 1,
                        ], $condition);
                \common\models\master\MasterVillage::updateAll([
                    'urban' => 0,
                    'status' => 1,
                        ], $condition);
                \common\models\dynamicdb\cbo_detail\master\MasterVillage::updateAll([
                    'urban' => 0,
                    'status' => 1,
                        ], $condition);
                \bc\modules\transaction\models\summary\MasterVillage::updateAll([
                    'urban' => 0,
                    'status' => 1,
                        ], $condition);
                \common\models\online\master\MasterVillage::updateAll([
                    'urban' => 0,
                    'status' => 1,
                        ], $condition);
                \common\models\master\GramPanchayatDetailUltraPoor::updateAll([
                    'gp_covert_urban' => 0,
                    'status' => 1,
                    'updated_at' => time(),
                        ], $condition);
                \common\models\master\GramPanchayatDetailUltraPoorHistory::updateAll([
                    'gp_covert_urban' => 0,
                    'status' => 1,
                    'updated_at' => time(),
                        ], $condition);
            }
        } catch (\Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            print_r($ex->getFile());
            exit;
        }
        return true;
    }
}

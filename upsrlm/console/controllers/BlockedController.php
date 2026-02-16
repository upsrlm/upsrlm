<?php

namespace console\controllers;

use Yii;
use yii\helpers\Json;
use yii\console\Controller;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcApplication;
use console\helpers\Utility;

class BlockedController extends Controller {

    public function actionUnblocked() {
        $certified_aadhar_dublicate_models = SrlmBcApplication::find()->where(['blocked' => 9, 'training_status' => 3, 'urban_shg' => 0])->orderBy('aadhar_number asc')->all();
//        echo count($certified_aadhar_dublicate_models);
        $no = 0;
        foreach ($certified_aadhar_dublicate_models as $aadhar_dup_model) {
            $other_model = SrlmBcApplication::find()->where(['aadhar_number' => $aadhar_dup_model->aadhar_number, 'form_number' => 6, 'gender' => 2])->andWhere(['!=', 'id', $aadhar_dup_model->id])->orderBy('aadhar_number asc')->all();
            $other_selected_certified_count = SrlmBcApplication::find()->where(['aadhar_number' => $aadhar_dup_model->aadhar_number, 'training_status' => 3, 'form_number' => 6, 'gender' => 2])->andWhere(['!=', 'id', $aadhar_dup_model->id])->orderBy('aadhar_number asc')->count();

            if ($other_selected_certified_count == 0) {
                $no++;
                $aadhar_dup_model->blocked = 0;
                $aadhar_dup_model->save();
                foreach ($other_model as $otm) {
                    if ($otm->status == '2') {
                        if ($otm->blocked != '2') {
                            $otm->blocked = 9;
                            $otm->save();
                        }
                    }
                    if ($otm->status == '1') {
                        if ($otm->blocked != '2') {
                            $otm->blocked = 9;
                            $otm->status = -1;
                            $otm->save();
                        }
                    }
                }
            }
        }
        echo $no;
    }

    public function actionGpreset() {
        $gp_models = \bc\models\master\MasterGramPanchayat::find()->where(['status' => 1])->all();
        foreach ($gp_models as $gp) {
            
        }
    }

    public function actionBlockeddelete() {
        $sql = "SELECT i.*
			FROM srlm_bc_application i
INNER JOIN (
 SELECT aadhar_number
	FROM srlm_bc_application 
	where status !=-1 and form_number = 6 and gender=2 and status=1
	GROUP BY aadhar_number
	HAVING COUNT( id ) > 1
) j ON i.aadhar_number=j.aadhar_number where i.form_number = 6 and i.gender=2 and i.status !=-1 and i.status=1  
ORDER BY `i`.`aadhar_number`  ASC,`i`.`over_all`  DESC
";
        $models = \bc\modules\selection\models\SrlmBcApplication::findBySql($sql)->all();
        $del_count = 0;
        $remain_count = 0;
        $t_count = 0;
        foreach ($models as $model) {
            $all_app_model = SrlmBcApplication::find()->where(['aadhar_number' => $model->aadhar_number, 'form_number' => 6, 'gender' => 2])->orderBy('over_all desc')->all();
            $no = 0;
            $t_count++;
            foreach ($all_app_model as $key => $model) {

                if ($key == '0') {
                    $remain_count++;
                    //echo $model->gram_panchayat_code . ' GP Code ' . $model->id . ' id ' . $key . ' key' . PHP_EOL;
                } elseif ($key > 0) {
                    if ($model->blocked == '0' and $model->status =='1') {
                        $model->blocked = 9;
                        $model->status = -1;
                        //echo $model->gram_panchayat_code . ' GP Code ' . $model->id . ' id ' . $key . ' key' . PHP_EOL;
                        $model->save();
                        $del_count++;
                    } 
                }
            }
        }
        echo 'Total ' . $t_count . PHP_EOL;
        echo 'Remain ' . $remain_count . PHP_EOL;
        echo 'Delete ' . $del_count . PHP_EOL;
    }

//
//    public function actionUnblockeddelete() {
//        $sql = "SELECT i.*
//			FROM srlm_bc_application i
//INNER JOIN (
// SELECT aadhar_number
//	FROM srlm_bc_application 
//	where status !=-1 and form_number = 6 and gender=2
//	GROUP BY aadhar_number
//	HAVING COUNT( id ) > 1
//) j ON i.aadhar_number=j.aadhar_number where i.form_number = 6 and i.gender=2 and i.status !=-1 
//ORDER BY `i`.`aadhar_number`  ASC,`i`.`over_all`  DESC
//";
//        $models = \bc\modules\selection\models\SrlmBcApplication::findBySql($sql)->all();
//        foreach ($models as $model) {
//            if ($model->training_status == 3) {
//                $other_model = SrlmBcApplication::find()->where(['aadhar_number' => $model->aadhar_number, 'form_number' => 6, 'gender' => 2])->andWhere(['!=', 'id', $model->id])->all();
//            }
//        }
//    }
}

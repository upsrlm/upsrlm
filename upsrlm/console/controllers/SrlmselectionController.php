<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\base\ActionEvent;
use yii\base\Application;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcSelectionApiLog;
use bc\modules\selection\models\SrlmBcSelectionAppDetail;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationGroupFamily;
use bc\modules\selection\models\SrlmBcSelectionApiLog20200621;
use bc\modules\selection\models\BcApplicationCrone;
use console\helpers\Utility;

/**
 * This command process SRLM DATA and calculate rating section and question and over all
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 * @since 2.0
 */
class SrlmselectionController extends Controller {

    public $process_limt = 10000;
    public $sec1 = 0;
    public $sec2 = 0;
    public $sec3 = 0;
    public $sec4 = 0;
    public $sec5 = 0;
    public $over_all = 0;
    public $over_all_per = 0;
    public $reading_skils = [1 => 1, 2 => 3, 3 => 2, 4 => 1];
    public $phone_type = [1 => 5, 2 => 1];
    public $what_else_with_mobile = 0;
    public $vechicle_drive = 0;
    public $immediate_aspiration = 0;

    //UPDATE `srlm_bc_application` SET `status`=1 WHERE 1

    static function cmp_overall($a, $b) {
        $al = $a->over_all;
        $bl = $b->over_all;
        // echo "\n" . $al . " " . $bl . "\n";
        if ($al == $bl) {
            return 0;
        }
        return ($al < $bl) ? +1 : -1;
    }

//    public function actionGp() {
////        ini_set('max_execution_time', 1200);
////        ini_set('memory_limit', '2048M');
//        $models_gp = \bc\models\master\MasterGramPanchayat::find()->all();
//        $count_done = 0;
//        $count_pending = 0;
//          SrlmBcApplication::updateAll(['status' => '1']);
//$cou=1;
//        foreach ($models_gp as $model_gp) {
//$cou++;
// $selected_model = null;
//            if ($model_gp->bc_selection_application_receive == "1") {//|| $model_gp->bc_selection_application_receive == "2" || $model_gp->bc_selection_application_receive == "3") {
//                $count_done++;
//                $models = SrlmBcApplication::findAll(['gender' => 2, 'form_status' => '6', 'gram_panchayat_code' => $model_gp->gram_panchayat_code]);
//              // echo $model_gp->gram_panchayat_code . " " . count($models) . "\n";
//                foreach ($models as $model) {
//                    $model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                    if($model->update()){
//                        echo "bbbb ".$cou." ".$model->id;
//                    }else{
//                        echo "aaa";echo "save ".$cou." ".$model->id;
//                        print_r($model->getErrors()) ;
//                    }
//                }
//                $model_gp->selected_bc = $model->id;
//                $model_gp->save(false);
//            } else {
//                $count_pending++;
//                $chairperson = [];
//                $samuhsakhi = [];
//                $shgmember = [];
//                $nomemeber = [];
//
//                $models = SrlmBcApplication::findAll(['gender' => 2, 'form_status' => '6', 'gram_panchayat_code' => $model_gp->gram_panchayat_code]);
//
//
//               
//                foreach ($models as $model) {
//
//
//                    if ($model->already_group_member == "2")
//                        array_push($chairperson, $model);
//                    else if ($model->already_group_member == "7")
//                        array_push($samuhsakhi, $model);
//                    else if ($model->already_group_member == "1")
//                        array_push($nomemeber, $model);
//                    else
//                        array_push($shgmember, $model);
//
//
//
//
////                    if ($model->highest_score_in_gp == "1" && $model->already_group_member == "2") {
////                        $count_done++;
////                        $selected_model = $model;
////                    } else if ($model->already_group_member == "2") {
////                        if ($selected_model == null) {
////                            $selected_model = $model;
////                        } else if ($selected_model->already_group_member != "2" || $model->over_all > $selected_model->over_all)
////                            $selected_model = $model;
////                    } else if ($model->highest_score_in_gp == "1" && $model->already_group_member == "7") {
////                        if ($selected_model == null)
////                            $selected_model = $model;
////                        else if ($selected_model->already_group_member != "2")
////                            $selected_model = $model;
////                    } else if ($model->already_group_member == "7") {
////                        if ($selected_model == null) {
////                            $selected_model = $model;
////                        } else if ($selected_model->already_group_member == "2") {
////                            
////                        } else if ($selected_model->already_group_member != "7" || $model->over_all > $selected_model->over_all)
////                            $selected_model = $model;
////                    } else if ($model->highest_score_in_gp == "1" && (($model->already_group_member != "7" || $model->already_group_member != "2") && $model->already_group_member != "1")) {
////
////                        if ($selected_model == null) {
////                            $selected_model = $model;
////                        } else if ($selected_model->already_group_member == "2" || $selected_model->already_group_member == "7") {
////                            
////                        } else if ($model->already_group_member == "1" || $model->over_all > $selected_model->over_all)
////                            $selected_model = $model;
////                    } else if (($model->already_group_member != "7" || $model->already_group_member != "2") && $model->already_group_member != "1") {
////                        if ($selected_model == null) {
////                            $selected_model = $model;
////                        } else if ($selected_model->already_group_member == "2" || $selected_model->already_group_member == "7") {
////                            
////                        } else if ($selected_model->already_group_member != "2" || $selected_model->already_group_member != "7")
////                            $selected_model = $model;
////                    } else if ($model->highest_score_in_gp == "1") {
////                        if ($selected_model == null)
////                            $selected_model = $model;
////                    }
//                }
//
//                usort($chairperson, array($this, "cmp_overall"));
//                usort($samuhsakhi, array($this, "cmp_overall"));
//                usort($shgmember, array($this, "cmp_overall"));
//                usort($nomemeber, array($this, "cmp_overall"));
////                usort($chairperson, "$this->cmp_overall");
////                usort($samuhsakhi, "cmp_overall");
////                usort($shgmember, "cmp_overall");
////                usort($nomemeber, "cmp_overall");
//
//                if (count($chairperson) > 0) {
//                    $selected_model = $chairperson[0];
//                } else if (count($samuhsakhi) > 0) {
//                    $selected_model = $samuhsakhi[0];
//                } else if (count($shgmember) > 0) {
//                    $selected_model = $shgmember[0];
//                } else if (count($nomemeber) > 0) {
//                    $selected_model = $nomemeber[0];
//                }
//
//                // echo $count_pending . " " . $model_gp->gram_panchayat_code . " " . count($models) . " " . count($chairperson) . " " . count($samuhsakhi) . " " . count($shgmember) . " " . count($nomemeber) . "\n";
//            }
//            if ($selected_model != null) {
//                $selected_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                if($selected_model->update()){
//                     echo "save ".$cou." ".$selected_model->id;
//                } else {
//                    echo "asddsa".$cou." ".$selected_model->id;
//                  print_r($selected_model->errors) ;  
//                    // print_r($selected_model) ;  
//                }
//
//                $model_gp->selected_bc = $selected_model->id;
//                $model_gp->save(false);
//            }
//
////            if ($model_gp->gram_panchayat_code == "44184")
////                exit;
////                $models = SrlmBcApplication::findAll(['gender' => 2, 'form_status' => '6', 'gram_panchayat_code' => $model_gp->gram_panchayat_code]);
////                $count_pending++;
////                echo $model_gp->gram_panchayat_code . " " . count($models) . "\n";
////                foreach ($models as $model) {
////                    
////                }
//        }
//        echo $count_done . "\n";
//        //echo $count_pending . "\n";
//
//        return ExitCode::OK;
//    }

}

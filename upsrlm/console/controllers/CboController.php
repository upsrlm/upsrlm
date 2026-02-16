<?php

namespace console\controllers;

use Yii;
use yii\console\ExitCode;
use yii\console\Controller;
use yii\base\Model;
use console\helpers\Utility;
use cbo\models\CboVoShg;
use cbo\models\CboVo;
use cbo\models\CboClfMembers;
use cbo\models\Shg;
use common\models\CboMemberProfile;
use bc\modules\selection\models\SrlmBcApplication;
use common\models\dynamicdb\cbo_detail\master\CboMasterMemberDesignation;

class CboController extends Controller {

    public function actionMarkshggpuraban() {
        $gpmodels = \common\models\master\MasterGramPanchayat::find()->where(['gp_covert_urban' => 1])->all();

        foreach ($gpmodels as $model) {
            $condition = ['and',
                ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
            ];
            Shg::updateAll([
                'urban_shg' => 1,
                    ], $condition);
        }
    }

    public function actionMarkvogpuraban() {
        $gpmodels = \common\models\master\MasterGramPanchayat::find()->where(['gp_covert_urban' => 1])->all();

        foreach ($gpmodels as $model) {
            $condition = ['and',
                ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
            ];
            CboVo::updateAll([
                'urban_vo' => 1,
                    ], $condition);
        }
    }

//    public function actionPopulatevo() {
//        $models = CboVoShg::find()->orderBy('id asc')->all();
//        if (!empty($models)) {
//            foreach ($models as $model) {
//                $condition = ['and',
//                    ['=', 'id', $model->cbo_shg_id],
//                ];
//                Shg::updateAll([
//                    'cbo_vo_id' => $model->cbo_vo_id,
//                        ], $condition);
//            }
//        }
//    }

    public function actionClfmemberdistrict() {
        $models = CboClfMembers::find()->andWhere(['NOT', ['user_id' => null]])->limit(1000)->all();

        if (!empty($models)) {
            foreach ($models as $clfmembermodel) {
                $cbo_member_profile_model = CboMemberProfile::findOne(['user_id' => $clfmembermodel->user_id]);
                if (!empty($cbo_member_profile_model)) {
                    $condition = ['and',
                        ['=', 'user_id', $clfmembermodel->user_id],
                    ];
                    if ($cbo_member_profile_model->bc == 1) {
                        CboMemberProfile::updateAll([
                            'clf' => 1,
                                ], $condition);
                    } else {
                        CboMemberProfile::updateAll([
                            'division_code' => $clfmembermodel->clf->division_code,
                            'division_name' => $clfmembermodel->clf->division_name,
                            'district_code' => $clfmembermodel->clf->district_code,
                            'district_name' => $clfmembermodel->clf->district_name,
                            'block_code' => $clfmembermodel->clf->block_code,
                            'block_name' => $clfmembermodel->clf->block_name,
                            'clf' => 1,
                                ], $condition);
                    }
                } else {

                    $cbo_member_profile_model = new CboMemberProfile();

                    $cbo_member_profile_model->user_id = $clfmembermodel->user_id;
                    $cbo_member_profile_model->first_name = $clfmembermodel->name;
                    $cbo_member_profile_model->primary_phone_no = $clfmembermodel->mobile_no;
                    $cbo_member_profile_model->division_code = $clfmembermodel->clf->division_code;
                    $cbo_member_profile_model->division_name = $clfmembermodel->clf->division_name;
                    $cbo_member_profile_model->district_code = $clfmembermodel->clf->district_code;
                    $cbo_member_profile_model->district_name = $clfmembermodel->clf->district_name;
                    $cbo_member_profile_model->block_code = $clfmembermodel->clf->block_code;
                    $cbo_member_profile_model->block_name = $clfmembermodel->clf->block_name;
                    $cbo_member_profile_model->clf = 1;
                    $cbo_member_profile_model->save();
                }
            }
        }
    }

    public function actionBcshgbankupdate() {
        $models = Shg::find()->andWhere(['NOT', ['bank_id' => null]])->andWhere(['temp' => 0])->limit(500)->all();
        echo count($models);
        if (!empty($models)) {
            foreach ($models as $model) {
                $condition = ['and',
                    ['=', 'cbo_shg_id', $model->id],
                ];
                SrlmBcApplication::updateAll([
                    'bank_account_no_of_the_shg' => $model->bank_account_no_of_the_shg,
                    'bank_id_shg' => $model->bank_id,
                    'name_of_bank_shg' => $model->name_of_bank,
                    'branch_shg' => $model->branch,
                    'branch_code_or_ifsc_shg' => $model->branch_code_or_ifsc,
                    'passbook_photo_shg' => $model->passbook_photo,
                        ], $condition);

                $bc_model = SrlmBcApplication::findOne(['cbo_shg_id' => $model->id]);
                if (isset($bc_model)) {
                    if ($model->passbook_photo != null) {
                        $bc_shg_file = Yii::$app->params['datapath'] . 'cbo/shg/' . $model->id . '/' . $model->passbook_photo;
                        if (file_exists($bc_shg_file)) {
                            $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
                            $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";
                            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id)) {
                                mkdir($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id);
                                chmod($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id, 0777);
                            }
                            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id . '/shg')) {
                                mkdir($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id . '/shg');
                                chmod($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id . '/shg', 0777);
                            }
                            $bc_shg_passbook_file = $APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id . '/shg/' . $model->passbook_photo;
                            copy($bc_shg_file, $bc_shg_passbook_file);
                            $condition1 = ['and',
                                ['=', 'id', $model->id],
                            ];
                            Shg::updateAll([
                                'temp' => 1,
                                    ], $condition1);
                        }
                    }
                } else {
                    
                }
            }
        }
    }

    public function ActionCopybcshgfile() {
        $models = Shg::find()->andWhere(['NOT', ['bank_id' => null]])->all();
        if (!empty($models)) {
            foreach ($models as $model) {
                if ($model->passbook_photo != null) {
                    $bc_model = SrlmBcApplication::findOne(['cbo_shg_id' => $model->id]);
                    if (isset($bc_model)) {
                        $bc_shg_file = Yii::$app->params['datapath'] . 'cbo/shg/' . $model->id . '/' . $model->passbook_photo;
                        if (file_exists($bc_shg_file)) {
                            $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
                            $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";
                            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id)) {
                                mkdir($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id);
                                chmod($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id, 0777);
                            }
                            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id . '/shg')) {
                                mkdir($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id . '/shg');
                                chmod($APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id . '/shg', 0777);
                            }
                            $bc_shg_passbook_file = $APPLICATION_FORM_FILE_FOLDER . $bc_model->srlm_bc_selection_user_id . '/shg/' . $model->passbook_photo;
                            copy($bc_shg_file, $bc_shg_passbook_file);
                        }
                    }
                }
            }
        }
    }

    public function actionBlock() {
        $models = \bc\models\master\MasterBlock::find()->all();
        foreach ($models as $model) {
            $condition1 = ['and',
                ['=', 'block_code', $model->block_code],
            ];
            $shg_count = Shg::find()->where(['block_code' => $model->block_code, 'dummy_column' => 0])->andWhere(['!=', 'status', -1])->count();

            \bc\models\master\MasterBlock::updateAll([
                'shg_count' => $shg_count,
                    ], $condition1);
            \common\models\master\MasterBlock::updateAll([
                'shg_count' => $shg_count,
                    ], $condition1);
        }

        return ExitCode::OK;
    }

    public function actionGp() {
        $models = \bc\models\master\MasterGramPanchayat::find()->where(['status' => 1])->all();
        foreach ($models as $model) {
            $condition1 = ['and',
                ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
            ];
            $shg_count = Shg::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'dummy_column' => 0])->andWhere(['!=', 'status', -1])->count();

            \bc\models\master\MasterGramPanchayat::updateAll([
                'shg_count' => $shg_count,
                    ], $condition1);
            \common\models\master\MasterGramPanchayat::updateAll([
                'shg_count' => $shg_count,
                    ], $condition1);
            \common\models\master\MasterGramPanchayatDetailWada::updateAll([
                'shg_count' => $shg_count,
                    ], $condition1);
        }

        return ExitCode::OK;
    }

    public function actionCopyshgcstmember() {
        $total_shg = \cbo\models\Shg::find()->where(['cbo_shg.status' => 1])->orderBy('cbo_shg.id asc')->count();
        $limit = 1000;
        $batch = ceil($total_shg / $limit);
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $shg_models = \cbo\models\Shg::find()->joinWith(['gp'])->where(['cbo_shg.status' => 1])->limit($limit)->offset($limitStart)->orderBy('cbo_shg.id asc')->all();
            foreach ($shg_models as $shg) {
                // start chairepersion 
                $check_ch_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shg->id, 'role' => CboMasterMemberDesignation::SHG_CHAIRPERSON, 'status' => 1])->orderBy('id asc')->one();
                $ch_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shg->id, 'role' => CboMasterMemberDesignation::SHG_CHAIRPERSON, 'mobile' => $shg->chaire_person_mobile_no])->one();
                if ($check_ch_model != null) {
                    if ($check_ch_model->user_id != null) {
                        $check_ch_model->verified = 1;
                        $check_ch_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BMMU;
                        $check_ch_model->save();
                    } else {
                        $check_ch_model->verified = 0;
                        $check_ch_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BMMU;
                        $check_ch_model->name = $shg->chaire_person_name;
                        $check_ch_model->mobile = $shg->chaire_person_mobile_no;
                        if ($shg->ch_user_id) {
                            $check_ch_model->user_id = $shg->ch_user_id;
                            $check_ch_model->verified = 1;
                        }
                        $check_ch_model->save();
                    }
                } else {
                    if ($ch_model == null) {
                        $ch_model = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                    }
                    $ch_model->cbo_shg_id = $shg->id;
                    $ch_model->name = $shg->chaire_person_name;
                    $ch_model->mobile = $shg->chaire_person_mobile_no;
                    $ch_model->role = CboMasterMemberDesignation::SHG_CHAIRPERSON;
                    if ($shg->ch_user_id) {
                        $ch_model->user_id = $shg->ch_user_id;
                        $ch_model->verified = 1;
                    }
                    $ch_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BMMU;
                    if ($ch_model->save()) {
                        $ch_model->parent_id = $ch_model->id;
                        $ch_model->save();
                    }
                }
                // end  chairepersion 
                // start secretary
                $check_se_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shg->id, 'role' => CboMasterMemberDesignation::SHG_SECRETARY, 'status' => 1])->orderBy('id asc')->one();
                $se_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shg->id, 'role' => CboMasterMemberDesignation::SHG_SECRETARY, 'mobile' => $shg->secretary_mobile_no])->one();
                if ($check_se_model != null) {
                    if ($check_se_model->user_id != null) {
                        $check_se_model->verified = 1;
                        $check_se_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BMMU;
                        $check_se_model->save();
                    } else {
                        $check_se_model->verified = 0;
                        $check_se_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BMMU;
                        $check_se_model->name = $shg->secretary_name;
                        $check_se_model->mobile = $shg->secretary_mobile_no;
                        if ($shg->se_user_id) {
                            $check_se_model->user_id = $shg->se_user_id;
                            $check_se_model->verified = 1;
                        }
                        $check_se_model->save();
                    }
                } else {
                    if ($se_model == null) {
                        $se_model = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                    }
                    $se_model->cbo_shg_id = $shg->id;
                    $se_model->name = $shg->secretary_name;
                    $se_model->mobile = $shg->secretary_mobile_no;
                    $se_model->role = CboMasterMemberDesignation::SHG_SECRETARY;
                    if ($shg->se_user_id) {
                        $se_model->user_id = $shg->se_user_id;
                        $se_model->verified = 1;
                    }
                    $se_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BMMU;
                    if ($se_model->save()) {
                        $se_model->parent_id = $se_model->id;
                        $se_model->save();
                    }
                }
                // end  secretary 
                // start TREASURER
                $check_te_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shg->id, 'role' => CboMasterMemberDesignation::SHG_TREASURER, 'status' => 1])->orderBy('id asc')->one();
                $te_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shg->id, 'role' => CboMasterMemberDesignation::SHG_TREASURER, 'mobile' => $shg->treasurer_mobile_no])->one();
                if ($check_te_model != null) {
                    if ($check_te_model->user_id != null) {
                        $check_te_model->verified = 1;
                        $check_te_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BMMU;
                        $check_te_model->save();
                    } else {
                        $check_te_model->verified = 0;
                        $check_te_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BMMU;
                        $check_te_model->name = $shg->treasurer_name;
                        $check_te_model->mobile = $shg->treasurer_mobile_no;
                        if ($shg->te_user_id) {
                            $check_te_model->user_id = $shg->te_user_id;
                            $check_te_model->verified = 1;
                        }
                        $check_te_model->save();
                    }
                } else {
                    if ($te_model == null) {
                        $te_model = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                    }
                    $te_model->cbo_shg_id = $shg->id;
                    $te_model->name = $shg->treasurer_name;
                    $te_model->mobile = $shg->treasurer_mobile_no;
                    $te_model->role = CboMasterMemberDesignation::SHG_TREASURER;
                    if ($shg->te_user_id) {
                        $te_model->user_id = $shg->te_user_id;
                        $te_model->verified = 1;
                    }
                    $te_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BMMU;
                    if ($te_model->save()) {
                        $te_model->parent_id = $te_model->id;
                        $te_model->save();
                    }
                }
                // end  TREASURER
            }
        }
    }

    public function actionCopybc() {
        $count_bc = SrlmBcApplication::find()->select(['id', 'user_id', 'cbo_shg_id'])->where(['training_status' => 3])->andWhere(['NOT', ['cbo_shg_id' => null]])->andWhere(['NOT', ['user_id' => null]])->count();
        $limit = 500;
        $batch = ceil($count_bc / $limit);
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $models = SrlmBcApplication::find()->select(['id', 'user_id', 'cbo_shg_id', 'mobile_no'])->where(['training_status' => 3])->andWhere(['NOT', ['cbo_shg_id' => null]])->limit($limit)->offset($limitStart)->orderBy('id asc')->all();
            if (!empty($models)) {
                foreach ($models as $model) {
                    $bc_model = SrlmBcApplication::findOne($model->id);
                    if ($bc_model->user_id and $bc_model->cbo_shg_id) {
                        $member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $model->mobile_no, 'cbo_shg_id' => $model->cbo_shg_id, 'status' => 1])->one();
                        if ($member_model != null) {
                            $member_model->verified = 1;
                            $member_model->user_id = $bc_model->user_id;
                            $member_model->bc = 1;
                            $member_model->mobile_verified = 1;
                            $member_model->save();
                        } else {
                            $member_model = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                            $member_model->name = $bc_model->name;
                            $member_model->mobile = $bc_model->mobile_no;
                            $member_model->role = 0;
                            $member_model->cbo_shg_id = $bc_model->cbo_shg_id;
                            $member_model->age = $bc_model->age;
                            $member_model->user_id = $bc_model->user_id;
                            $member_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BC;
                            $member_model->verified = 1;
                            $member_model->mobile_verified = 1;
                            $member_model->bc = 1;
                            if ($member_model->save()) {
                                $member_model->parent_id = $member_model->id;
                                $member_model->save();
                            }
                        }
                    }
                }
            }
        }
    }

    public function actionCheckbc() {
        $count_bc = SrlmBcApplication::find()->select(['id', 'user_id', 'cbo_shg_id'])->where(['training_status' => 3])->andWhere(['NOT', ['cbo_shg_id' => null]])->andWhere(['NOT', ['user_id' => null]])->count();
        $limit = 500;
        $batch = ceil($count_bc / $limit);
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $models = SrlmBcApplication::find()->select(['id', 'user_id', 'cbo_shg_id', 'mobile_no'])->where(['training_status' => 3])->andWhere(['NOT', ['cbo_shg_id' => null]])->limit($limit)->offset($limitStart)->orderBy('id asc')->all();
            if (!empty($models)) {
                foreach ($models as $model) {
                    $bc_model = SrlmBcApplication::findOne($model->id);
                    if ($bc_model->user_id and $bc_model->cbo_shg_id) {
                        $member_models = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $model->mobile_no, 'status' => 1])->all();
                        $bc_member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $bc_model->cbo_shg_id, 'mobile' => $model->mobile_no, 'status' => 1])->all();
                        if ($member_models != null) {
                            if ($bc_member_model != null) {
                                foreach ($member_models as $member) {
                                    if ($member->cbo_shg_id == $bc_model->cbo_shg_id) {
                                        $member->verified = 1;
                                        $member->user_id = $bc_model->user_id;
                                        $member->bc = 1;
                                        $member->mobile_verified = 1;
                                        $member->save();
                                    } else {
                                        $member->status = -1;
                                        $member->save();
                                        $cbo_member = \common\models\CboMembers::find()->joinWith(['user'])->where(['cbo_type' => 1, 'cbo_id' => $member->cbo_shg_id])->andWhere(['username' => $bc_model->mobile_no])->andWhere(['bc_sakhi' => 0])->one();
                                        if ($cbo_member != null) {
                                            $cbo_member->status = -1;
                                            $cbo_member->save();
                                        }
                                    }
                                }
                            } else {
                                foreach ($member_models as $member) {
                                    $member->status = -1;
                                    $member->save();
                                    $cbo_member = \common\models\CboMembers::find()->joinWith(['user'])->where(['cbo_type' => 1, 'cbo_id' => $member->cbo_shg_id])->andWhere(['username' => $bc_model->mobile_no])->andWhere(['bc_sakhi' => 0])->one();
                                    if ($cbo_member != null) {
                                        $cbo_member->status = -1;
                                        $cbo_member->save();
                                    }
                                }
                                $member_model = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                                $member_model->name = $bc_model->name;
                                $member_model->mobile = $bc_model->mobile_no;
                                $member_model->role = 0;
                                $member_model->cbo_shg_id = $bc_model->cbo_shg_id;
                                $member_model->age = $bc_model->age;
                                $member_model->user_id = $bc_model->user_id;
                                $member_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BC;
                                $member_model->verified = 1;
                                $member_model->mobile_verified = 1;
                                $member_model->bc = 1;
                                if ($member_model->save()) {
                                    $member_model->parent_id = $member_model->id;
                                    $member_model->save();
                                }
                            }
                        } else {
                            $member_model = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                            $member_model->name = $bc_model->name;
                            $member_model->mobile = $bc_model->mobile_no;
                            $member_model->role = 0;
                            $member_model->cbo_shg_id = $bc_model->cbo_shg_id;
                            $member_model->age = $bc_model->age;
                            $member_model->user_id = $bc_model->user_id;
                            $member_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BC;
                            $member_model->verified = 1;
                            $member_model->mobile_verified = 1;
                            $member_model->bc = 1;
                            if ($member_model->save()) {
                                $member_model->parent_id = $member_model->id;
                                $member_model->save();
                            }
                        }
                    }
                }
            }
        }
    }

    public function actionBcshg() {
        $count_bc = SrlmBcApplication::find()->select(['id', 'user_id', 'cbo_shg_id'])->where(['training_status' => 3])->andWhere(['NOT', ['cbo_shg_id' => null]])->andWhere(['NOT', ['user_id' => null]])->count();
        $limit = 500;
        $batch = ceil($count_bc / $limit);
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $models = SrlmBcApplication::find()->select(['id', 'user_id', 'cbo_shg_id', 'mobile_no'])->where(['training_status' => 3])->andWhere(['NOT', ['cbo_shg_id' => null]])->limit($limit)->offset($limitStart)->orderBy('id asc')->all();
            if (!empty($models)) {
                foreach ($models as $model) {
                    $bc_model = SrlmBcApplication::findOne($model->id);
                    if ($bc_model->user_id and $bc_model->cbo_shg_id and $bc_model->blocked == 0) {
                        $bc_members = \common\models\CboMembers::find()->where(['cbo_type' => 1, 'cbo_id' => $bc_model->cbo_shg_id, 'user_id' => $bc_model->user_id, 'bc_sakhi' => 1])->all();
                        if ($bc_members != null) {
                            if (count($bc_members) == 1) {
                                if ($bc_members[0]->status != 1) {
                                    $member = $bc_members[0];
                                    if ($member != null) {
                                        $member->status = 1;
                                        $member->save();
                                    }
                                    // echo 'In active : ' . $model->id . ' bc: ' . $bc_model->name . 'shg_id:' . $bc_model->cbo_shg_id . PHP_EOL;
                                }
                            } else {
                                echo 'dublicate : ' . $model->id . ' bc: ' . $bc_model->name . 'shg_id:' . $bc_model->cbo_shg_id . PHP_EOL;
                            }
                        } else {
                            echo 'id: ' . $model->id . ' bc: ' . $bc_model->name . 'shg_id:' . $bc_model->cbo_shg_id . PHP_EOL;
                        }
                    }
                }
            }
        }
    }

    public function actionCheckuser() {
        $null = new \yii\db\Expression('NULL');
        $rishta_members = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->andWhere(['NOT', ['user_id' => null]])->all();
        $success = 0;
        $wrong = 0;
        foreach ($rishta_members as $member) {
            if ($member->match) {
                $condition = ['and',
                    ['=', 'id', $member->id],
                ];
                \common\models\dynamicdb\cbo_detail\RishtaShgMember::updateAll([
                    'verified' => 1
                        ], $condition);
                $success++;
            } else {
                $condition1 = ['and',
                    ['=', 'id', $member->id],
                ];

                \common\models\dynamicdb\cbo_detail\RishtaShgMember::updateAll([
                    'user_id' => NULL,
                    'verified' => 0
                        ], $condition1);
                $wrong++;
            }
        }

        echo "Success : " . $success . PHP_EOL;
        echo "Wrong : " . $wrong . PHP_EOL;
    }

    public function actionTemp() {
        $sql = 'SELECT rishta_shg_member_verification_form_log.id,rishta_shg_member.mobile,rishta_shg_member.user_id,rishta_shg_member.cbo_shg_id,user.id,cbo_members.role FROM `rishta_shg_member_verification_form_log` 
JOIN user on user.username=rishta_shg_member_verification_form_log.mobile_no
JOIN rishta_shg_member on rishta_shg_member.mobile=rishta_shg_member_verification_form_log.mobile_no
JOIN cbo_members on cbo_members.user_id=user.id
where call_log_id!=0 and user.role=100 and cbo_members.role in (1,2,3) and upsrlm_connection_status=1 and upsrlm_call_status=10 and (verify_ques1=1 and verify_ques2=1 and verify_ques3=1)  and rishta_shg_member.user_id is null  
ORDER BY `cbo_members`.`role`  ASC';
        $res = \Yii::$app->dbcbodetail->createCommand($sql)->queryAll();
        foreach ($res as $member) {
            $condition1 = ['and',
                ['=', 'mobile', $member['mobile']],
                ['=', 'cbo_shg_id', $member['cbo_shg_id']],
                ['=', 'role', $member['role']],
            ];
            \common\models\dynamicdb\cbo_detail\RishtaShgMember::updateAll([
                'user_id' => $member['id'],
                'verified' => 1
                    ], $condition1);
        }
    }

    public function actionCsvshgcst() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        $total_shg = \cbo\models\Shg::find()->select(['id'])->where(['cbo_shg.status' => 1, 'cbo_shg.wada_shg' => 1, 'cbo_shg.dummy_column' => 0, 'verify_over_all' => 0])->orderBy('cbo_shg.id asc')->count();
        $limit = 1000;
        $batch = ceil($total_shg / $limit);
        $file = "wada_shg" . ".csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array(
            'UPSRLM SHG ID',
            'Name of SHG',
            'NRLM SHG Code',
            'District',
            'Block',
            'Gram panchayat',
            'Rev. Village',
            'Chair Person Name',
            'Chair Person Mobile No.',
            'Secretary Name',
            'Secretary Mobile No.',
            'Treasurer Name',
            'Treasurer Mobile No.',
            'BMMU Name',
            'BMMU Mobile No.'
                )
        );
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $shg_models = \cbo\models\Shg::find()->joinWith(['gp'])->where(['cbo_shg.status' => 1, 'cbo_shg.wada_shg' => 1, 'cbo_shg.dummy_column' => 0, 'verify_over_all' => 0])->limit($limit)->offset($limitStart)->orderBy('cbo_shg.id asc')->all();
            foreach ($shg_models as $model) {
                $chmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
                $semodel = $model->getRmembers()->andWhere(['role' => 2])->one();
                $temodel = $model->getRmembers()->andWhere(['role' => 3])->one();
                $row = [
                    $model->id,
                    $model->name_of_shg,
                    $model->shg_code != null ? $model->shg_code : '',
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    isset($chmodel) ? $chmodel->name : '',
                    isset($chmodel) ? $chmodel->mobile : '',
                    isset($semodel) ? $semodel->name : '',
                    isset($semodel) ? $semodel->mobile : '',
                    isset($temodel) ? $temodel->name : '',
                    isset($temodel) ? $temodel->mobile : '',
                    isset($model->entryby) ? $model->entryby->name : '',
                    isset($model->entryby) ? $model->entryby->username : '',
                ];
                fputcsv($output, $row);
            }
        }
    }

}

<?php

namespace sakhi\components;

use yii;

class ShgCheck extends \yii\base\Component {

    /**
     * Copy SHG Data Into CBO SHG Profile Table
     *
     * @return void
     */
    public static function copyShgData() {
        if (isset($_REQUEST['shgid'])) {
            $shgid = $_REQUEST['shgid'];
            $shgprofile = \common\models\dynamicdb\cbo_detail\RishtaShgProfile::find()->where(['cbo_shg_id' => $shgid])->one();
            if (!$shgprofile) {
                $shg_model = \cbo\models\Shg::findOne($shgid);
                if ($shg_model) {
                    $shg_model->name_of_shg_original = isset($shg_model->name_of_shg_original) ? $shg_model->name_of_shg_original : $shg_model->name_of_shg;
                    $shg_model->no_of_members_original = isset($shg_model->no_of_members_original) ? $shg_model->no_of_members_original : $shg_model->no_of_members;
                    $shg_model->save(false);

                    $shgprofile = new \common\models\dynamicdb\cbo_detail\RishtaShgProfile();
                    $shgprofile->cbo_shg_id = $shg_model->id;
                    $shgprofile->name_of_shg = $shg_model->name_of_shg;
                    $shgprofile->shg_code = $shg_model->shg_code;
                    $shgprofile->no_of_members = $shg_model->no_of_members;
                    $shgprofile->division_code = $shg_model->division_code;
                    $shgprofile->division_name = $shg_model->division_name;
                    $shgprofile->district_code = $shg_model->district_code;
                    $shgprofile->district_name = $shg_model->district_name;
                    $shgprofile->block_code = $shg_model->block_code;
                    $shgprofile->block_name = $shg_model->block_name;
                    $shgprofile->gram_panchayat_code = $shg_model->gram_panchayat_code;
                    $shgprofile->gram_panchayat_name = $shg_model->gram_panchayat_name;
                    $shgprofile->village_code = $shg_model->village_code;
                    $shgprofile->village_name = $shg_model->village_name;
                    $shgprofile->hamlet = $shg_model->hamlet;
                    $shgprofile->cbo_vo_id = $shg_model->cbo_vo_id;
                    $shgprofile->shg_code = $shg_model->shg_code;
                    if ($shgprofile->save(false)) {
                        /**
                         * Member One Chaire Person
                         */
//                        $member1 = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
//                        $member1->cbo_shg_id = $shg_model->id;
//                        $member1->name = $shg_model->chaire_person_name;
//                        if (isset(Yii::$app->user->identity)) {
//                            if (Yii::$app->user->identity->mobile_no == $shg_model->chaire_person_mobile_no) {
//                                $member1->user_id = Yii::$app->user->identity->id;
//                            }
//                        }
//                        $member1->mobile = $shg_model->chaire_person_mobile_no;
//                        $member1->role = \common\models\dynamicdb\cbo_detail\master\CboMasterMemberDesignation::SHG_CHAIRPERSON;
//                        $member1->save();
//
//                        /**
//                         * Member Two Secretary Name
//                         */
//                        $member2 = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
//                        $member2->cbo_shg_id = $shg_model->id;
//                        $member2->name = $shg_model->secretary_name;
//                        if (isset(Yii::$app->user->identity)) {
//                            if (Yii::$app->user->identity->mobile_no == $shg_model->secretary_mobile_no) {
//                                $member2->user_id = Yii::$app->user->identity->id;
//                            }
//                        }
//                        $member2->mobile = $shg_model->secretary_mobile_no;
//                        $member2->role = \common\models\dynamicdb\cbo_detail\master\CboMasterMemberDesignation::SHG_SECRETARY;
//                        $member2->save();
//
//                        /**
//                         * Member Three Treasurer Name
//                         */
//                        $member3 = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
//                        $member3->cbo_shg_id = $shg_model->id;
//                        $member3->name = $shg_model->treasurer_name;
//                        if (isset(Yii::$app->user->identity)) {
//                            if (Yii::$app->user->identity->mobile_no == $shg_model->treasurer_mobile_no) {
//                                $member3->user_id = Yii::$app->user->identity->id;
//                            }
//                        }
//                        $member3->mobile = $shg_model->treasurer_mobile_no;
//                        $member3->role = \common\models\dynamicdb\cbo_detail\master\CboMasterMemberDesignation::SHG_TREASURER;
//                        $member3->save();

                        return true;
                    }
                }
            }
        }
    }

}

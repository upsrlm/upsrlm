<?php

namespace backend\modules\cbo\controllers;

use Yii;
use yii\web\Controller;
use cbo\models\CboClfMembers;
use cbo\models\CboClfMembersSearch;
use cbo\models\CboClfSearch;
use cbo\models\CboClf;
use cbo\models\master\CboMasterMemberRole;
use common\models\User;
use common\models\CboMembers;
use common\models\master\MasterRole;
use common\models\CboMemberProfile;
use common\models\base\GenralModel;

/**
 * Default controller for the `cbo` module
 */
class ClfController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new CboClfSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChairperson($clfid) {
        $model = CboClf::findOne($clfid);
        if ($model == null) {
            return $this->redirect(['/cbo/clf']);
        }
        $searchModel = new CboClfMembersSearch();
        $searchModel->cbo_clf_id = $clfid;
        $searchModel->role = [CboMasterMemberRole::ROLE_CHAIRPERSON, CboMasterMemberRole::ROLE_SECRETARY, CboMasterMemberRole::ROLE_TREASURER];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        //$dataProvider->query->andWhere(['is', 'user_id', new \yii\db\Expression('null')]);

        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('chairperson', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
            ]);
        } else {
            return $this->render('chairperson', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
            ]);
        }
    }

    public function actionMakeuser($clfmemberid) {
        $clfmembermodel = CboClfMembers::findOne($clfmemberid);
        if ($clfmembermodel != null) {
            $user_model = User::find()->where(['username' => $clfmembermodel->mobile_no])->one();

            if ($user_model == null) {
                $user_model = new User();
                $user_model->name = $clfmembermodel->name;
                $user_model->mobile_no = $clfmembermodel->mobile_no;
                $user_model->username = $clfmembermodel->mobile_no;
                $user_model->role = MasterRole::ROLE_CBO_USER;
                $user_model->email = $clfmembermodel->mobile_no . '@gmail.com';
                $user_model->password = $clfmembermodel->mobile_no;
                $user_model->setPassword($clfmembermodel->mobile_no);
                $user_model->setUpd($clfmembermodel->mobile_no);
                $user_model->status = User::STATUS_ACTIVE;
                $user_model->profile_status = 1;
                $user_model->login_by_otp = 2;
                $user_model->dummy_column = $clfmembermodel->clf->dummy_column;
                if ($user_model->validate() and $user_model->save()) {
                    $clfmembermodel->user_id = $user_model->id;
                    $clfmembermodel->save();
                    $cbo_member = CboMembers::find()->where(['cbo_type' => CboMembers::CBO_TYPE_CLF, 'cbo_id' => $clfmembermodel->cbo_clf_id, 'user_id' => $user_model->id])->one();
                    if ($cbo_member == null) {
                        $cbo_member = new CboMembers();
                    }
                    $cbo_member->user_id = $user_model->id;
                    $cbo_member->cbo_type = CboMembers::CBO_TYPE_CLF;
                    $cbo_member->cbo_id = $clfmembermodel->cbo_clf_id;
                    $cbo_member->entry_type = CboMembers::CBO_TYPE_CLF;
                    if (in_array($clfmembermodel->role, [1, \cbo\models\CboMasterMemberDesignation::CLF_CHAIRPERSON])) {
                        $cbo_member->role = \cbo\models\CboMasterMemberDesignation::CLF_CHAIRPERSON;
                        $cbo_member->clf_chairperson = 1;
                    }
                    if (in_array($clfmembermodel->role, [2, \cbo\models\CboMasterMemberDesignation::CLF_SECRETARY])) {
                        $cbo_member->role = \cbo\models\CboMasterMemberDesignation::CLF_SECRETARY;
                        $cbo_member->clf_secretary = 1;
                    }
                    if (in_array($clfmembermodel->role, [3, \cbo\models\CboMasterMemberDesignation::CLF_TREASURER])) {
                        $cbo_member->role = \cbo\models\CboMasterMemberDesignation::CLF_TREASURER;
                        $cbo_member->clf_treasurer = 1;
                    }

                    if (in_array($clfmembermodel->role, [4, \cbo\models\CboMasterMemberDesignation::CLF_MEMBER])) {
                        $cbo_member->role = \cbo\models\CboMasterMemberDesignation::CLF_MEMBER;
                        $cbo_member->clf_member = 1;
                    }
                    $cbo_member->status = 1;
                    if ($cbo_member->save()) {
                        $cbo_member_profile_model = CboMemberProfile::findOne(['user_id' => $user_model->id]);
                        if ($cbo_member_profile_model == null) {
                            $cbo_member_profile_model = new CboMemberProfile();
                        }

                        $cbo_member_profile_model->user_id = $user_model->id;
                        $cbo_member_profile_model->first_name = $clfmembermodel->name;
                        $cbo_member_profile_model->primary_phone_no = $clfmembermodel->mobile_no;
                        $cbo_member_profile_model->division_code = $clfmembermodel->clf->division_code;
                        $cbo_member_profile_model->division_name = $clfmembermodel->clf->division_name;
                        $cbo_member_profile_model->district_code = $clfmembermodel->clf->district_code;
                        $cbo_member_profile_model->district_name = $clfmembermodel->clf->district_name;
                        $cbo_member_profile_model->block_code = $clfmembermodel->clf->block_code;
                        $cbo_member_profile_model->block_name = $clfmembermodel->clf->block_name;
                        $cbo_member_profile_model->clf = 1;
                        if ($cbo_member_profile_model->save()) {
                            
                        } else {
//                    print_r($model->cbo_member_profile_model->getErrors());
                        }
                    }
                }
            } else {
                $cbo_member_profile_model = CboMemberProfile::findOne(['user_id' => $user_model->id]);
                if ($user_model->role == MasterRole::ROLE_CBO_USER) {
                    $cbo_member = CboMembers::find()->where(['cbo_type' => CboMembers::CBO_TYPE_CLF, 'cbo_id' => $clfmembermodel->cbo_clf_id, 'user_id' => $user_model->id])->one();
                    if ($cbo_member == null) {
                        $cbo_member = new CboMembers();
                    }
                    $cbo_member->user_id = $user_model->id;
                    $cbo_member->cbo_type = CboMembers::CBO_TYPE_CLF;
                    $cbo_member->cbo_id = $clfmembermodel->cbo_clf_id;
                    $cbo_member->entry_type = CboMembers::CBO_TYPE_CLF;
                    if (in_array($clfmembermodel->role, [1, \cbo\models\CboMasterMemberDesignation::CLF_CHAIRPERSON])) {
                        $cbo_member->role = \cbo\models\CboMasterMemberDesignation::CLF_CHAIRPERSON;
                        $cbo_member->clf_chairperson = 1;
                    }
                    if (in_array($clfmembermodel->role, [2, \cbo\models\CboMasterMemberDesignation::CLF_SECRETARY])) {
                        $cbo_member->role = \cbo\models\CboMasterMemberDesignation::CLF_SECRETARY;
                        $cbo_member->clf_secretary = 1;
                    }
                    if (in_array($clfmembermodel->role, [3, \cbo\models\CboMasterMemberDesignation::CLF_TREASURER])) {
                        $cbo_member->role = \cbo\models\CboMasterMemberDesignation::CLF_TREASURER;
                        $cbo_member->clf_treasurer = 1;
                    }

                    if (in_array($clfmembermodel->role, [4, \cbo\models\CboMasterMemberDesignation::CLF_MEMBER])) {
                        $cbo_member->role = \cbo\models\CboMasterMemberDesignation::CLF_MEMBER;
                        $cbo_member->clf_member = 1;
                    }
                    $cbo_member->status = 1;
                    if ($cbo_member->save()) {
                        $clfmembermodel->user_id = $user_model->id;
                        $clfmembermodel->save();
                        if ($cbo_member_profile_model != null) {
                            $cbo_member_profile_model->clf = 1;
                            $cbo_member_profile_model->update();
                        }
                    }
                } else {
                    \Yii::$app->getSession()->setFlash('error', 'Already user created another role');
                }
            }
        }


        return $this->redirect(['/cbo/clf']);
    }

}

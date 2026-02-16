<?php

namespace cbo\modules\bc\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\SrlmBcApplication;
use cbo\models\Shg;
use cbo\models\ShgSearch;
use common\models\base\GenralModel;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;

/**
 * Default controller for the `bc` module
 */
class CertifiedController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'csvdownload', 'bankstatus'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'csvdownload', 'bankstatus'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->show_blocked = 0;
        if (empty(Yii::$app->request->queryParams)) {
            $searchModel->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
        }
        if (Yii::$app->request->isGet) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        }
        if (Yii::$app->request->isPost) {
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        }
        $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);

        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        
        $searchModel->training_status_option = ['3' => 'Certified', '31' => 'Already certified', '7' => 'Onboarding']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1, 'id' => [3, 7]])->all(), 'id', 'status_eng');
        $rseth_bank_query = \common\models\dynamicdb\bc\User::find()->select(['user.id','user.name'])->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'user.status' => 10]);
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
            $rseth_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
        }
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
            $rseth_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
        }
        $rseth_bank = $rseth_bank_query->orderBy('bank_name asc')->all();
        $partner_bank_query = \common\models\dynamicdb\bc\User::find()->select(['user.id','user.name'])->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'user.status' => 10]);
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
            $partner_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
        }
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            $partner_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
        }
        $partner_bank_bank = $partner_bank_query->orderBy('name asc')->all();
        $searchModel->rseti_bank_option = \yii\helpers\ArrayHelper::map($rseth_bank, 'profile.bank_name', 'profile.bank_name');
        $searchModel->bc_partner_bank_option = \yii\helpers\ArrayHelper::map($partner_bank_bank, 'id', 'name');
        $searchModel->gp_member_option = \yii\helpers\ArrayHelper::map(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->andWhere(['status' => 1])->all(), 'id', 'name_eng');
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBankstatus($bcid) {
        $bc_model = $this->findModelbc($bcid);
        $model = new \bc\modules\selection\models\form\VerificationBankDetailForm($bc_model);

        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('bank_detail_status', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('bank_detail_status', [
                        'model' => $model,
            ]);
        }
    }

    public function actionView($participantid) {

        $model = $this->findModel($participantid);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
            ]);
        }
    }

    public function actionShg($gram_panchayat_code) {
        $searchModel = new ShgSearch();
        $searchModel->gram_panchayat_code = $gram_panchayat_code;
        $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
        $searchModel->block_option = GenralModel::optionblock($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        }
        $searchModel->verify_option = [1 => 'Member detail correct', 0 => 'Member detail wrong'];
        $searchModel->return_option = [1 => 'Return'];
        if (isset($searchModel->return) and $searchModel->return != '') {
            $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.verification_status' => 1]);
            $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.verify_mobile_no' => 0]);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('shg', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('shg', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id) {
        if (($model = RsetisBatchParticipants::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

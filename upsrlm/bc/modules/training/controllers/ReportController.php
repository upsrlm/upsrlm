<?php

namespace bc\modules\training\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\training\models\RsetisCenterSearch;
use bc\modules\training\models\form\RsetisCenterForm;
use bc\modules\training\models\RsetisCenter;
use common\models\master\MasterRole;
use bc\modules\training\models\RsetisBatchParticipants;
/**
 * Default controller for the `training` module
 */
class ReportController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $searchModel = new RsetisCenterSearch();
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, false);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $rseth_bank_query = \common\models\dynamicdb\bc\User::find()->select(['user.id', 'user.name'])->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'user.status' => 10]);
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
            $rseth_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
        }
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
            $rseth_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
        }
        $rseth_bank = $rseth_bank_query->orderBy('bank_name asc')->all();
//        $partner_bank_query = \common\models\dynamicdb\bc\User::find()->select(['user.id', 'user.name'])->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'user.status' => 10]);
//        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
//            $partner_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
//        }
//        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
//            $partner_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
//        }
//        $partner_bank_bank = $partner_bank_query->orderBy('name asc')->all();
        
        $searchModel->rsethi_bank_option = \yii\helpers\ArrayHelper::map($rseth_bank, 'profile.bank_name', 'profile.bank_name');
        //$searchModel->bc_partner_bank_option = \yii\helpers\ArrayHelper::map($partner_bank_bank, 'id', 'name');
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadcsv() {
        try {

            $searchModel = new RsetisCenterSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            $models = $dataProvider->getModels();
            echo count($models);
            exit();
            $file = "training_report_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'District', 'RSETI Director', 'RSETI Bank', 'BC Partner Bank', 'Total GP', 'Total BC Shortlisted', 'No. of batches Proposed', 'No. of Batches Planned', 'No. of Batches concluded', 'Avg Batch Size', 'No. of Participants', 'Certified by IIBF '));
            $sr_no = 1;
            $row = [];
            $gp_total = $bc_total = $exp_total = $tplaned_total = $tfinished_total = $p_total = $cbibf_total = 0;
            foreach ($models as $model) {
//                $gp_total = $gp_total + $model->total_gp;
//                $bc_total = $bc_total + $model->total_bc_sortlisted;
//                $exp_total = $exp_total + ceil($model->total_bc_sortlisted / 30);
//                $tplaned_total = $tplaned_total + $model->nooftrainingplaned;
//                $tfinished_total = $tfinished_total + $model->nooftrainingfinished;
//                $p_total = $p_total + (int) $model->getTraining()->sum('no_of_participant');
//                $cbibf_total = $cbibf_total + $model->getParticipant()->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS])->count();
                $contacts = '';
                if ($model->rsethicontacts != null) {
                    foreach ($model->rsethicontacts as $contact) {
                        $contacts .= $contact->user->name . " (" . $contact->user->mobile_no . ")" . " ";
                    }
                }
                $bcp = '';
                if ($model->bcbankpartner != null) {
                    foreach ($model->bcbankpartner as $bcbankpartner) {
                        $bcp .= $bcbankpartner->user->name . " ";
                    }
                }

                $row = [
                    $sr_no,
                    $model->district_name,
                    $contacts,
                    implode(" ", yii\helpers\ArrayHelper::getColumn($model->rsethileadbank, 'profile.bank_name')),
                    $bcp,
                    $model->total_gp,
                    $model->total_bc_sortlisted,
                    ceil($model->total_bc_sortlisted / 30),
                    $model->nooftrainingplaned,
                    $model->nooftrainingfinished,
                    (int) $model->getTraining()->count() != 0 ? round((int) $model->getTraining()->sum('no_of_participant') / (int) $model->getTraining()->count()) : '',
                    (int) $model->getTraining()->sum('no_of_participant'),
                    $model->getParticipant()->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS])->count()
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }
    }

    public function actionUpdate($centerid) {
        $centermodel = $this->findModel($centerid);
        $model = new RsetisCenterForm($centermodel);
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            $model->center_model->setAttributes([
                'name' => $model->name,
                'district_code' => $model->district_code,
                'venue' => $model->venue,
            ]);

            if ($model->center_model->save()) {

                \Yii::$app->getSession()->setFlash('success', 'successfully saved');
                return $this->redirect(['/training/training']);
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionView($centerid) {
        $model = $this->findModel($centerid);
        $searchModelt = new \bc\modules\training\models\RsetisCenterTrainingSearch();
        $searchModelt->rsetis_center_id = $centerid;
        $dataProvidert = $searchModelt->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        $searchModelp = new \bc\modules\training\models\RsetisBatchParticipantsSearch();
        $searchModelp->rsetis_center_id = $centerid;
        $dataProviderp = $searchModelp->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 300);
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
                        'searchModelt' => $searchModelt,
                        'searchModelp' => $searchModelp,
                        'dataProvidert' => $dataProvidert,
                        'dataProviderp' => $dataProviderp,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
                        'searchModelt' => $searchModelt,
                        'searchModelp' => $searchModelp,
                        'dataProvidert' => $dataProvidert,
                        'dataProviderp' => $dataProviderp,
            ]);
        }
    }

    public function actionPopulate() {
        $districts = \bc\modules\selection\models\base\GenralModel::districtoption();

        $center = RsetisCenter::find()->all();
        if ($center == null) {
            foreach ($districts as $key => $district_code) {
                $dist_model = \bc\models\master\MasterDistrict::findOne(['district_code' => $key]);
                $model = new RsetisCenter();
                $model->name = $dist_model->district_name . ' venue';
                $model->district_code = $dist_model->district_code;
                $model->venue = $dist_model->district_name;
                $model->save();
            }
            return $this->redirect(['/training/center']);
        }
    }

    protected function findModel($id) {
        if (($model = RsetisCenter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

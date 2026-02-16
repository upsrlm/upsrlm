<?php

namespace bc\modules\report\controllers;

use Yii;
use bc\models\report\Graph;
use yii\web\Controller;
use bc\modules\selection\models\BcPbtFeedback;
use bc\modules\selection\models\BcPbtFeedbackSearch;
use bc\modules\selection\models\base\GenralModel;
use bc\models\SbiDistrictMouSearch;
use bc\modules\selection\models\SrlmBcApplication;

/**
 * Default controller for the `report` module
 */
class SbiController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['mou'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['mou'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionMou() {
        $model = [];
        $searchModel1 = new SbiDistrictMouSearch();
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $dataProvider1->query->andWhere(['sbi_distict_all' => 0]);

        $searchModel2 = new SbiDistrictMouSearch();

        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $dataProvider2->query->andWhere(['sbi_distict_all' => 1]);

        return $this->render('mou', [
                    'model' => $model,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionDownloadp() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        $array = ['-2' => 'Unwilling', 0 => 'Preselected', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', '32' => 'Certified Unwilling', '4' => 'Not Certified', '5' => 'ineligible', '55' => 'ineligible', '6' => 'Absent'];
        $searchModel = new \bc\modules\report\models\form\ReportSearchForm(Yii::$app->request->queryParams);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel1 = new \bc\models\master\MasterGramPanchayatSearch();
        $dataProvider1 = $searchModel1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);

        $dataProvider1->query->andWhere(['=', 'master_partner_bank_id', '7']);
        $dataProvider1->query->andWhere(['master_gram_panchayat.district_code' => [124, 134, 145, 152, 158, 167, 168, 169, 172, 177, 181, 660]]);
        $dataProvider1->query->orderBy(['master_gram_panchayat.district_name' => SORT_ASC, 'master_gram_panchayat.block_name' => SORT_ASC, 'master_gram_panchayat.gram_panchayat_name' => SORT_ASC]);
        $file = "bc_gp_status_" . date("Y_m_d_H-m-s") . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No',
            'BC District',
            'BC Block',
            'BC GP',
            'GP Banking Partner',
            'Current BC Banking Partner',
            'GP BC STATUS',
            'Name',
            'OTP Verified Mobile No.',
            'Mobile No.',
            'Upload PVR Status',
            'PFMS status',
            'BC-SHG payment status',
            'PAN Card available',
            'Handheld Machine provided',
            'Acknowledge support funds received',
            'Acknowledge handheld machine received',
            'Bank ID of BC')
        );
        $sr_no = 1;
        $row = [];
        $dataProvider1->pagination = false;
        $models = $dataProvider1->getModels();
        foreach ($models as $model) {
            $name = '';
            $otp_mobile_no = '';
            $mobile_number = '';
            $banking_partner = '';
            $bcshg = '';
            $pvr_status = '';
            $pfms = '';
            $bc_shg_funds_status = '';
            $pan = '';
            $handheld_machine_status = '';
            $bc_support_funds_received = '';
            $bc_handheld_machine_recived = '';
            $bankidbc = '';
            if ($model->gpdetail->issue) {
                $bcs = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'training_status' => 3])->one();
                if ($bcs != null) {
                    $model->gpdetail->current_status = 3;
                } else {
                    $bcs = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'training_status' => [0, 1, 2, 3]])->one();
                    if ($bcs != null) {
                        $model->gpdetail->current_status = $bcs->training_status;
                    }
                }
            }
            $gp_status = $array[$model->gpdetail->current_status];
            if (in_array($model->gpdetail->current_status, [-2, 32, 4, 5, 6]) and $model->gpdetail->current_available == '0') {
                $gp_status = 'GP Vacant';
            }
            if (in_array($model->gpdetail->current_status, [-2, 32, 4, 5, 6]) and $model->gpdetail->current_available > '0') {
                $gp_status = 'Standby';
            }
            if (!in_array($gp_status, ['GP Vacant', 'Standby'])) {
                
            }
            $bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'master_partner_bank_id' => 7, 'training_status' => [0, 1, 2, 3]])->one();
            if (isset($bc) and $bc != null) {
                $name = $bc->name;
                $banking_partner = isset($bc->pbank) ? $bc->pbank->bank_short_name : '';
                $otp_mobile_no = $bc->mobile_no;
                $mobile_number = $bc->mobile_number;
                if ($bc->training_status == 3) {
                    $pvr_status = 'No';
                    if ($bc->pvr_status == 1) {
                        $pfms = 'Yes';
                    }
                    if ($bc->pfms_maped_status == 1) {
                        $pfms = 'Yes';
                    }
                    if ($bc->pfms_maped_status == 0) {
                        $pfms = 'No';
                    }
                    if ($bc->bc_shg_funds_status == 1) {
                        $bc_shg_funds_status = 'Yes';
                    }
                    if ($bc->bc_shg_funds_status == 0) {
                        $bc_shg_funds_status = 'No';
                    }
                    if ($bc->pan_card_status == 1) {
                        $pan = 'Yes';
                    }
                    if ($bc->pan_card_status == 0) {
                        $pan = 'No';
                    }
                    if ($bc->handheld_machine_status == 1) {
                        $handheld_machine_status = 'Yes';
                    }
                    if ($bc->handheld_machine_status == 0) {
                        $handheld_machine_status = 'No';
                    }
                    $bcshg = 'Yes';
                    if ($bc->already_group_member == 1) {
                        $bcshg = 'No';
                    }
                    if ($bc->bc_shg_funds_status == 1) {
                        $bc_support_funds_received = 'No';
                    }
                    if ($bc->bc_support_funds_received == 1) {
                        $bc_support_funds_received = 'Yes';
                    }
                    if ($bc->handheld_machine_status == 1) {
                        $bc_handheld_machine_recived = 'No';
                    }
                    if ($bc->bc_handheld_machine_recived == 1) {
                        $bc_handheld_machine_recived = 'Yes';
                    }
                    if ($bc->bankidbc) {
                        $bankidbc = $bc->bankidbc;
                    }
                }
            } else {
                $name = '';
                $otp_mobile_no = '';
                $mobile_number = '';
                $banking_partner = '';
                $bcshg = '';
                $pvr_status = '';
                $pfms = '';
                $bc_shg_funds_status = '';
                $pan = '';
                $handheld_machine_status = '';
                $bc_support_funds_received = '';
                $bc_handheld_machine_recived = '';
                $bankidbc = '';
            }
            $row = [
                $sr_no,
                $model->district_name,
                $model->block_name,
                str_replace(',', '', trim($model->gram_panchayat_name, ',')),
                (isset($model->cbank)) ? $model->cbank->bank_short_name : '',
                $banking_partner,
                $gp_status,
                $name,
                $otp_mobile_no,
                $mobile_number,
                $pvr_status,
                $pfms,
                $bc_shg_funds_status,
                $pan,
                $handheld_machine_status,
                $bc_support_funds_received,
                $bc_handheld_machine_recived,
                $bankidbc,
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit();
    }
}

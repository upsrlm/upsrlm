<?php

namespace bc\modules\report\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\report\models\form\ReportSearchForm;
use bc\models\BcCumulativeReportDistrict;
use bc\models\BcCumulativeReportDistrictSearch;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportBlock;
use bc\models\BcCumulativeReportBlockSearch;

/**
 * PartneragenciesController for the `report` module
 */
class CumulativeController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['district', 'weekly', 'pendencyd', 'pendencydb'],
                'rules' => [
                    [
                        'actions' => ['district', 'weekly', 'pendencyd', 'pendencydb'],
                        'allow' => true,
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
    public function actionPendencyd() {

        $model = BcCumulativeReportDistrict::find()->select(['date'])->orderBy("date DESC")->limit(1)->one();
        $searchModel = new BcCumulativeReportDistrictSearch();
        $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_CORPORATE_BCS])) {
            $searchModel->master_partner_bank_id = \Yii::$app->user->identity->master_partner_bank_id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModelb = new \bc\models\BcCumulativeReportDistrictPartnerBankSearch();
        $searchModelb->date = isset($model) ? $model->date : date('Y-m-d');
        if ($searchModel->master_partner_bank_id) {
            $searchModelb->master_partner_bank_id = $searchModel->master_partner_bank_id;
        }
        if ($searchModel->aspirational) {
            $searchModelb->aspirational = $searchModel->aspirational;
        }
        $dataProviderb = $searchModelb->search(Yii::$app->request->queryParams, Yii::$app->user->identity);

        return $this->render('pendencyd', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProviderb' => $dataProviderb,
        ]);
    }

    public function actionPendencydb($district_code, $master_partner_bank_id = null) {

        $model = \bc\models\BcCumulativeReportBlock::find()->orderBy("date DESC")->limit(1)->one();
        $dis_model = \bc\models\master\MasterDistrict::findOne(['district_code' => $district_code]);
        if ($dis_model == null) {
            return $this->redirect(['/report/cumulative/pendencyd']);
        }
        $searchModel = new BcCumulativeReportBlockSearch();
        $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
        $searchModel->district_code = $district_code;
        if ($master_partner_bank_id) {
            $searchModel->master_partner_bank_id = $master_partner_bank_id;
        }
         if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_CORPORATE_BCS])) {
            $searchModel->master_partner_bank_id = \Yii::$app->user->identity->master_partner_bank_id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModelb = new \bc\models\BcCumulativeReportBlockPartnerBankSearch();
        $searchModelb->date = isset($model) ? $model->date : date('Y-m-d');
        $searchModelb->district_code = $district_code;
        if ($master_partner_bank_id) {
            $searchModelb->master_partner_bank_id = $master_partner_bank_id;
        }

        $dataProviderb = $searchModelb->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        return $this->render('pendencydb', [
                    'dis_model' => $dis_model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProviderb' => $dataProviderb,
        ]);
    }

    public function actionPendencyasblock() {

        $model = \bc\models\BcCumulativeReportBlock::find()->orderBy("date DESC")->limit(1)->one();
        $searchModel = new BcCumulativeReportBlockSearch();
        $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
        $searchModel->aspirational = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        return $this->render('pendencyasblock', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDistrict() {

        $searchModel = new BcCumulativeReportDistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModels = new \bc\models\report\District();
        $dataProvider = $searchModels->weeklys(Yii::$app->request->queryParams);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        return $this->render('weekly', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

//    public function actionCopy() {
//
//        $models = BcCumulativeReportDistrict::find()->where(['date' => '2021-07-10'])->all();
//        foreach ($models as $model) {
//            $rep_dis_model = BcCumulativeReportDistrict::findOne(['district_code' => $model->district_code, 'date' => '2021-07-09']);
//            if ($rep_dis_model == null) {
//                $rep_dis_model = new BcCumulativeReportDistrict();
//            }
//            $rep_dis_model->district_code = $model->district_code;
//            $rep_dis_model->district_name = $model->district_name;
//            $rep_dis_model->master_partner_bank_id = $model->master_partner_bank_id;
//            $rep_dis_model->partner_bank_name = $model->partner_bank_name;
//
//            $rep_dis_model->certified_bc = $model->certified_bc;
//            $rep_dis_model->onboard_bc = $model->onboard_bc;
//            $rep_dis_model->pvr = $model->pvr;
//            $rep_dis_model->shg_assigned = $model->shg_assigned;
//
//            $rep_dis_model->bc_shg_bank_verified = $model->bc_shg_bank_verified;
//            $rep_dis_model->pfms_mapping = $model->pfms_mapping;
//            $rep_dis_model->bc_support_fund_shg_transfer = $model->bc_support_fund_shg_transfer;
//
//            $rep_dis_model->bc_support_fund_shg_acknowledge = $model->bc_support_fund_shg_acknowledge;
//            $rep_dis_model->handheld_machine_provided = $model->handheld_machine_provided;
//            $rep_dis_model->handheld_machine_acknowledge = $model->handheld_machine_acknowledge;
//            $rep_dis_model->bc_bank_transaction = $model->bc_bank_transaction;
//            $rep_dis_model->bc_bank_transaction_count = $model->bc_bank_transaction_count;
//            $rep_dis_model->no_of_bc_shortlisted = $model->no_of_bc_shortlisted;
//            $rep_dis_model->no_of_training_conculded = $model->no_of_training_conculded;
//            $rep_dis_model->no_of_training_planned = $model->no_of_training_planned;
//            $rep_dis_model->no_of_gp = $model->no_of_gp;
//            $rep_dis_model->no_of_unwilling = $model->no_of_unwilling;
//            $rep_dis_model->no_of_bc_appeared_training = $model->no_of_bc_appeared_training;
//            $rep_dis_model->date = '2021-07-09';
//            $rep_dis_model->last_updated_on = '2021-07-09 13:38:13';
//            $rep_dis_model->save();
//        }
//    }

    public function actionDdownload() {
        $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
        $searchModel = new BcCumulativeReportDistrictSearch();
        $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $count = $dataProvider->query->count();

        $models = $dataProvider->getModels();
        $temp_data = "#,"
                . "District,"
                . "Partner Bank/FI,"
                . "No Of Bc Shortlisted,"
                . "No Of GP,"
                . "No Of Unwilling,"
                . "Certified BC,"
                . "Onboard BC,"
                . "PVR,"
                . "SHG Assigned,"
                . "BC SHG Bank Verified,"
                . "PFMS Mapping,"
                . "BC Support Fund Shg Transfer,"
                . "BC Support Fund Shg Acknowledge,"
                . "Handheld Machine Provided,"
                . "Handheld Machine Acknowledge,"
                . "BC Bank Transaction,"
                . "BC Bank Transaction Count\n";
        $file_name = "cumulative_district_report _" . date("Y_m_d_H-m-s");
        $filePath = Yii::$app->params['tmp'] . $file_name . ".csv";
        $fp = fopen($filePath, 'a+');
        $sr_no = 1;
        foreach ($models as $model) {
            $temp_data .= "$sr_no,"
                    . "$model->district_name,"
                    . "$model->partner_bank_name,"
                    . "$model->no_of_bc_shortlisted,"
                    . "$model->no_of_gp,"
                    . "$model->no_of_unwilling,"
                    . "$model->certified_bc,"
                    . "$model->onboard_bc,"
                    . "$model->pvr,"
                    . "$model->shg_assigned,"
                    . "$model->bc_shg_bank_verified,"
                    . "$model->pfms_mapping,"
                    . "$model->bc_support_fund_shg_transfer,"
                    . "$model->bc_support_fund_shg_acknowledge,"
                    . "$model->handheld_machine_provided,"
                    . "$model->handheld_machine_acknowledge,"
                    . "$model->bc_bank_transaction,"
                    . "$model->bc_bank_transaction_count\n";
            $sr_no++;
        }

        fwrite($fp, $temp_data);
        fclose($fp);

        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        header("Content-Type: application/csv");
        header("Content-Length: " . filesize($filePath));
        header("Content-Disposition: attachment; filename=$file_name.csv");
        readfile($filePath);
        exit();
    }

    public function actionD() {
        $searchModel = new BcCumulativeReportDistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModels = new \bc\models\report\District();
        $dataProvider = $searchModels->weeklys(Yii::$app->request->queryParams);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        header('Content-type: application/excel');
        $filename = 'filename.xls';
        header('Content-Disposition: attachment; filename=' . $filename);

        $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Sheet 1</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>

<body>
   <table><tr><td>Cell 1</td><td>Cell 2</td></tr></table>
</body>



</html>';

        echo $data;
        exit();
        return $this->render('weekly', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
}

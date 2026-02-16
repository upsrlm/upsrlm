<?php

namespace app\modules\viewdashboard\controllers;
use Yii;
use yii\web\Controller;
use bc\models\BcMonthlyReport;

/**
 * Default controller for the `viewdashboard` module
 */
class TransactionController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionReport() {
        $data = [];
        $current_month_id=\bc\modules\selection\models\base\GenralModel::current_month_id();
        $sql = "SELECT *,DATE_FORMAT(month_start_date, '%b %Y') as month,FLOOR(no_of_bc/operational) as avg_bc,FLOOR(no_of_transaction/no_of_bc) as avg_transaction_no,FLOOR(transaction_amount/no_of_bc) as avg_txn_amount,FLOOR(commission_amount/no_of_bc) as avg_com_amount FROM `bc_monthly_report` where month_id > 5 and month_id <=".$current_month_id." order by month_start_date asc";
        $connection = \Yii::$app->dbbc;
        $command = $connection->createCommand($sql);
        $report = $command->queryAll();
        return $this->render('index', ['report' => $report]);
    }
    public function actionBank() {
        $searchModel = new \bc\models\transaction\BcTransactionOverallPartnerBankSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
       

        return $this->render('bank', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIndex() {
        $seach=new \bc\modules\transaction\models\summary\form\SearchForm(Yii::$app->request->queryParams);
        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummarySearch();
        $dataProvider = $searchModel->search($seach, Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $searchModel1 = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthlySearch();
        $report = $searchModel1->chart($seach, Yii::$app->user->identity);
        return $this->render('report', [
                    'searchModel' => $seach,
                    'dataProvider' => $dataProvider,
                    'report' => $report
        ]);
    }

}

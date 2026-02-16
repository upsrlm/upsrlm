<?php

namespace app\modules\page\controllers;
use Yii;
use yii\web\Controller;
use bc\models\BcMonthlyReport;

/**
 * Default controller for the `viewdashboard` module
 */
class TransactionController extends Controller {

    
    public function actionIndex() {
        $sql = "SELECT *,DATE_FORMAT(month_start_date, '%b %Y') as month,FLOOR(no_of_bc/operational) as avg_bc,FLOOR(no_of_transaction/no_of_bc) as avg_transaction_no,FLOOR(transaction_amount/no_of_bc) as avg_txn_amount,FLOOR(commission_amount/no_of_bc) as avg_com_amount FROM `bcsakhi_transaction_monthly_report`  order by month_start_date asc";
        $connection = \Yii::$app->dbbc;
        $command = $connection->createCommand($sql);
        $report = $command->queryAll();
        return $this->render('report', [
                    'report' => $report
        ]);
    }
    public function actionBc($bcid) {
       $model=$this->findModel($bcid);
        return $this->render('bc', [
                    'model' => $model,
                    
        ]);
    }
    public function actionBcview($bcid) {
        Yii::$app->params['baseurl_bc_image']='https://bc.upsrlm.org';
       $model=$this->findModel($bcid);
        return $this->render('bcview', [
                    'model' => $model,
                    
        ]);
    }
    protected function findModel($id) {
        if (($model = \common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary::findOne(['bc_application_id'=>$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

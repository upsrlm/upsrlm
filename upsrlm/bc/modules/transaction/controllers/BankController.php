<?php

namespace bc\modules\transaction\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\transaction\models\summary\BcTransactionBankSummarySearch;
use bc\modules\transaction\models\summary\BcTransactionBankSummaryMonthlySearch;
use bc\modules\transaction\models\summary\BcTransactionBankSummaryWeeklySearch;
use bc\modules\transaction\models\summary\BcTransactionBankSummaryDailySearch;

/**
 * BankController implements the CRUD actions for PartnerAssociates model.
 */
class BankController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['overallperformance', 'monthlyperformance', 'weeklyperformance', 'dailyperformance'],
                'rules' => [
                    [
                        'actions' => ['overallperformance', 'monthlyperformance', 'weeklyperformance', 'dailyperformance'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'block' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PartnerAssociates models.
     * @return mixed
     */
    public function actionOverallperformance() {
        $searchModel = new BcTransactionBankSummarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);

        return $this->render('overallperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDailyperformance() {
        $searchModel = new BcTransactionBankSummaryDailySearch();

        if (!isset(Yii::$app->request->queryParams['BcTransactionBankSummaryDailySearch']['from_date_time'])) {
            $searchModel->from_date_time = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
            $searchModel->to_date_time = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);

        return $this->render('dailyperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWeeklyperformance() {
        $searchModel = new BcTransactionBankSummaryWeeklySearch();
        $searchModel->week_option = \bc\modules\selection\models\base\GenralModel::bctweekoption($searchModel);
        if (!isset(\Yii::$app->request->queryParams['BcTransactionBankSummaryWeeklySearch']['week_id'])) {
            $searchModel->week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
        }
        if (empty(\Yii::$app->request->queryParams)) {
            $searchModel->week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);

        return $this->render('weeklyperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMonthlyperformance() {
        $null = new \yii\db\Expression('NULL');
        $searchModel = new BcTransactionBankSummaryMonthlySearch();

        if (!isset(\Yii::$app->request->queryParams['BcTransactionBankSummaryMonthlySearch']['month_id'])) {
            $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        }
        if (empty(Yii::$app->request->queryParams)) {
            $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);

        $searchModel->month_option = \bc\modules\selection\models\base\GenralModel::bctmonthoption();
        return $this->render('monthlyperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}

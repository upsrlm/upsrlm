<?php

namespace backend\modules\cloudtel\controllers;

use Yii;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogController implements the CRUD actions for CloudTeleApiLog model.
 */
class LogController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CloudTeleApiLog models.
     * @return mixed
     */
    public function actionIndex() {
        try {
            \Yii::$app->params['page_size30'] = 20;
            $searchModel = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModel->upsrlm_call_type = 1;
            //$searchModel->project_id = 1;
            if (!isset(Yii::$app->request->queryParams['DyCloudTeleApiLogSearch']['month'])) {
                $date = new \DateTime('now');
                $date->modify('first day of this month');
                $searchModel->month = $date->format('Y-m-d');
            } else {
                if (Yii::$app->request->queryParams['DyCloudTeleApiLogSearch']['month'] == '') {
                    $date = new \DateTime('now');
                    $date->modify('first day of this month');
                    $searchModel->month = $date->format('Y-m-d');
                } else {
                    $searchModel->month = Yii::$app->request->queryParams['DyCloudTeleApiLogSearch']['month'];
                }
            }
            $searchModel->SetDate($searchModel->month);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $searchModel->upsrlm_connection_status_option = \common\models\base\GenralModel::cloud_tel_connection_status_option();
            $searchModel->upsrlm_call_status_option = \common\models\base\GenralModel::cloud_tel_call_status_option();
            $searchModel->api_call_status_option = \common\models\base\GenralModel::cloud_tel_api_call_status_option();
            $searchModel->api_status_code_option = \common\models\base\GenralModel::cloud_tel_api_status_code_option();
            $searchModel->upsrlm_call_scenario_option = \common\models\base\GenralModel::cloud_tel_call_scenario_option();
            $searchModel->month_option = \common\models\base\GenralModel::month_option_cloud_call();
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } catch (\Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actionIbd() {
        try {
            \Yii::$app->params['page_size30'] = 20;
            $searchModel = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModel->upsrlm_call_type = 2;
            //$searchModel->project_id = 1;
            if (!isset(Yii::$app->request->queryParams['DyCloudTeleApiLogSearch']['month'])) {
                $date = new \DateTime('now');
                $date->modify('first day of this month');
                $searchModel->month = $date->format('Y-m-d');
            } else {
                if (Yii::$app->request->queryParams['DyCloudTeleApiLogSearch']['month'] == '') {
                    $date = new \DateTime('now');
                    $date->modify('first day of this month');
                    $searchModel->month = $date->format('Y-m-d');
                } else {
                    $searchModel->month = Yii::$app->request->queryParams['DyCloudTeleApiLogSearch']['month'];
                }
            }
            $searchModel->SetDate($searchModel->month);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $searchModel->upsrlm_connection_status_option = \common\models\base\GenralModel::cloud_tel_connection_status_option();
            $searchModel->upsrlm_call_status_option = \common\models\base\GenralModel::cloud_tel_call_status_option();
            $searchModel->api_call_status_option = \common\models\base\GenralModel::cloud_tel_api_call_status_genral_option();
            $searchModel->api_status_code_option = \common\models\base\GenralModel::cloud_tel_api_status_code_option();
            $searchModel->upsrlm_call_scenario_option = \common\models\base\GenralModel::cloud_tel_call_scenario_option();
            $searchModel->month_option = \common\models\base\GenralModel::month_option_cloud_call();
            return $this->render('ibd', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } catch (\Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Displays a single CloudTeleApiLog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionTelecalleraudio($log_id, $date) {
        $model = $this->findModel($log_id, $date);

        return $this->renderAjax('telecalleraudio', [
                    'model' => $model,
        ]);
    }

    public function actionTelecalleribdaudio($log_id, $date) {
        $model = $this->findModel($log_id, $date);

        return $this->renderAjax('ibdaudeo', [
                    'model' => $model,
        ]);
    }

    public function actionDownloadctc() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new CloudTeleApiLogSearch();
            $searchModel->upsrlm_call_type = 1;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], \common\models\base\GenralModel::select_cloud_tele_log_columns());

            $file = "call_ctc_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Caller No.', 'Calling To.', 'Api Status', 'Call Status', 'Datetime', 'Ivr Duration', 'Talk Duration', 'Upsrlm Connection Status', 'Upsrlm Call Status'));
            $sr_no = 1;
            $row = [];
            $dataProvider->query->select(['cloud_tele_api_log.id']);

            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $model = CloudTeleApiLog::findOne($model);
                $status = '';
                if ($model->api_status) {
                    $status .= $model->api_status;
                }
                if (isset($model->apicallerror->error_discription)) {
                    $status .= ' : ' . $model->apicallerror->error_discription;
                }
                $row = [
                    $sr_no,
                    $model->upsrlm_user_mobile_no != null ? $model->upsrlm_user_mobile_no : '',
                    $model->customernumber != null ? $model->customernumber : '',
                    $status,
                    $model->apicallstatus != null ? $model->apicallstatus->id . ' : ' . $model->apicallstatus->call_status_ctc : '',
                    $model->api_request_datetime != null ? $model->api_request_datetime : '',
                    $model->ivrDuration != null ? $model->ivrDuration : '',
                    $model->talkDuration != null ? $model->talkDuration : '',
                    $model->connectionstatus != null ? $model->connectionstatus->connection_status : '',
                    $model->callstatus != null ? $model->callstatus->call_status : '',
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            
        }
    }

    public function actionDownloadibd() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new CloudTeleApiLogSearch();
            $searchModel->upsrlm_call_type = 2;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], \common\models\base\GenralModel::select_cloud_tele_log_columns());
            $file = "call_ibd_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Agent No.', 'Caller No.', 'Api Status', 'Call Status', 'Datetime', 'Ivr Duration', 'Talk Duration'));
            $sr_no = 1;
            $row = [];
            $dataProvider->query->select(['cloud_tele_api_log.id']);

            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $model = CloudTeleApiLog::findOne($model);
                $status = '';
                if ($model->api_status) {
                    $status .= $model->api_status;
                }
                if (isset($model->apicallerror->error_discription)) {
                    $status .= ' : ' . $model->apicallerror->error_discription;
                }
                $row = [
                    $sr_no,
                    $model->upsrlm_user_mobile_no != null ? $model->upsrlm_user_mobile_no : '',
                    $model->customernumber != null ? $model->customernumber : '',
                    $status,
                    $model->apicallstatus != null ? $model->apicallstatus->id . ' : ' . $model->apicallstatus->call_status_ctc : '',
                    $model->api_request_datetime != null ? $model->api_request_datetime : '',
                    $model->ivrDuration != null ? $model->ivrDuration : '',
                    $model->talkDuration != null ? $model->talkDuration : '',
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            
        }
    }

    protected function findModel($id, $date) {
        $q = new CloudTeleApiLog();
        if (isset($date) && $date != '') {
            if (date("my", strtotime($date)) == date("my")) {
                
            } else {
                $q = new CloudTeleApiLog(CloudTeleApiLog::$defaul_table . '_' . date("Ym", strtotime($date)));
            }
        }
        $query = $q->find();
        if (($model = $query->where(['id' => $id])->limit(1)->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}

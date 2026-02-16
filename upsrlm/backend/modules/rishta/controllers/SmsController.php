<?php

namespace backend\modules\rishta\controllers;

use Yii;
use common\models\rishta\RishtaSmsLog;
use common\models\rishta\RishtaSmsLogSearch;
use common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPin;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SmsController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['log', 'cst', 'sakhi'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['log', 'cst', 'sakhi'],
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

    public function actionLog() {
        $searchModel = new RishtaSmsLogSearch();
        $searchModel->tempplate_option = [2 => 'SHG Office Bearer', 1 => 'SHG Office Bearer PIN', 3 => 'Wada Samuh Sakhi Nominated'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);

        return $this->render('log', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCst() {
//        try {
        $searchModel = new \common\models\wada\form\DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModel1 = new \common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPinSearch();
        $searchModel1->wada = 1;
        $dataProvider1 = $searchModel1->search($searchModel, Yii::$app->user->identity);
        $searchModel2 = new \common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPinSearch();
        $searchModel2->wada = 1;
        $dataProvider2 = $searchModel2->search($searchModel, Yii::$app->user->identity);
        $dataProvider2->query->andWhere(['rishta_shg_member_app_pin.app_sms_status' => [2, 3]]);
        $searchModel3 = new \common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPinSearch();
        $searchModel3->wada = 1;
        $dataProvider3 = $searchModel3->search($searchModel, Yii::$app->user->identity);
        $dataProvider3->query->andWhere(['rishta_shg_member_app_pin.app_sms_status' => 3]);
        $searchModel4 = new \common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPinSearch();
        $searchModel4->wada = 1;
        $dataProvider4 = $searchModel4->search($searchModel, Yii::$app->user->identity);
        $dataProvider4->query->andWhere(['rishta_shg_member_app_pin.pin_sms_status' => 2]);
        $searchModel5 = new \common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPinSearch();
        $searchModel5->wada = 1;
        $dataProvider5 = $searchModel5->search($searchModel, Yii::$app->user->identity);
        $dataProvider5->query->joinWith(['user']);
        $dataProvider5->query->andWhere(['rishta_shg_member_app_pin.app_sms_status' => [3]]);
        $dataProvider5->query->andWhere(['not', ['user.app_id' => null]]);
        $searchModel6 = new \common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPinSearch();
        $searchModel6->wada = 1;
        $dataProvider6 = $searchModel6->search($searchModel, Yii::$app->user->identity);
        $dataProvider6->query->joinWith(['user']);
        $dataProvider6->query->andWhere(['not', ['user.app_id' => null]]);
        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "3") {
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "4") {
            $dataProvider = $dataProvider4;
        } elseif ($button_type == "5") {
            $dataProvider = $dataProvider5;
        } elseif ($button_type == "6") {
            $dataProvider = $dataProvider6;
        }
        return $this->render('cst', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4,
                    'dataProvider5' => $dataProvider5,
                    'dataProvider6' => $dataProvider6,
                    'button_type' => $button_type
        ]);
//        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//            print_r($ex->getCode());
//            exit;
//        }
    }

    public function actionSamuhsakhi() {
        $searchModel = new \common\models\wada\form\DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModel1 = new \common\models\dynamicdb\cbo_detail\RishtaShgSamuhSakhiSmsApppinStatusSearch();
        $searchModel1->wada = 1;
        $dataProvider = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        return $this->render('samuhsakhi', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSendapplink($id) {
        try {
            $cts = RishtaShgMemberAppPin::findOne($id);
            if ($cts != null) {
                $sms_serve = new \common\components\sms\Smssarv();
                $sms_log_model = new \common\models\rishta\RishtaSmsLog();
                $sms_log_model->user_id = 0;
                $sms_log_model->mobile_number = $cts->mobile_no;
                $sms_log_model->rishta_sms_template_id = \common\components\sms\Smssarv::RISHTA_APP_LINK_TEMPLATE_ID;
                $sms_log_model->model = json_encode(['mobile_number' => $sms_log_model->mobile_number, 'm' => $sms_log_model->mobile_number, 'template_id' => \common\components\sms\Smssarv::TEMPLATE_ID_LINK]);
                $sms_log_model->sms_content = $sms_serve::sms_content(['m' => $sms_log_model->mobile_number], \common\components\sms\Smssarv::RISHTA_APP_LINK_TEMPLATE_ID);
                $sms_log_model->sms_length = strlen($sms_log_model->sms_content);
                $cts->app_sms_status = RishtaShgMemberAppPin::APP_SMS_STATUS_LOG;
                if ($sms_log_model->save()) {
                    $sms_serve->options = ['template_id' => \common\components\sms\Smssarv::TEMPLATE_ID_LINK, 'template' => $sms_log_model->sms_content, 'contact_numbers' => $sms_log_model->mobile_number];
                    $sms_serve->enableSendSms = \Yii::$app->params['sarv_sms_enable'];
                    if ($sms_serve->enableSendSms) {
                        $log = $sms_serve->SendSMS();
                        if (isset($log) and!empty($log)) {
                            $sms_log_model->sms_send_time = new \yii\db\Expression('NOW()');
                            $sms_log_model->status = 1;
                            $cts->app_sms_status = RishtaShgMemberAppPin::APP_SMS_STATUS_SEND;
                            $cts->app_sms_time = new \yii\db\Expression('NOW()');
                            $cts->save();
                            if (isset($log['msg'])) {
                                if ($log['msg'] == 'success') {
                                    $sms_log_model->status = 1;
                                    if (isset($log['data'][0]['campaign_id'])) {
                                        $sms_log_model->sms_provider_campaign_id = $log['data'][0]['campaign_id'];
                                    }
                                    if (isset($log['data'][0]['message_id'])) {
                                        $sms_log_model->sms_provider_message_id = $log['data'][0]['message_id'];
                                    }
                                }
                                if ($log['msg'] == 'error') {
                                    $sms_log_model->status = 2;
                                }
                                $sms_log_model->sms_provider_msg = $log['msg'];
                                $sms_log_model->sms_provider_code = $log['code'];
                                $sms_log_model->sms_provider_msg_text = $log['msg_text'];
                            }
                            $sms_log_model->save();
                            \Yii::$app->getSession()->setFlash('success', 'App link sms send successfully');
                            return $this->redirect('/rishta/sms/cst');
                        }
                    }
                }
            } else {
                return $this->redirect('/rishta/sms/cst');
            }
        } catch (\Exception $ex) {
            
        }
    }

    protected function findModel($id) {
        if (($model = RishtaSmsLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

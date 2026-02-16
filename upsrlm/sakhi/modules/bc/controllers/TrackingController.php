<?php

namespace sakhi\modules\bc\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `bc` module
 */
class TrackingController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message;

    public function beforeAction($action) {

        Yii::$app->request->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionFeedback($bcid) {
        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \bc\modules\selection\models\form\BCTrackingFeedbackForm($bc_model);
            $model->scenario = (string) $model->section;
            $model->section_name = $model->section_option[$model->section];

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $this->message = $model->section_name . ' जानकारी सफलता पूर्वक प्राप्त हुआ';

                    if ($model->section == '1') {
                        foreach ($model->ques1_option as $key => $val) {
                            $name = 'ques_' . $key;
                            $model->bc_feedback_model->$name = 0;
                        }
                        if (isset($model->ques1) and is_array($model->ques1)) {
                            foreach ($model->ques1 as $val) {
                                $name = 'ques_' . $val;
                                $model->bc_feedback_model->$name = 1;
                            }
                        }
                    }
                    if ($model->section == '2') {
                        foreach ($model->ques2_option as $key => $val) {
                            $name = 'ques_' . $key;
                            $model->bc_feedback_model->$name = 0;
                        }
                        if (isset($model->ques2) and is_array($model->ques2)) {
                            foreach ($model->ques2 as $val) {
                                $name = 'ques_' . $val;
                                $model->bc_feedback_model->$name = 1;
                            }
                        }
                    }
                    if ($model->section == '3') {
                        foreach ($model->ques3_option as $key => $val) {
                            $name = 'ques_' . $key;
                            $model->bc_feedback_model->$name = 0;
                        }
                        if (isset($model->ques3) and is_array($model->ques3)) {
                            foreach ($model->ques3 as $val) {
                                $name = 'ques_' . $val;
                                $model->bc_feedback_model->$name = 1;
                            }
                        }
                    }
                    if ($model->section == '4') {
                        foreach ($model->ques4_option as $key => $val) {
                            $name = 'ques_' . $key;
                            $model->bc_feedback_model->$name = 0;
                        }
                        if (isset($model->ques4) and is_array($model->ques4)) {
                            foreach ($model->ques4 as $val) {
                                $name = 'ques_' . $val;
                                $model->bc_feedback_model->$name = 1;
                            }
                        }
                    }
                    if ($model->section == '5') {
                        foreach ($model->ques5_option as $key => $val) {
                            $name = 'ques_' . $key;
                            $model->bc_feedback_model->$name = 0;
                        }
                        if (isset($model->ques5) and is_array($model->ques5)) {
                            foreach ($model->ques5 as $val) {
                                $name = 'ques_' . $val;
                                $model->bc_feedback_model->$name = 1;
                            }
                        }
                    }
                    if ($model->section == '6') {
                        $model->bc_feedback_model->handheld_device = $model->handheld_device;
                        if ($model->bc_feedback_model->handheld_device == 1) {
                            if (isset($model->handheld_device_ques_1)) {
                                $model->bc_feedback_model->handheld_device_ques_1 = $model->handheld_device_ques_1;
                            }
                            if (isset($model->handheld_device_ques_2)) {
                                $model->bc_feedback_model->handheld_device_ques_2 = $model->handheld_device_ques_2;
                            }
                            if (isset($model->handheld_device_ques_3)) {
                                $model->bc_feedback_model->handheld_device_ques_3 = $model->handheld_device_ques_3;
                            }
                            if (isset($model->handheld_device_ques_4)) {
                                $model->bc_feedback_model->handheld_device_ques_4 = $model->handheld_device_ques_4;
                            }
                            if (isset($model->handheld_device_ques_4)) {
                                $model->bc_feedback_model->handheld_device_ques_5 = $model->handheld_device_ques_5;
                            }
                        } else {
                            $model->bc_feedback_model->handheld_device_ques_1 = 0;
                            $model->bc_feedback_model->handheld_device_ques_2 = 0;
                            $model->bc_feedback_model->handheld_device_ques_3 = 0;
                            $model->bc_feedback_model->handheld_device_ques_4 = 0;
                            $model->bc_feedback_model->handheld_device_ques_5 = 0;
                        }
                    }
                    if ($model->section == '7') {
                        $model->bc_feedback_model->fraud_transaction = $model->fraud_transaction;
                        if ($model->bc_feedback_model->fraud_transaction == 1) {
                            if (isset($model->fraud_transaction_ques_1)) {
                                $model->bc_feedback_model->fraud_transaction_ques_1 = $model->fraud_transaction_ques_1;
                            }
                            if (isset($model->fraud_transaction_ques_2)) {
                                $model->bc_feedback_model->fraud_transaction_ques_2 = $model->fraud_transaction_ques_2;
                            }
                            if (isset($model->fraud_transaction_ques_3)) {
                                $model->bc_feedback_model->fraud_transaction_ques_3 = $model->fraud_transaction_ques_3;
                            }
                            if (isset($model->fraud_transaction_ques_4)) {
                                $model->bc_feedback_model->fraud_transaction_ques_4 = $model->fraud_transaction_ques_4;
                            }
                        } else {
                            $model->bc_feedback_model->fraud_transaction_ques_1 = 0;
                            $model->bc_feedback_model->fraud_transaction_ques_2 = 0;
                            $model->bc_feedback_model->fraud_transaction_ques_3 = 0;
                            $model->bc_feedback_model->fraud_transaction_ques_4 = 0;
                        }
                    }

                    if ($model->section == '8') {
                        $model->bc_feedback_model->problems_with_bank = $model->problems_with_bank;
                        if ($model->bc_feedback_model->problems_with_bank == 1) {
                            if (isset($model->problems_with_bank_ques_1)) {
                                $model->bc_feedback_model->problems_with_bank_ques_1 = $model->problems_with_bank_ques_1;
                            }
                            if (isset($model->problems_with_bank_ques_2)) {
                                $model->bc_feedback_model->problems_with_bank_ques_2 = $model->problems_with_bank_ques_2;
                            }
                        } else {
                            $model->bc_feedback_model->problems_with_bank_ques_1 = 0;
                            $model->bc_feedback_model->problems_with_bank_ques_2 = 0;
                        }
                    }
                    if ($model->section == '9') {
                        $model->bc_feedback_model->bc_commissions_payment = $model->bc_commissions_payment;
                        if ($model->bc_feedback_model->bc_commissions_payment == 1) {
                            if (isset($model->bc_commissions_payment_ques_1)) {
                                $model->bc_feedback_model->bc_commissions_payment_ques_1 = $model->bc_commissions_payment_ques_1;
                            }
                            if (isset($model->bc_commissions_payment_ques_2)) {
                                $model->bc_feedback_model->bc_commissions_payment_ques_2 = $model->bc_commissions_payment_ques_2;
                            }
                            if (isset($model->bc_commissions_payment_ques_3)) {
                                $model->bc_feedback_model->bc_commissions_payment_ques_3 = $model->bc_commissions_payment_ques_3;
                            }
                        } else {
                            $model->bc_feedback_model->bc_commissions_payment_ques_1 = 0;
                            $model->bc_feedback_model->bc_commissions_payment_ques_2 = 0;
                            $model->bc_feedback_model->bc_commissions_payment_ques_3 = 0;
                        }
                         $model->bc_feedback_model->status = 1;
                    }
                    $model->bc_feedback_model->section = $model->section;
                    $model->bc_feedback_model->feedback_by = \Yii::$app->user->identity->id;
                    $model->bc_feedback_model->feedback_date = new \yii\db\Expression('NOW()');

                    if ($model->bc_feedback_model->save(false)) {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        \Yii::$app->session->setFlash('success', $this->message);
                        return ['success' => true, 'redirecturl' => '/bc/tracking/feedback?bcid=' . $bc_model->id];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model->bc_feedback_model);
                    }
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {
            $model = new \bc\modules\selection\models\form\BCTrackingFeedbackForm($bc_model);
            $model->scenario = (string) $model->section;
            $model->section_name = $model->section_option[$model->section];

            return $this->render('form', [
                        'model' => $model,
                        'section' => $model->section,
                        'name' => $model->section_name
                            ]
            );
        }
    }
}

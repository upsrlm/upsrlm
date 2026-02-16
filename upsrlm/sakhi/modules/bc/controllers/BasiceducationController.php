<?php

namespace sakhi\modules\bc\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiaryBasicEducationPayment;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiaryBasicEducationPaymentSearch;

/**
 * BasiceducationController for the `bc` module
 */
class BasiceducationController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message;

    public function actionIndex() {
        $searchModel = new DbtBeneficiaryBasicEducationPaymentSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->sort->defaultOrder = ['payment_acknowledge' => SORT_ASC];
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAckpayment($dbt_beneficiary_basic_education_payment_id) {
        $user_model = Yii::$app->user->identity;
        $payment_model = DbtBeneficiaryBasicEducationPayment::findOne($dbt_beneficiary_basic_education_payment_id);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = New \common\models\dynamicdb\cbo_detail\dbt\form\DbtBasicEducationPaymentAcknolegeForm($payment_model);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    if ($model->save()) {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        \Yii::$app->session->setFlash('success', 'जानकारी सफलता पूर्वक प्राप्त हुआ');
                        return ['success' => true];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
                    }
                } else {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {
            $model = New \common\models\dynamicdb\cbo_detail\dbt\form\DbtBasicEducationPaymentAcknolegeForm($payment_model);

            return $this->render('ackpayment', ['model' => $model]);
        }
    }

}

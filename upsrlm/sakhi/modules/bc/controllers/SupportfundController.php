<?php

namespace sakhi\modules\bc\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `bc` module
 */
class SupportfundController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message;

    public function beforeAction($action) {

        Yii::$app->request->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex($bcid) {
        $model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
        $pmodel = \bc\modules\training\models\RsetisBatchParticipants::findOne(['bc_application_id' => $model->id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \bc\modules\selection\models\BcSupportFundReturnShg::find()->where(['bc_application_id'=>$bcid])->orderBy('created_at desc'),
        ]);
        return $this->render('index', ['model' => $model, 'pmodel' => $pmodel,'dataProvider'=>$dataProvider]);
    }

    public function actionSetamount($bcid) {
        $model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model != null) {
                $model->action_type = \bc\modules\selection\models\SrlmBcApplication::ACTION_TYPE_BC_RETURN_AMOUNT;
                if (isset($_POST['hasEditable'])) {
                    $this->message = 'टारगेट सेट सफलतापूर्वक ';
                    $model->bc_return_amount = $_POST['bc_return_amount'];
                    $model->bc_return_amount_date = new \yii\db\Expression('NOW()');

                    if ($model->save()) {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ['output' => $model->bc_return_amount, 'message' => ''];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ['output' => $model->bc_return_amount, 'message' => ''];
                    }
                } else {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
        }
    }

    public function actionSetrepay($bc_amount_repay, $bcid) {
        $model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model != null) {
                $model->action_type = \bc\modules\selection\models\SrlmBcApplication::ACTION_TYPE_BC_REPAY_TYPE;
                $this->message = 'टारगेट सेट सफलतापूर्वक ';
                $model->bc_amount_repay = $bc_amount_repay;
                if ($model->save()) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['output' => $model->bc_amount_repay, 'message' => ''];
                } else {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['output' => $model->bc_amount_repay, 'message' => ''];
                }
            }
        }
    }

    public function actionReport($bcid) {
        $user_model = Yii::$app->user->identity;
        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = New \bc\modules\selection\models\form\BCReturnFund($bc_model);

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
            $model = New \bc\modules\selection\models\form\BCReturnFund($bc_model);
            return $this->render('report', ['model' => $model]);
        }
    }

}

<?php

namespace sakhi\modules\shg\controllers;

use Yii;
use yii\web\Controller;
use common\models\dynamicdb\cbo_detail\RishtaShg;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;

/**
 * Funds controller for the `shg` module
 */
class FundsController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * All Fund Status
     *
     * @param [type] $shgid
     * @return void
     */
    public function actionIndex($shgid) {
        $shg_model = \common\models\dynamicdb\cbo_detail\RishtaShgProfile::find()->where(['cbo_shg_id' => $shgid])->one();
        $fundtypes = \common\models\base\GenralModel::rishta_funds_type_option('shg');

        return $this->render('index', [
                    'fundtypes' => $fundtypes,
                    'shg_model' => $shg_model
        ]);
    }

    /**
     * All Funds Listing
     *
     * @param [type] $shgid
     * @param [type] $fund_id
     * @return void
     */
    public function actionFundlist($shgid, $fund_id) {
        $shg_model = \common\models\dynamicdb\cbo_detail\RishtaShgProfile::find()->where(['cbo_shg_id' => $shgid])->one();
        $fundtype = \common\models\dynamicdb\cbo_detail\master\CboMasterFundtype::find()->where(['id' => $fund_id])->one();

        $dataProvider = new ActiveDataProvider([
            'query' => \common\models\dynamicdb\cbo_detail\RishtaShgFundReceived::find()->where(['cbo_shg_id' => $shgid, 'fund_type' => $fund_id, 'status' => 1]),
            'pagination' => false,
        ]);
        $total_amount_received = \common\models\dynamicdb\cbo_detail\RishtaShgFundReceived::find()->where(['cbo_shg_id' => $shgid, 'fund_type' => $fund_id, 'status' => 1])->Sum('amount_received');
        $number_of_ammount_received = \common\models\dynamicdb\cbo_detail\RishtaShgFundReceived::find()->where(['cbo_shg_id' => $shgid, 'fund_type' => $fund_id, 'status' => 1])->count();

        return $this->render('fundlist', [
                    'models' => $dataProvider->getModels(),
                    'shg_model' => $shg_model,
                    'fundtype' => $fundtype,
                    'total_amount_received' => $total_amount_received,
                    'number_of_ammount_received' => $number_of_ammount_received
        ]);
    }

    /**
     * Fund Create and Update
     *
     * @param [type] $shgid
     * @param [type] $fundid
     * @return void
     */
    public function actionUpdate($shgid, $shg_fund_received_id = null, $fund_type) {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgFundReceivedForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {

                    $fund_status_model = \common\models\dynamicdb\cbo_detail\RishtaShgFundReceived::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'id' => $model->shg_fund_received_id])->one();
                    if ($fund_status_model) {
                        $model->shg_fund_received_model = $fund_status_model;
                    } else {
                        $model->shg_fund_received_model = new \common\models\dynamicdb\cbo_detail\RishtaShgFundReceived();
                    }

                    $model->shg_fund_received_model->cbo_shg_id = $model->cbo_shg_id;
                    $model->shg_fund_received_model->fund_type = $model->fund_type;
                    $model->shg_fund_received_model->received_from = $model->received_from;
                    $model->shg_fund_received_model->date_of_receipt = $model->date_of_receipt;
                    $model->shg_fund_received_model->amount_received = $model->amount_received;
                    if ($model->shg_fund_received_model->save()) {
                        Yii::$app->session->setFlash('success', 'डेटा सफलतापूर्वक सहेजा गया');
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model->shg_fund_received_model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $fund_status_model = \common\models\dynamicdb\cbo_detail\RishtaShgFundReceived::find()->where(['cbo_shg_id' => $shgid, 'id' => $shg_fund_received_id])->one();
            if ($fund_status_model) {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgFundReceivedForm($fund_status_model);
            } else {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgFundReceivedForm();
            }
            $model->shg_fund_received_model->fund_type = $model->fund_type = $fund_type;
            $model->cbo_shg_id = $shgid;
            $model->shg_fund_received_id = $shg_fund_received_id;

            return $this->render('update', ['model' => $model]);
        }
    }

}

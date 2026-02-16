<?php

namespace sakhi\modules\shg\controllers;

use Yii;
use cbo\models\Shg;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\helpers\FileHelpers;
use yii\data\ActiveDataProvider;
use cbo\models\form\ShgVerifyCSTForm;
use cbo\models\CboMasterMemberDesignation;
use common\models\dynamicdb\cbo_detail\RishtaShg;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryHousehold;
use common\models\dynamicdb\cbo_detail\dbt\form\DbtBeneficiaryMemberForm;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnrega;
use common\models\dynamicdb\cbo_detail\dbt\form\DbtBeneficiarySchemeMgnregaForm;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaApplicant;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaDaFtoAcknowledge;

/**
 * MgnregaController controller for the `shg` module
 */
class MgnregaController extends Controller {

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

    public function actionAckpayment($shgid,$da_member_fto_ack_id) {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $ack_model = $this->findModel($da_member_fto_ack_id);
            $model = new \common\models\dynamicdb\cbo_detail\dbt\form\DbtMgnregaFtoAcknolegeForm($ack_model);
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $model->fto_ack_model->work_start_date = $model->work_start_date;
                    $model->fto_ack_model->work_end_date = $model->work_end_date;
                    $model->fto_ack_model->laborer_wages_were_paid = $model->laborer_wages_were_paid;
                    $model->fto_ack_model->total_wage_liability = $model->total_wage_liability;
                    $model->fto_ack_model->wages_received_by_the_worker = $model->wages_received_by_the_worker;
                    $model->fto_ack_model->date_of_receipt_of_wages = $model->date_of_receipt_of_wages;
                    $model->fto_ack_model->feed_did_you_get_your_wages_ontime = $model->feed_did_you_get_your_wages_ontime;
                    $model->fto_ack_model->feed_whether_wages_were_cut_in_any_way = $model->feed_whether_wages_were_cut_in_any_way;
                    $model->fto_ack_model->feed_bank_bc_delayed_discouraged_withdrawal_wages = $model->feed_bank_bc_delayed_discouraged_withdrawal_wages;

                    $model->fto_ack_model->feed_someone_wrongly_ask_money_commission = $model->feed_someone_wrongly_ask_money_commission;
                    $model->fto_ack_model->feed_misbehaved_gp_nrega_official_employee = $model->feed_misbehaved_gp_nrega_official_employee;
                    $model->fto_ack_model->feed_satisfied_behavior_officers_associated_nrega = $model->feed_satisfied_behavior_officers_associated_nrega;

                    $model->fto_ack_model->fto_acknowledge_by = \Yii::$app->user->identity->id;
                    $model->fto_ack_model->fto_acknowledge_datetime = new \yii\db\Expression('NOW()');
                    $model->fto_ack_model->status = 1;
                    if ($model->fto_ack_model->save()) {
                        Yii::$app->session->setFlash('success', 'डेटा सफलतापूर्वक सहेजा गया');
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $ack_model = $this->findModel($da_member_fto_ack_id);
            $model = new \common\models\dynamicdb\cbo_detail\dbt\form\DbtMgnregaFtoAcknolegeForm($ack_model);

            return $this->render('fto_acknoleg_form', ['model' => $model]);
        }
    }

    /**
     * Find SHG Model
     *
     * @param [type] $id
     * @return void
     */
    protected function findModel($id) {
        if (($model = DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

}

<?php

namespace sakhi\modules\shg\controllers;

use Yii;
use yii\web\Controller;
use common\models\dynamicdb\cbo_detail\RishtaShg;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use common\helpers\FileHelpers;

/**
 * Bank List controller for the `shg` module
 */
class BankaccountController extends Controller {

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
     * Attcahed Bank List of SHG 
     *
     * @param [type] $shgid
     * @return void
     */
    public function actionIndex($shgid) {

        $dataProvider = new ActiveDataProvider([
            'query' => \common\models\dynamicdb\cbo_detail\RishtaShgBankDetail::find()->where(['cbo_shg_id' => $shgid, 'status' => 1]),
            'pagination' => false,
        ]);
        $totalbank = $dataProvider->getTotalCount();

        return $this->render('index', ['dataProvider' => $dataProvider,
                    'shgid' => $shgid,
                    'totalbank' => $totalbank]);
    }

    /**
     * Add/Update Bank Detail
     *
     * @param [type] $shgid
     * @param [type] $shg_bank_id
     * @return void
     */
    public function actionUpdate($shgid, $shg_bank_id = null) {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgBankDetailForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $bank_detail_model = \common\models\dynamicdb\cbo_detail\RishtaShgBankDetail::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'id' => $model->shg_bank_id, 'status' => 1])->one();
                    if ($bank_detail_model) {
                        $model->shg_bank_detail_model = $bank_detail_model;
                    } else {
                        $model->shg_bank_detail_model = new \common\models\dynamicdb\cbo_detail\RishtaShgBankDetail();
                    }

                    $model->shg_bank_detail_model->cbo_shg_id = $model->cbo_shg_id;
                    $model->shg_bank_detail_model->bank_id = $model->bank_id;
                    $model->shg_bank_detail_model->branch = $model->branch;
                    $model->shg_bank_detail_model->branch_code_or_ifsc = $model->branch_code_or_ifsc;
                    $model->shg_bank_detail_model->bank_account_no_of_the_shg = $model->bank_account_no_of_the_shg;
                    $model->shg_bank_detail_model->balance_as_on_date = $model->balance_as_on_date;
                    $model->shg_bank_detail_model->date_of_opening_the_bank_account = $model->date_of_opening_the_bank_account;
                    $model->shg_bank_detail_model->bank_balance_date = isset($model->bank_balance_date) ? $model->bank_balance_date : date('Y-m-d H:i:s');
                    $model->shg_bank_detail_model->name_of_bank = $model->shg_bank_detail_model->bank->bank_name;

                    // Bank Statement Upload 
                    $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['datapath'];

                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo')) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo');
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo', 0777);
                    }
                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg')) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg');
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg', 0777);
                    }
                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $model->cbo_shg_id)) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $model->cbo_shg_id);
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $model->cbo_shg_id, 0777);
                    }

                    if (isset(\Yii::$app->request->post()['bankstatement']) and \Yii::$app->request->post()['bankstatement']) {
                        $content = base64_decode(\Yii::$app->request->post()['bankstatement']);
                        $im = imagecreatefromstring($content);
                        $image_name = 'bankstatement_' . uniqid() . '.jpg';

                        if ($im !== false) {
                            header('Content-Type: image/jpeg');
                            imagejpeg($im, $APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $model->cbo_shg_id . '/' . $image_name);
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $model->cbo_shg_id . '/' . $image_name, 0777);
                            $model->shg_bank_detail_model->passbook_photo = $image_name;
                            $file = new FileHelpers();
                            $file->file_path = $APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $model->cbo_shg_id;
                            $file->file_name = $image_name;
                            $file->upload();
                            imagedestroy($im);
                        }
//                        $photo_1_path = Yii::$app->params['datapath'] . "tmp/" . \Yii::$app->request->post()['bankstatement'];
//                        if (file_exists($photo_1_path) && is_file($photo_1_path)) {
//                            $ext = pathinfo($photo_1_path, PATHINFO_EXTENSION);
//                            $image_name1 = 'bankstatement_' . uniqid() . '.' . $ext;
//         
//                            if (copy($photo_1_path, $APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $model->cbo_shg_id . '/' . $image_name1)) {
//                                $model->shg_bank_detail_model->passbook_photo = $image_name;
//                                chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $model->cbo_shg_id . '/' . $image_name1, 0777);
//
//                                $file = new FileHelpers();
//                                $file->file_path = $APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $model->cbo_shg_id;
//                                $file->file_name = $image_name1;
//                                $file->upload();
//                                unlink($photo_1_path);
//                            }
//                        }
                    }

                    // End


                    if ($model->shg_bank_detail_model->save()) {
                        Yii::$app->session->setFlash('success', 'डेटा सफलतापूर्वक सहेजा गया');
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model->shg_bank_detail_model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $bank_detail_model = \common\models\dynamicdb\cbo_detail\RishtaShgBankDetail::find()->where(['cbo_shg_id' => $shgid, 'id' => $shg_bank_id, 'status' => 1])->one();

            if ($bank_detail_model) {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgBankDetailForm($bank_detail_model);
            } else {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgBankDetailForm();
            }
            $model->cbo_shg_id = $shgid;
            $model->shg_bank_id = $shg_bank_id;

            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * Remove Bank
     *
     * @param [type] $shgid
     * @param [type] $shg_bank_id
     * @return void
     */
    public function actionRemove() {
        if (Yii::$app->request->isAjax) {
            if (isset($_REQUEST['removeRequest']) && $_REQUEST['removeRequest'] == "1") {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $shgid = $_REQUEST['shgid'];
                $shg_bank_id = $_REQUEST['shg_bank_id'];
                $bank_detail_model = \common\models\dynamicdb\cbo_detail\RishtaShgBankDetail::find()->where(['cbo_shg_id' => $shgid, 'id' => $shg_bank_id])->one();
                $bank_detail_model->status = -1;
                if ($bank_detail_model->save()) {
                    Yii::$app->session->setFlash('success', 'Bank Account Removed Successfully');
                    return ['success' => true];
                }
            }
        }
    }

    /**
     * Get Bank Passbook Image
     *
     * @param [type] $shgid
     * @param [type] $path
     * @return void
     */
    public function actionBankpassbook($shgid, $path) {
        if (file_exists(\Yii::$app->params['datapath'] . 'cbo/shg/' . $shgid . '/' . $path)) {
            Yii::$app->response->sendFile(\Yii::$app->params['datapath'] . 'cbo/shg/' . $shgid . '/' . $path);
        } else {
            return '';
        }
    }

}

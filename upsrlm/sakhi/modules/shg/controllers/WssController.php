<?php

namespace sakhi\modules\shg\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use common\models\dynamicdb\cbo_detail\RishtaShg;
use sakhi\components\paytm\PaytmConfig;
use sakhi\components\paytm\PaytmChecksum;
use common\helpers\FileHelpers;

/**
 * WssController for the `shg` module
 */
class WssController extends Controller {

    public function beforeAction($action) {

        Yii::$app->request->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'makepayment' => ['POST'],
                ],
            ],
        ];
    }

    public function actionBank($shgid, $wadaid) {
        $wada_model = $this->findModel($wadaid);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\wada\form\WssBankForm($wada_model);
            $model->scenario = 'bank';
            $model->cbo_shg_id = $shgid;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {

                    $this->message = 'बैंक विवरण सूचना जानकारी सफलता पूर्वक प्राप्त हुआ';
                    $model->wada_model->bank_account_no = $model->bank_account_no;
                    $model->wada_model->bank_id = $model->bank_id;
                    $model->wada_model->branch = $model->branch;
                    $model->wada_model->branch_code_or_ifsc = $model->branch_code_or_ifsc;
                    if ($model->wada_model->bank_account_no) {
                        $model->wada_model->wada_bank = 1;
                    }
                    $model->wada_model->verify_wada_passbook_photo = 0;
                    $model->wada_model->verify_wada_passbook_not = 0;
                    $model->wada_model->verify_wada_bank_account_no = 0;
                    $model->wada_model->verify_wada_branch_code_or_ifsc = 0;
                    $model->wada_model->verify_wada_ifsc_code_entered = 0;
                    $model->wada_model->verify_wada_other = 0;
                    $model->wada_model->verify_wada_other_reason = null;

                    $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['datapath'];
                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo')) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo');
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo', 0777);
                    }
                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member')) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member');
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member', 0777);
                    }
                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->wada_model->folder_prefix)) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->wada_model->folder_prefix);
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->wada_model->folder_prefix, 0777);
                    }

                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->wada_model->folder_prefix . '/' . $model->wada_model->user_id)) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->wada_model->folder_prefix . '/' . $model->wada_model->user_id);
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->wada_model->folder_prefix . '/' . $model->wada_model->user_id, 0777);
                    }
                    $APPLICATION_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->wada_model->folder_prefix . '/' . $model->wada_model->user_id;
                    if (isset(\Yii::$app->request->post()['WssBankForm']['passbook_photo']) and \Yii::$app->request->post()['WssBankForm']['passbook_photo']) {
                        $content4 = base64_decode(\Yii::$app->request->post()['WssBankForm']['passbook_photo']);
                        $im4 = imagecreatefromstring($content4);
                        $image_name4 = 'passbook_photo_' . uniqid() . '.jpg';
                        $model->wada_model->passbook_photo = $image_name4;
                        if ($im4 !== false) {
                            header('Content-Type: image/jpeg');
                            imagejpeg($im4, $APPLICATION_FILE_FOLDER . '/' . $image_name4);
                            chmod($APPLICATION_FILE_FOLDER . '/' . $image_name4, 0777);
                            $file = new FileHelpers();
                            $file->file_path = $APPLICATION_FILE_FOLDER;
                            $file->file_name = $image_name4;
                            $file->upload();
                            imagedestroy($im4);
                        }
                    }
                    $model->wada_model->action_type = \common\models\wada\WadaApplication::ACTION_TYPE_WADA_BANK_UPLOAD;
                    if ($model->wada_model->save()) {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        \Yii::$app->session->setFlash('success', $this->message);
                        return ['success' => true, 'message' => 'बैंक विवरण सूचना जानकारी सफलता पूर्वक प्राप्त हुआ', 'webview' => false];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model->wada_model);
                    }
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {
            $wada_model = $this->findModel($wadaid);
            $model = new \common\models\wada\form\WssBankForm($wada_model);
            $model->scenario = 'bank';
            $model->cbo_shg_id = $shgid;
            return $this->render('bank', ['model' => $model]);
        }
    }

    protected function findModel($id) {
        if (($model = \common\models\wada\WadaApplication::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

}

<?php

namespace sakhi\modules\bc\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `bc` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message;
    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionView($bcid) {
        $model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
        $pmodel = \bc\modules\training\models\RsetisBatchParticipants::findOne(['bc_application_id' => $model->id]);

//        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummarySearch();
//        $searchModel->bc_application_id = $model->id;
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        return $this->render('view', ['model' => $model, 'pmodel' => $pmodel]);
    }

    public function actionPan($bcid) {
        $model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
        if (\Yii::$app->request->post()) {
            $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['bcdatapath'];
            $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";

            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $model->srlm_bc_selection_user_id)) {
                mkdir($APPLICATION_FORM_FILE_FOLDER . $model->srlm_bc_selection_user_id);
                chmod($APPLICATION_FORM_FILE_FOLDER . $model->srlm_bc_selection_user_id, 0777);
            }
            if (isset(\Yii::$app->request->post()['pan']) and \Yii::$app->request->post()['pan'])
                $content = base64_decode(\Yii::$app->request->post()['pan']);
            $im = imagecreatefromstring($content);
            $image_name = 'pan_' . uniqid() . '.jpg';
            $model->pan_photo_upload = 1;
            $model->pan_photo = $image_name;
            $model->pan_photo_date = new \yii\db\Expression('NOW()');
            if (isset(Yii::$app->user->identity->id))
                $model->pan_photo_by = \Yii::$app->user->identity->id;
            if ($im !== false) {
                header('Content-Type: image/jpeg');
                imagejpeg($im, $APPLICATION_FORM_FILE_FOLDER . $model->srlm_bc_selection_user_id . '/' . $image_name);
                $model->update();
                imagedestroy($im);
                \Yii::$app->getSession()->setFlash('success', 'पैन कार्ड फोटो अपलोड सफलतापूर्वक ');
                return $this->redirect(['/bc/default/view?bcid=' . $bcid]);
            }
        }
        return $this->render('pan', ['model' => $model]);
    }

    public function actionAcksaree($bcid, $saree) {
        $user_model = Yii::$app->user->identity;
        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = New \bc\modules\selection\models\form\BCSareeAckForm($bc_model);
            $model->saree = $saree;
            $model->scenario = $saree;
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
            $model = New \bc\modules\selection\models\form\BCSareeAckForm($bc_model);
            $model->saree = $saree;
            $model->scenario = $saree;
            return $this->render('ack_saree', ['model' => $model]);
        }
    }

    public function actionAckpayment($bcid, $month) {
        $user_model = Yii::$app->user->identity;
        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = New \bc\modules\selection\models\form\BCPaymenAckForm($bc_model);
            $model->month = $month;
            $model->scenario = $month;
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
            $model = New \bc\modules\selection\models\form\BCPaymenAckForm($bc_model);
            $model->month = $month;
            $model->scenario = $month;
            return $this->render('ack_payment', ['model' => $model]);
        }
    }

    public function actionAssociate($bcid) {
        $user_model = Yii::$app->user->identity;
        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
        return $this->render('field_associate', ['bc_model' => $bc_model]);
    }

//    public function actionFeedback($bcid) {
//        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
//        return $this->redirect(['/bc/default/view?bcid=' . $bcid]);
//        $user_model = \common\models\User::findOne($bc_model->user_id);
//        $model = new \common\models\form\CboBCFeedbackForm($user_model);
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
//            \Yii::$app->getSession()->setFlash('success', 'फ़ीडबैक सफलतापूर्वक सहेजा गया ');
//            return $this->redirect(['/bc/default/view?bcid=' . $bcid]);
//        }
//        return $this->render('feedback', ['model' => $model]);
//    }
    public function actionUnwilling($bcid) {
        $user_model = Yii::$app->user->identity;
        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             $model = New \bc\modules\selection\models\form\UnwillingBCNewForm($bc_model);
             $model->bc_model = $bc_model;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    if ($model->save()) {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        \Yii::$app->session->setFlash('success', 'जानकारी सफलता पूर्वक प्राप्त हुआ');
                        $redirect_url = '/bc/default/unwilling?bcid=' . $bc_model->id ;
                            return ['success' => true, 'redirecturl' => $redirect_url];
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
            $model = New \bc\modules\selection\models\form\UnwillingBCNewForm($bc_model);
            $model->bc_model = $bc_model;
            return $this->render('bc_unwilling', ['model' => $model]);
        }
    }
}

<?php

namespace sakhi\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller {

    public $message = '';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($userid) {
        $model = Yii::$app->user->identity;

        return $this->render('view', ['model' => $model]);
    }

    public function actionChangepin($userid) {
        $user_model = Yii::$app->user->identity;
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\form\RishtaChangePinForm($user_model);
            $model->userid = $user_model->id;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {

                    $this->message = 'पिन परिवर्तन सफलतापूर्वक ';
                    $model->user->otp_value = $model->new_pin;
                    $model->user->action_type = 2;
                    if ($model->user->save()) {
                        if (isset($model->user->cboprofile) and $model->user->cboprofile->bc) {
                            $condition = ['and',
                                ['=', 'mobile_no', $model->user->username],
                            ];

                            \bc\modules\selection\models\SrlmBcSelectionUser::updateAll([
                                'pin' => $model->new_pin,
                                    ], $condition);
                        }
                        $app_detail_model = \common\models\AppDetail::findOne(['user_id' => $model->userid, 'status' => 1]);
                        if ($app_detail_model != null) {
                            $app_detail_model->status = 0;
                            $app_detail_model->date_of_uninstall = new \yii\db\Expression('NOW()');
                            $app_detail_model->save();
                        }
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        \Yii::$app->session->setFlash('success', $this->message);
                        return ['success' => true, 'message' => 'पिन परिवर्तन सफलतापूर्वक ', 'webview' => false];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model->user);
                    }
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {
            $model = new \common\models\form\RishtaChangePinForm($user_model);
            $model->userid = $user_model->id;
            return $this->render('changepin', ['model' => $model]);
        }
    }

    public function actionTempimg($file) {
        $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['datapath'];
        $photo = Yii::$app->params['datapath'] . "tmp/" . $file;
        if (file_exists($photo) && is_file($photo)) {
            $ext = pathinfo($photo, PATHINFO_EXTENSION);
            switch ($ext) {
                case 'jpg':
                    $mimetype = "image/jpg";
                    break;
                case 'jpeg':
                    $mimetype = "image/jpeg";
                    break;
                case 'gif':
                    $mimetype = "image/gif";
                    break;
                case 'png':
                    $mimetype = "image/png";
                    break;
                case 'bm':
                    $mimetype = "image/bmp";
                    break;
                case 'bmp':
                    $mimetype = "image/bmp";
                    break;
                default:
                    $mimetype = "application/octet-stream";
            }
            return Yii::$app->response->sendFile($photo);
            die();
        } else {
            throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
        }
    }

}

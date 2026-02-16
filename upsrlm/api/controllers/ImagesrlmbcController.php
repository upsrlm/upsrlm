<?php

namespace api\controllers;

use Yii;
use bc\modules\selection\models\SrlmBcSelectionApiLog as ApiLog;
use bc\modules\selection\models\SrlmBcSelectionAppDetail as AppDetail;
use bc\modules\selection\models\SrlmBcSelectionUser as AppUser;

class ImagesrlmbcController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['image1', 'shg', 'imageasso'],
                'rules' => [
                    [
                        'actions' => ['image1', 'shg', 'imageasso'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
        ];
    }

    public function actionImage1($app_id, $photo, $token) {

        $model_app = AppDetail::find()->where(['id' => $app_id])->one();
        $token = explode('.', $token);
        if (isset($token[1]) and strtotime($token[1]) == strtotime(date('d-m-Y'))) {
            if (!empty($model_app)) {
                $app_user = AppUser::findOne($model_app->srlm_bc_selection_user_id);
                $photo_name = $photo;
                $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
                $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";
                if ($photo_name == 'passbook_photo_shg') {
                    $photo = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/shg/" . $app_user->bcsapplication->$photo_name;
                } else {
                    if (isset($app_user->bcsapplication)) {
                        $photo = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/" . $app_user->bcsapplication->$photo_name;
                    } else {
                        $photo = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/" . $app_user->$photo_name;
                    }
                }
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
                    //ob_end_flush();
                    //header("Content-type: $mimetype");
                    //return Yii::$app->response->sendFile(readfile($photo));
                    return Yii::$app->response->sendFile($photo);
                    die();
                } else {
                    throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
                }
            } else {
                throw new \yii\web\ConflictHttpException("App is not active");
            }
        } else {
            throw new \yii\web\ForbiddenHttpException("Forbidden - User Disabled.");
        }
    }

    public function actionImageasso($id, $photo, $token) {

        $model = \bc\models\PartnerAssociates::find()->where(['id' => $id])->one();
        $token = explode('.', $token);
        if (isset($token[1]) and strtotime($token[1]) == strtotime(date('d-m-Y'))) {
            if (!empty($model)) {

                $photo_name = $photo;
                $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['datapath'];
                $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "partneragencies/associates/";

                $photo = $APPLICATION_FORM_FILE_FOLDER . $model->id . "/" . $model->$photo_name;

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
                    //ob_end_flush();
                    //header("Content-type: $mimetype");
                    //return Yii::$app->response->sendFile(readfile($photo));
                    return Yii::$app->response->sendFile($photo);
                    die();
                } else {
                    throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
                }
            } else {
                throw new \yii\web\ConflictHttpException("App is not active");
            }
        } else {
            throw new \yii\web\ForbiddenHttpException("Forbidden - User Disabled.");
        }
    }

    public function actionShg($app_id, $photo, $token) {

        $model_app = AppDetail::find()->where(['id' => $app_id])->one();
        $token = explode('.', $token);
        if (isset($token[1]) and strtotime($token[1]) == strtotime(date('d-m-Y'))) {
            if (!empty($model_app)) {
                $app_user = AppUser::findOne($model_app->srlm_bc_selection_user_id);
                $photo_name = $photo;
                $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['datapath'];
                $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "cbo/shg/";
                if (isset($app_user->bcsapplication->cbo_shg_id)) {
                    $shg_model = \cbo\models\Shg::findOne($app_user->bcsapplication->cbo_shg_id);
                    $photo = $APPLICATION_FORM_FILE_FOLDER . $shg_model->id . "/" . $shg_model->$photo_name;

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
                        //ob_end_flush();
                        //header("Content-type: $mimetype");
                        //return Yii::$app->response->sendFile(readfile($photo));
                        return Yii::$app->response->sendFile($photo);
                        die();
                    } else {
                        throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
                    }
                }
            } else {
                throw new \yii\web\ConflictHttpException("App is not active");
            }
        } else {
            throw new \yii\web\ForbiddenHttpException("Forbidden - User Disabled.");
        }
    }

}

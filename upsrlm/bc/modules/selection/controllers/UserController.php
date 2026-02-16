<?php

namespace bc\modules\selection\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use yii\web\Controller;
use bc\modules\selection\models\SrlmBcSelectionApiLog as ApiLog;
use bc\modules\selection\models\SrlmBcSelectionAppDetail as AppDetail;
use bc\modules\selection\models\SrlmBcSelectionUser as AppUser;
use bc\modules\selection\models\form\UploadPhotoForm;

/**
 * User controller for the `api` module
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UserController extends Controller {

    public function actionGetphoto($user_id, $photo_name) {

        $photo_name = $photo_name;
        $app_user = AppUser::findOne($user_id);
        $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['datapath'];
        $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "srlm/bcselection/photo/";
        $photo = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/" . $app_user->$photo_name;
        setlocale(LC_ALL, 'en_US.UTF-8');
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

//            $app->response->format = \yii\web\Response::FORMAT_RAW;
            ob_end_flush();
            header("Content-type: $mimetype");
            //header('Content-Disposition', 'attachment; filename="' . $model->$col . '"');

            return Yii::$app->response->sendFile(readfile($photo));

            die();
        } else {
//            throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
        }
    }

}

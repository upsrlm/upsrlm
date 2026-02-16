<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\components\Appcheck;
use common\models\master\MasterRole;

/**
 * MopupappController
 */
class MopupappController extends Controller {

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $url="https://play.google.com/store/apps/details?id=com.triline.upsrlm.mopup";  
        return $this->redirect($url);     exit();
//        $file_path=Yii::getAlias('@mopup/web').'/app/app-mopup-release.apk';
//        $file_name='app-mopup-release.apk';
//        header('Content-Type: application/vnd.android.package-archive');
//        header("Content-length: " . filesize($file_path));
//        header('Content-Disposition: attachment; filename="' . $file_name . '"');
//        ob_end_flush();
//        readfile($file_path);exit;
        return $this->render('index');
    }

}

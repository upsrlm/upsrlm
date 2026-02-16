<?php

namespace sakhi\modules\shg\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use common\models\dynamicdb\cbo_detail\RishtaShg;

class FeedbackController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    /**
     * Profile Index Page of SHG
     *
     * @param [type] $shgid
     * @return void
     */
    public function actionForm($shgid) {
        if (Yii::$app->request->isAjax) {
            $shg_model = $this->findModel($shgid);
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgFeedbackForm($shg_model);
            $model->scenario = 'first';
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    if ($model->save()) {
                       \Yii::$app->session->setFlash('success', "फ़ीडबैक सफलतापूर्वक सहेजा गया "); 
                       return ['success' => true,'message'=>'फ़ीडबैक सफलतापूर्वक सहेजा गया','webview'=>false];
                    }
                }
            }
        } else {
            $shg_model = $this->findModel($shgid);
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgFeedbackForm($shg_model);
            $model->cbo_shg_id = $shgid;

            return $this->render('form', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Update SHG Profile
     *
     * @param [type] $shgid
     * @return void
     */
    public function actionView($shgid) {
        return $this->render('view', ['model' => $model, 'shg_model' => $shg_model]);
    }

    protected function findModel($id) {
        if (($model = RishtaShg::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

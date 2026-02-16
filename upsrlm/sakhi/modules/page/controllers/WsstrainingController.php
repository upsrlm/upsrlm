<?php

namespace sakhi\modules\page\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\helpers\FileHelpers;
use yii\data\ActiveDataProvider;
/**
 * Default controller for the `page` module
 */
class WsstrainingController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function actionDepartment() {
        return $this->render('department');
    }

    public function actionBocwLabour() {
        return $this->render('bocw-labour');
    }

    public function actionBocwScheme1() {
        return $this->render('bocw-scheme1');
    }

    public function actionBocwScheme2() {
        return $this->render('bocw-scheme2');
    }

    public function actionBocwScheme3() {
        return $this->render('bocw-scheme3');
    }

    public function actionRd() {
        return $this->render('rd');
    }

    public function actionRdMgnrega() {
        return $this->render('rd-mgnrega');
    }

    public function actionRdMgnregaFeedback() {
        if (Yii::$app->request->isAjax) {
            $model = new \common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\form\DbtSchemeMgnreaFeedbackForm(Yii::$app->user->identity->id);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    if ($model->save()) {
                        \Yii::$app->session->setFlash('success', "फ़ीडबैक सफलतापूर्वक सहेजा गया ");
                        return ['success' => true, 'message' => 'फ़ीडबैक सफलतापूर्वक सहेजा गया'];
                    } else {
                        return ActiveForm::validate($model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $model = new \common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\form\DbtSchemeMgnreaFeedbackForm(Yii::$app->user->identity->id);
            $model->user_id = Yii::$app->user->identity->id;

            return $this->render('rd-mgnrega-feedback', [
                        'model' => $model,
            ]);
        }
    }
    public function actionBocwMaternityFeedback() {
        if (Yii::$app->request->isAjax) {
            $model = new \common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\form\DbtSchemeBocwMaternityFeedbackForm(Yii::$app->user->identity->id);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    if ($model->save()) {
                        \Yii::$app->session->setFlash('success', "फ़ीडबैक सफलतापूर्वक सहेजा गया ");
                        return ['success' => true, 'message' => 'फ़ीडबैक सफलतापूर्वक सहेजा गया'];
                    } else {
                        return ActiveForm::validate($model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $model = new \common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\form\DbtSchemeBocwMaternityFeedbackForm(Yii::$app->user->identity->id);
            $model->user_id = Yii::$app->user->identity->id;

            return $this->render('bocw-maternity-feedback', [
                        'model' => $model,
            ]);
        }
    }
     public function actionBocwConstructionFeedback() {
        if (Yii::$app->request->isAjax) {
            $model = new \common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\form\DbtSchemeBocwConstructionFeedbackForm(Yii::$app->user->identity->id);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    if ($model->save()) {
                        \Yii::$app->session->setFlash('success', "फ़ीडबैक सफलतापूर्वक सहेजा गया ");
                        return ['success' => true, 'message' => 'फ़ीडबैक सफलतापूर्वक सहेजा गया'];
                    } else {
                        return ActiveForm::validate($model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $model = new \common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\form\DbtSchemeBocwConstructionFeedbackForm(Yii::$app->user->identity->id);
            $model->user_id = Yii::$app->user->identity->id;

            return $this->render('bocw-construction-feedback', [
                        'model' => $model,
            ]);
        }
    }
    public function actionBocwSantravidasFeedback() {
        if (Yii::$app->request->isAjax) {
            $model = new \common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\form\DbtSchemeBocwSantravidasFeedbackForm(Yii::$app->user->identity->id);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    if ($model->save()) {
                        \Yii::$app->session->setFlash('success', "फ़ीडबैक सफलतापूर्वक सहेजा गया ");
                        return ['success' => true, 'message' => 'फ़ीडबैक सफलतापूर्वक सहेजा गया'];
                    } else {
                        return ActiveForm::validate($model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $model = new \common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\form\DbtSchemeBocwSantravidasFeedbackForm(Yii::$app->user->identity->id);
            $model->user_id = Yii::$app->user->identity->id;

            return $this->render('bocw-santravidas-feedback', [
                        'model' => $model,
            ]);
        }
    }
}

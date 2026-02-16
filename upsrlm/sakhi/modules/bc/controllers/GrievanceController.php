<?php

namespace sakhi\modules\bc\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `bc` module
 */
class GrievanceController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message;

    public function beforeAction($action) {

        Yii::$app->request->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex($bcid) {
        $model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);

        return $this->render('index', ['model' => $model]);
    }

    public function actionReport($bcid, $group) {
        $user_model = Yii::$app->user->identity;
        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = New \bc\modules\selection\models\form\BcGrievanceForm($bc_model);
            $model->scenario = $group;
            $model->group = $group;
            if (isset($model->group_option[$model->group])) {
                $model->title = $model->group_option[$model->group];
            }
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
            $model = New \bc\modules\selection\models\form\BcGrievanceForm($bc_model);
            $model->scenario = $group;
            $model->group = $group;
            if (isset($model->group_option[$model->group])) {
                $model->title = $model->group_option[$model->group];
            }
            return $this->render('report', ['model' => $model]);
        }
    }

}

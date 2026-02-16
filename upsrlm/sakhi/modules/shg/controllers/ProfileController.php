<?php

namespace sakhi\modules\shg\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;

/**
 * Profile controller for the `shg` module
 */
class ProfileController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';


    /**
     * Profile Index Page of SHG
     *
     * @param [type] $shgid
     * @return void
     */
    public function actionIndex($shgid) {

        $model = \common\models\dynamicdb\cbo_detail\RishtaShgProfile::find()->where(['cbo_shg_id'=>$shgid])->one();
        if(isset($model)){
            return $this->render('index', ['model' => $model]);
        }
    }


    /**
     * Update SHG Profile
     *
     * @param [type] $shgid
     * @return void
     */
    public function actionUpdate($shgid) {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgProfileForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {

                    $profile_model = \common\models\dynamicdb\cbo_detail\RishtaShgProfile::find()->where(['cbo_shg_id' => $model->cbo_shg_id])->one();
                    if ($profile_model) {
                        $model->shg_profile_model = $profile_model;
                    } else {
                        $model->shg_profile_model = new \common\models\dynamicdb\cbo_detail\RishtaShgProfile();
                    }

                    $model->shg_profile_model->cbo_shg_id = $model->cbo_shg_id;
                    $model->shg_profile_model->name_of_shg = $model->name_of_shg;
                    $model->shg_profile_model->no_of_members = $model->no_of_members;
                    $model->shg_profile_model->date_of_formation = $model->date_of_formation;

                    if ($model->shg_profile_model->save()) {
                        Yii::$app->session->setFlash('success', 'डेटा सफलतापूर्वक सहेजा गया');
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model->shg_fund_status_model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $shg_model = \common\models\dynamicdb\cbo_detail\RishtaShgProfile::find()->where(['cbo_shg_id'=>$shgid])->one();
            if ($shg_model) {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgProfileForm($shg_model);
            } else {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgProfileForm();
            }
            $model->cbo_shg_id = $shgid;

            return $this->render('update', ['model' => $model,'shg_model'=>$shg_model]);
        }
    }
    public function actionTest($shgid) {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgProfileForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {

                    $profile_model = \common\models\dynamicdb\cbo_detail\form\RishtaShgProfileForm::find()->where(['cbo_shg_id' => $model->cbo_shg_id])->one();
                    if ($profile_model) {
                        $model->shg_profile_model = $profile_model;
                    } else {
                        $model->shg_profile_model = new \common\models\dynamicdb\cbo_detail\RishtaShgProfile();
                    }

                    $model->shg_profile_model->cbo_shg_id = $model->cbo_shg_id;
                    $model->shg_profile_model->name_of_shg = $model->name_of_shg;
                    $model->shg_profile_model->no_of_members = $model->no_of_members;
                    $model->shg_profile_model->date_of_formation = $model->date_of_formation;

                    if ($model->shg_profile_model->save()) {
                        Yii::$app->session->setFlash('success', 'डेटा सफलतापूर्वक सहेजा गया');
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model->shg_fund_status_model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $shg_model = \common\models\dynamicdb\cbo_detail\RishtaShgProfile::find()->where(['cbo_shg_id'=>$shgid])->one();
            if ($shg_model) {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgProfileForm($shg_model);
            } else {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgProfileForm();
            }
            $model->cbo_shg_id = $shgid;

            return $this->render('test', ['model' => $model,'shg_model'=>$shg_model]);
        }
    }

}

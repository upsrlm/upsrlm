<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\master\MasterDivisionSearch;
use common\models\master\MasterDistrictSearch;
use common\models\master\MasterSubDistrictSearch;
use common\models\master\MasterBlockSearch;
use common\models\master\MasterGramPanchayatSearch;
use common\models\master\MasterVillageSearch;
use common\models\master\MasterTownSearch;
use common\models\master\MasterTown;

/**
 * AjaxController implements the ajax.
 */
class AjaxController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
     public function BeforeAction($action) {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }
    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionSubdisrict() {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['depdrop_parents'])) {

                $parents = $_POST['depdrop_parents'];
                $district_code = $parents[0];

                $array = [];
                if ($district_code != null) {
                    $searchModel = new MasterVillageSearch();
                    $searchModel->district_code = $district_code;
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, MasterVillageSearch::$coll_sub_district);
                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {
                            $array[$model->sub_district_code] = ['id' => $model->sub_district_code, 'name' => $model->sub_district_name];
                        }
                    }
                    echo Json::encode(['output' => $array, 'selected' => '']);
                    return;
                }
            }
            echo Json::encode(['output' => '', 'selected' => '']);
        }
    }

    public function actionGetblock() {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['depdrop_parents'])) {

                $parents = $_POST['depdrop_parents'];
                $district_code = $parents[0];

                $array = [];
                if ($district_code != null) {
                    $searchModel = new MasterBlockSearch();
                    $searchModel->district_code = $district_code;
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, \common\models\base\GenralModel::select_block_drop_columns());
                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {
                            $array[$model->block_code] = ['id' => $model->block_code, 'name' => $model->block_name];
                        }
                    }
                    echo Json::encode(['output' => $array, 'selected' => '']);
                    return;
                }
            }
            echo Json::encode(['output' => '', 'selected' => '']);
        }
    }

    public function actionGetgp() {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                $district_code = $parents[0];
                $block_code = $parents[1];

                $array = [];
                if ($block_code != null) {
                    $searchModel = new MasterGramPanchayatSearch();
                    $searchModel->district_code = $district_code;
                    $searchModel->block_code = $block_code;
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, MasterVillageSearch::$coll_gram_panchayat, \common\models\base\GenralModel::select_gp_drop_columns());
                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {
                            $array[$model->gram_panchayat_code] = ['id' => $model->gram_panchayat_code, 'name' => $model->gram_panchayat_name];
                        }
                    }
                    //echo Json::encode(['output' => $array, 'selected' => '']);
                    //return;
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    \Yii::$app->response->data = ['output' => $array, 'selected' => ''];
                }
            } else {
                echo Json::encode(['output' => '', 'selected' => '']);
            }
        }
    }

    public function actionGetvillage() {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                //$district_code = $parents[0];
                $gram_panchayat_code = $parents[0];

                $array = [];
                if ($gram_panchayat_code != null) {
                    $searchModel = new MasterVillageSearch();
                    $searchModel->gram_panchayat_code = $gram_panchayat_code;
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, MasterVillageSearch::$coll_village, \common\models\base\GenralModel::select_village_drop_columns());
                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {
                            $array[$model->village_code] = ['id' => $model->village_code, 'name' => $model->village_name];
                        }
                    }
                    //echo Json::encode(['output' => $array, 'selected' => '']);
                    //return;
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    \Yii::$app->response->data = ['output' => $array, 'selected' => ''];
                }
            } else {
                echo Json::encode(['output' => '', 'selected' => '']);
            }
        }
    }

    public function actionBlock() {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                $district_code = $parents[0];
                $sub_district_code = $parents[1];

                $array = [];
                if ($sub_district_code != null) {
                    $searchModel = new MasterVillageSearch();
                    $searchModel->district_code = $district_code;
                    $searchModel->sub_district_code = $sub_district_code;
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, MasterVillageSearch::$coll_block);
                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {
                            $array[$model->block_code] = ['id' => $model->block_code, 'name' => $model->block_name];
                        }
                    }
                    echo Json::encode(['output' => $array, 'selected' => '']);
                    return;
                }
            }
            echo Json::encode(['output' => '', 'selected' => '']);
        }
    }

}

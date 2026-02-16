<?php

namespace frontend\controllers;

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
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {
                            $array[$model->block_code] = ['id' => $model->block_code, 'name' => $model->block_name.' ('.$model->district_name.')'];
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
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, MasterVillageSearch::$coll_gram_panchayat);
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
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, MasterVillageSearch::$coll_village);
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

    public function actionGetruralprimaryuser() {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                $district_code = $parents[0];
                $block_code = $parents[1];

                $array = [];
                if ($block_code != null) {
                    $searchModel = new \app\models\RelationUserGramPanchayatSearch();
                    $searchModel->district_code = $district_code;
                    $searchModel->block_code = $block_code;
                    $searchModel->status = \app\models\base\GenralModel::STATUS_ACTIVE;
                    $searchModel->user_status = \app\models\base\GenralModel::STATUS_ACTIVE;
                    $searchModel->role = [\app\models\master\MasterRole::ROLE_GP_SAACHIV, \app\models\master\MasterRole::ROLE_GP_ADHIKARI];
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, \app\models\RelationUserGramPanchayatSearch::$coll_secondary_user);

                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {

                            $name = $model->user->name . ' (' . implode(', ', ArrayHelper::getColumn($model->user->grampanchayat, 'gp.gram_panchayat_name')) . ')';
                            $array[$model->user_id] = ['id' => $model->user_id, 'name' => $name];
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

    public function actionGeturbanprimaryuser() {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                $ulb_code = $parents[0];


                $array = [];
                if ($ulb_code != null) {
                    $searchModel = new \app\models\RelationUserUlbSearch();
                    $searchModel->ulb_code = $ulb_code;
                    $searchModel->status = \app\models\base\GenralModel::STATUS_ACTIVE;
                    $searchModel->user_status = \app\models\base\GenralModel::STATUS_ACTIVE;
                    $searchModel->role = [\app\models\master\MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR];
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, \app\models\RelationUserUlbSearch::$coll_primary_user);

                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {
                            $array[$model->primary_user_id] = ['id' => $model->primary_user_id, 'name' => $model->primaryuser->name];
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

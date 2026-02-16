<?php

namespace bc\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\models\User;
use bc\models\master\MasterDivisionSearch;
use bc\models\master\MasterDistrictSearch;
use common\models\master\MasterSubDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\models\master\MasterGramPanchayatSearch;
use bc\models\master\MasterVillageSearch;
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
//                print_r($district_code);exit;
                $array = [];
                if ($district_code != null) {
                    $searchModel = new MasterBlockSearch();
                    $searchModel->district_code = $district_code;
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {
                            $array[$model->block_code] = ['id' => $model->block_code, 'name' => $model->block_name . " (" . $model->district_name . " )"];
                        }
                    }
                    echo Json::encode(['output' => $array, 'selected' => '']);
                    exit();
                    return;
                }
            }
            echo Json::encode(['output' => '', 'selected' => '']);
            exit();
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

    public function actionTest() {
        $user_id = 10;
        $sql = "SELECT  a.message_title as title,message,genrated_on
           FROM    notification_log a
		INNER JOIN
		(
			SELECT detail_id, MIN(id) min_ID
			FROM   notification_log
             where user_id=" . $user_id . "
			GROUP BY detail_id
		) b ON a.detail_id = b.detail_id AND
				a.id = b.min_ID
             where a.user_id=" . $user_id;
        $models = \bc\models\NotificationLog::findBySql($sql)->asArray()->all();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        echo Json::encode(['output' => $models, 'selected' => '']);
        print_r($models);
        exit;
    }

//    public function actionUnwilling() {
//        $un_willings = \bc\modules\selection\models\SrlmBcApplication::find()->where(['status' => 2])->andWhere(['bc_unwilling_rsetis' => 1, 'bc_unwilling_call_center' => 1])->all();
//        foreach ($un_willings as $bc_model) {
//            $model = new \bc\modules\selection\models\form\UnwillingCallCenterForm($bc_model);
//            $model->markunwilling();
//        }
//    }
    public function actionDownload() {
        $zip_name = "gp_application.zip";
        $folder = \Yii::$app->params['bcdatapath'] . 'tmp';
        $filename = time();
        $sql = "SELECT *
                    FROM  gp_application
                    INTO OUTFILE '" . $folder . $filename . ".csv'
                    FIELDS TERMINATED BY ','
                    ENCLOSED BY '\"'
                    LINES TERMINATED BY '\n'";
        $connection = \Yii::$app->dbbc;
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql)->execute();
            $transaction->commit();
        } catch (Exception $e) { // an exception is raised if a query fails
            print_r($e);
            exit;
            $transaction->rollBack();
        }
        $cfile = $folder . $filename . ".csv";
        if (extension_loaded('zip')) {
            $zip = new ZipArchive();
            if ($zip->open($zip_name, \ZipArchive::CREATE) == TRUE) {
                $zip->addFile($cfile, "gp_application.csv");
            }
            $zip->close();
            chmod($zip_name, 0777);
        }
        $status_header = 'HTTP/1.1 200 Success';
        header($status_header);
        if ($zip_name != '') {
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zip_name . '"');
            if (readfile($zip_name)) {
                unlink($zip_name);
            }
            exit();
        }
    }

}

<?php

namespace app\modules\master\controllers;

use Yii;
use common\models\master\MasterListBlockBdo;
use common\models\master\MasterListBlockBdoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MsterBlockBdoController implements the CRUD actions for MasterBlockBdo model.
 */
class MasterBlockBdoController extends Controller {

    /**
     * {@inheritdoc}
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
     * Lists all MasterBlockBdo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MasterListBlockBdoSearch();
        $searchModel->status = -1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterBlockBdo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MasterBlockBdo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new MasterBlockBdo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterBlockBdo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MasterBlockBdo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDownload() {
        ini_set('max_execution_time', 6000000);
        ini_set('memory_limit', '1024M');
        $models = MasterListBlockBdo::find()->all();

//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, FALSE);
//        $models = $dataProvider->getModels();

        $temp_data = "S.No.,"
                . "District,"
                . "Role,"
                . "Block,"
                . "Mobile No.,"
                . "Status\n";
        $file_name = "block_bdo_list" . date('d-m-Y-H-m-s');
        $filePath = Yii::$app->params['tmp'] . $file_name . ".csv";
        $fp = fopen($filePath, 'a+');

        $sno = 1;
        foreach ($models as $model) {
            $district = '"' . $model->district . '"';
            $role = $model->role;
            $block = $model->block;
            $mobile_no = $model->mobile_no;

            switch ($model->status) {
                case 1:

                    $msg = "Active";
                    break;
                case 0:

                    $msg = "Inactive";
                    break;

                default:
                    $msg = "";
            }
            $temp_data .= "$sno,"
                    . "$district,"
                    . "$role,"
                    . "$block,"
                    . "$mobile_no,"
                    . "$msg,\n";
            $sno++;
        }

        fwrite($fp, $temp_data);
        fclose($fp);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        header("Content-Type: application/csv");
        header("Content-Length: " . filesize($filePath));
        header("Content-Disposition: attachment; filename=$file_name.csv");
        readfile($filePath);
        exit();
    }

    /**
     * Finds the MasterBlockBdo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterBlockBdo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MasterListBlockBdo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

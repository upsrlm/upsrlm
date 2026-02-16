<?php

namespace app\modules\master\controllers;

use Yii;
use bc\models\master\MasterGramPanchayat;
use bc\models\master\MasterGramPanchayatSearch;
use common\models\base\GenralModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GrampanchayatController implements the CRUD actions for MasterGramPanchayat model.
 */
class GrampanchayatController extends Controller {

    use \common\traits\AjaxValidationTrait;

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
     * Lists all MasterGramPanchayat models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MasterGramPanchayatSearch();
        $searchModel->bank_option=\bc\modules\selection\models\base\GenralModel::partner_bank_option();
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $dataProvider = $searchModel->search($params, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::blockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUrban() {
        $searchModel = new MasterGramPanchayatSearch();
        $searchModel->bank_option=\bc\modules\selection\models\base\GenralModel::partner_bank_option();
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $dataProvider = $searchModel->searchurban($params, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::blockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

        return $this->render('urban', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList() {
        $searchModel = new MasterGramPanchayatSearch();
        $searchModel->bank_option=\bc\modules\selection\models\base\GenralModel::partner_bank_option();
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $dataProvider = $searchModel->searchlist($params, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::blockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

        return $this->render('list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterGramPanchayat model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionConverturban($gram_panchayat_code) {
        $gp_model = $this->findModelbycode($gram_panchayat_code);

        $gp = new \common\components\Gp();

        if ($gp->urban($gram_panchayat_code)) {
            \Yii::$app->getSession()->setFlash('success', 'GP Convert urban successfully');
            return $this->redirect(['/master/grampanchayat']);
        }
    }

    public function actionMarkurban($gram_panchayat_code) {
        $gp_model = $this->findModelbycode($gram_panchayat_code);

        $model = new \backend\models\form\GPConvertUrbanForm($gp_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            return $this->redirect(['/master/grampanchayat']);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_mark_urban_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_mark_urban_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionChangebank($gram_panchayat_code) {
        $gp_model = $this->findModelbycodebc($gram_panchayat_code);

        $model = new \bc\models\form\ChangeBankForm($gp_model);
        unset($model->bank_option[$gp_model->master_partner_bank_id]);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            return $this->redirect(['/master/grampanchayat?MasterGramPanchayatSearch[district_code]=' . $gp_model->district_code . '&MasterGramPanchayatSearch[block_code]=' . $gp_model->block_code]);
            //return $this->redirect(['/master/grampanchayat']);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_change_bank_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_change_bank_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCreate() {
        $model = new MasterGramPanchayat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterGramPanchayat model.
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
     * Finds the MasterGramPanchayat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterGramPanchayat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MasterGramPanchayat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelbycode($gram_panchayat_code) {
        if (($model = MasterGramPanchayat::findOne(['gram_panchayat_code' => $gram_panchayat_code])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelbycodebc($gram_panchayat_code) {
        if (($model = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $gram_panchayat_code])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
}

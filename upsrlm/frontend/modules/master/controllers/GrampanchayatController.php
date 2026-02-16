<?php

namespace app\modules\master\controllers;

use Yii;
use common\models\master\MasterGramPanchayat;
use common\models\master\MasterGramPanchayatSearch;
use common\models\base\GenralModel;
use common\models\master\MasterRole;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GrampanchayatController implements the CRUD actions for MasterGramPanchayat model.
 */
class GrampanchayatController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'markurban', 'update', 'add', 'getblockgp'],
                'rules' => [
                    [
                        'actions' => ['index', 'markurban', 'update', 'add', 'getblockgp'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_PANCHAYATI_RAJ]));
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all MasterGramPanchayat models.
     * @return mixed
     */
//    public function actionIndex() {
//        $searchModel = new MasterGramPanchayatSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $searchModel->block_option = GenralModel::blockopption($searchModel);
//        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
//
//        return $this->render('index', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }

//    public function actionMarkurban($gram_panchayat_code) {
//        $gp_model = $this->findModelbycode($gram_panchayat_code);
//
//        $model = new \backend\models\form\GPConvertUrbanForm($gp_model);
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
//
//            return $this->redirect(['/master/grampanchayat']);
//        }
//
//        if (\Yii::$app->request->isAjax) {
//            return $this->renderAjax('_mark_urban_form', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_mark_urban_form', [
//                        'model' => $model,
//            ]);
//        }
//    }

//    public function actionAdd() {
//        $model = new \frontend\models\form\AddGPForm();
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//
//            if ($model->validate()) {
//                if ($model->save()) {
//                    \Yii::$app->getSession()->setFlash('success', 'Add GP successfully');
//                    return $this->redirect(['/master/grampanchayat']);
//                }
//            }
//        }
//
//        return $this->render('add', [
//                    'model' => $model,
//        ]);
//    }

//    public function actionUpdate($id) {
//        $gp_model = $this->findModel($id);
//        if ($gp_model->new == 0) {
//            return $this->redirect(['/master/grampanchayat?MasterGramPanchayatSearch[new]=1']);
//        }
//        if ($gp_model->new_status == 1) {
//            return $this->redirect(['/master/grampanchayat?MasterGramPanchayatSearch[new]=1']);
//        }
//        $model = new \frontend\models\form\AddGPForm($gp_model);
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//
//            if ($model->validate()) {
//                if ($model->save()) {
//                    \Yii::$app->getSession()->setFlash('success', 'Update GP successfully');
//                    return $this->redirect(['/master/grampanchayat?MasterGramPanchayatSearch[new]=1']);
//                }
//            }
//        }
//
//        return $this->render('update', [
//                    'model' => $model,
//        ]);
//    }

//    public function actionGetblockgp($block_code) {
//        $searchModel = new MasterGramPanchayatSearch();
//        $searchModel->block_code = $block_code;
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
//        $searchModel->block_option = GenralModel::blockopption($searchModel);
//        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
//
//        return $this->renderAjax('blockgp', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//        ;
//    }

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

}

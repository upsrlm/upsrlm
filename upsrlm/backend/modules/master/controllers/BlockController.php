<?php

namespace app\modules\master\controllers;

use Yii;
use common\models\master\MasterBlock;
use common\models\master\MasterBlockSearch;
use common\models\base\GenralModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlockController implements the CRUD actions for MasterBlock model.
 */
class BlockController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest);
                        }
                    ],
                    [
                        'actions' => ['index', 'create', 'update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MasterBlock models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MasterBlockSearch();
//        $searchModel->bdo_status = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::blockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterBlock model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionAddnewblockcode($block_code) {
        $block_model = $this->findModelbycode($block_code);

        $model = new \backend\models\form\BlockNewCodeForm($block_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            return $this->redirect(['/master/block/index?MasterBlockSearch[district_code]='.$block_model->district_code]);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_new_list_block_code_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_new_list_block_code_form', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MasterBlock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPop() {
        $models = \app\models\nfsa\NfsaUserBdoMasterBlock::find()->all();
        foreach ($models as $model) {
            $model->master_block_id = $model->master_block_id;
            $model->save();
        }


        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MasterBlock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelbycode($block_code) {
        if (($model = MasterBlock::findOne(['block_code' => $block_code])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

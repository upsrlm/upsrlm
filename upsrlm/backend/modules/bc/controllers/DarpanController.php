<?php

namespace backend\modules\bc\controllers;

use Yii;
use bc\models\report\Graph;
use yii\web\Controller;
use bc\models\BcGovermentReportBlock;
use bc\models\BcGovermentReportBlockSearch;
use bc\models\BcGovermentReportDistrict;
use bc\models\BcGovermentReportDistrictSearch;
use bc\modules\selection\models\base\GenralModel;

/**
 * Default controller for the `report` module
 */
class DarpanController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['district', 'block', 'index', 'graph', 'csvdownload'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['district', 'block', 'index', 'graph', 'csvdownload'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        \Yii::$app->params['page_size30'] = 850;
        $searchModel = new BcGovermentReportBlockSearch();
        $searchModel->is_pushed = 1;
        $searchModel->date = $searchModel->getLastpushdate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $searchModel->date_option = $searchModel->getPushdates();
        $searchModel->district_option = GenralModel::districtoption($searchModel);
        if ($searchModel->district_code) {
            $searchModel->block_option = GenralModel::blockoption($searchModel);
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDistrict() {
        \Yii::$app->params['page_size30'] = 850;
        $searchModel = new BcGovermentReportBlockSearch();
        $searchModel->is_pushed = 1;
        $searchModel->date = $searchModel->getLastpushdate();
        if(isset(Yii::$app->request->queryParams['BcGovermentReportBlockSearch']['date']) and Yii::$app->request->queryParams['BcGovermentReportBlockSearch']['date']){
          $searchModel->date = Yii::$app->request->queryParams['BcGovermentReportBlockSearch']['date'];  
        }
        $searchModeld=new BcGovermentReportDistrictSearch();
        $dataProvider = $searchModeld->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $searchModel->date_option = $searchModel->getPushdates();
        $searchModel->district_option = GenralModel::districtoption($searchModel);
        if ($searchModel->district_code) {
            $searchModel->block_option = GenralModel::blockoption($searchModel);
        }

        return $this->render('district', [
                    'searchModel' => $searchModel,
                    'searchModeld' => $searchModeld,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionBlock($district_code,$date) {
        \Yii::$app->params['page_size30'] = 850;
        $searchModel = new BcGovermentReportBlockSearch();
        $searchModel->is_pushed = 1;
        $searchModel->date = $date;
        $searchModel->district_code = $district_code;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $searchModel->date_option = $searchModel->getPushdates();
        $searchModel->district_option = GenralModel::districtoption($searchModel);
        if ($searchModel->district_code) {
            $searchModel->block_option = GenralModel::blockoption($searchModel);
        }

        return $this->render('block', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
}

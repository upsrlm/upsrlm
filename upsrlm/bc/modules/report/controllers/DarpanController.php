<?php

namespace bc\modules\report\controllers;

use Yii;
use bc\models\report\Graph;
use yii\web\Controller;
use bc\models\BcGovermentReportBlock;
use bc\models\BcGovermentReportBlockSearch;
use bc\modules\selection\models\base\GenralModel;

/**
 * Default controller for the `report` module
 */
class DarpanController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'graph', 'csvdownload'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'graph', 'csvdownload'],
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
}

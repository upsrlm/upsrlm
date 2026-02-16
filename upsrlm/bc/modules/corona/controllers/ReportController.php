<?php

namespace bc\modules\corona\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\corona\models\BcCoronaFeedback;
use bc\modules\corona\models\BcCoronaFeedbackSearch;
use bc\modules\selection\models\base\GenralModel;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `corona` module
 */
class ReportController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'graph'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'graph'],
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
        $searchModel = new BcCoronaFeedbackSearch();
        $dataProvider11 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider11->query->andWhere(['=', 'que1a', '1']);
        $dataProvider12 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider12->query->andWhere(['=', 'que1a', '2']);

        $dataProvider21 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider21->query->andWhere(['=', 'que2a', '1']);
        $dataProvider22 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider22->query->andWhere(['=', 'que2a', '2']);

        $dataProvider23 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider23->query->andWhere(['=', 'que2a', '3']);
        $dataProvider24 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider24->query->andWhere(['=', 'que2a', '4']);

        $dataProvider31 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider31->query->andWhere(['=', 'que3a', '1']);
        $dataProvider32 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider32->query->andWhere(['=', 'que3a', '2']);

        $dataProvider33 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider33->query->andWhere(['=', 'que3a', '3']);
        $dataProvider34 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider34->query->andWhere(['=', 'que3a', '4']);
        $dataProvider35 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider35->query->andWhere(['=', 'que3a', '5']);
        $dataProvider41 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider41->query->andWhere(['=', 'que4a', '1']);
        $dataProvider42 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider42->query->andWhere(['=', 'que4a', '2']);

        $dataProvider43 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider43->query->andWhere(['=', 'que4a', '3']);
        $searchModel->district_option = GenralModel::districtoption();
        if ($searchModel->district_code) {
            $searchModel->block_option = GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::gpoption($searchModel);
        }
        if ($searchModel->gram_panchayat_code) {
            $searchModel->village_option = GenralModel::villageoption($searchModel);
        }
        $rep = new \bc\modules\corona\models\Graph();
        $graph = $rep->corona($searchModel);
        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "11") {
            $dataProvider = $dataProvider11;
        } elseif ($button_type == "12") {
            $dataProvider = $dataProvider12;
        } elseif ($button_type == "21") {
            $dataProvider = $dataProvider21;
        } elseif ($button_type == "22") {
            $dataProvider = $dataProvider22;
        } elseif ($button_type == "23") {
            $dataProvider = $dataProvider23;
        } elseif ($button_type == "24") {
            $dataProvider = $dataProvider24;
        } elseif ($button_type == "31") {
            $dataProvider = $dataProvider31;
        } elseif ($button_type == "32") {
            $dataProvider = $dataProvider32;
        } elseif ($button_type == "33") {
            $dataProvider = $dataProvider33;
        } elseif ($button_type == "34") {
            $dataProvider = $dataProvider34;
        } elseif ($button_type == "35") {
            $dataProvider = $dataProvider35;
        } elseif ($button_type == "41") {
            $dataProvider = $dataProvider41;
        } elseif ($button_type == "42") {
            $dataProvider = $dataProvider42;
        } elseif ($button_type == "43") {
            $dataProvider = $dataProvider43;
        }
        return $this->render('index', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'graph' => $graph,
                    'dataProvider11' => $dataProvider11,
                    'dataProvider12' => $dataProvider12,
                    'dataProvider21' => $dataProvider21,
                    'dataProvider22' => $dataProvider22,
                    'dataProvider23' => $dataProvider23,
                    'dataProvider24' => $dataProvider24,
                    'dataProvider31' => $dataProvider31,
                    'dataProvider32' => $dataProvider32,
                    'dataProvider33' => $dataProvider33,
                    'dataProvider34' => $dataProvider34,
                    'dataProvider35' => $dataProvider35,
                    'dataProvider41' => $dataProvider41,
                    'dataProvider42' => $dataProvider42,
                    'dataProvider43' => $dataProvider43,
        ]);
    }

    public function actionGraph() {
        $searchModel = new BcCoronaFeedbackSearch();
        $dataProvider11 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider11->query->andWhere(['=', 'que1a', '1']);
        $dataProvider12 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider12->query->andWhere(['=', 'que1a', '2']);

        $dataProvider21 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider21->query->andWhere(['=', 'que2a', '1']);
        $dataProvider22 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider22->query->andWhere(['=', 'que2a', '2']);

        $dataProvider23 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider23->query->andWhere(['=', 'que2a', '3']);
        $dataProvider24 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider24->query->andWhere(['=', 'que2a', '4']);

        $dataProvider31 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider31->query->andWhere(['=', 'que3a', '1']);
        $dataProvider32 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider32->query->andWhere(['=', 'que3a', '2']);

        $dataProvider33 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider33->query->andWhere(['=', 'que3a', '3']);
        $dataProvider34 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider34->query->andWhere(['=', 'que3a', '4']);
        $dataProvider35 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider35->query->andWhere(['=', 'que3a', '5']);
        $dataProvider41 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider41->query->andWhere(['=', 'que4a', '1']);
        $dataProvider42 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider42->query->andWhere(['=', 'que4a', '2']);

        $dataProvider43 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider43->query->andWhere(['=', 'que4a', '3']);
        $searchModel->district_option = GenralModel::districtoption();
        if ($searchModel->district_code) {
            $searchModel->block_option = GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::gpoption($searchModel);
        }
        if ($searchModel->gram_panchayat_code) {
            $searchModel->village_option = GenralModel::villageoption($searchModel);
        }
        $rep = new \bc\modules\corona\models\Graph();
        $graph = $rep->corona($searchModel);
        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "11") {
            $dataProvider = $dataProvider11;
        } elseif ($button_type == "12") {
            $dataProvider = $dataProvider12;
        } elseif ($button_type == "21") {
            $dataProvider = $dataProvider21;
        } elseif ($button_type == "22") {
            $dataProvider = $dataProvider22;
        } elseif ($button_type == "23") {
            $dataProvider = $dataProvider23;
        } elseif ($button_type == "24") {
            $dataProvider = $dataProvider24;
        } elseif ($button_type == "31") {
            $dataProvider = $dataProvider31;
        } elseif ($button_type == "32") {
            $dataProvider = $dataProvider32;
        } elseif ($button_type == "33") {
            $dataProvider = $dataProvider33;
        } elseif ($button_type == "34") {
            $dataProvider = $dataProvider34;
        } elseif ($button_type == "35") {
            $dataProvider = $dataProvider35;
        } elseif ($button_type == "41") {
            $dataProvider = $dataProvider41;
        } elseif ($button_type == "42") {
            $dataProvider = $dataProvider42;
        } elseif ($button_type == "43") {
            $dataProvider = $dataProvider43;
        }
        return $this->render('graph', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'graph' => $graph,
                    'dataProvider11' => $dataProvider11,
                    'dataProvider12' => $dataProvider12,
                    'dataProvider21' => $dataProvider21,
                    'dataProvider22' => $dataProvider22,
                    'dataProvider23' => $dataProvider23,
                    'dataProvider24' => $dataProvider24,
                    'dataProvider31' => $dataProvider31,
                    'dataProvider32' => $dataProvider32,
                    'dataProvider33' => $dataProvider33,
                    'dataProvider34' => $dataProvider34,
                    'dataProvider35' => $dataProvider35,
                    'dataProvider41' => $dataProvider41,
                    'dataProvider42' => $dataProvider42,
                    'dataProvider43' => $dataProvider43,
        ]);
    }

}

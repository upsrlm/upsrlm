<?php

namespace bc\modules\selection\modules\dashboard\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\models\srlm\SrlmBcApplicationGroupFamily;
use common\models\master\MasterRole;
use bc\components\srlm\BcApplication;
use bc\models\srlm\report\Graph;

/**
 * Default controller for the `dashboard` module
 */
class GraphController extends Controller {

    public $flash_message;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'download'],
                'rules' => [
                    [
                        'actions' => ['index', 'download'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest );
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN,MasterRole::ROLE_MD])) {
            return $this->redirect(['/selection/preselected']);
        }
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $rep = new Graph();
        $graph1 = $rep->mu($searchModel);
        $graph2 = $rep->edu($searchModel);
        $graph3 = $rep->cast($searchModel);
        $graph4 = $rep->age($searchModel);
        $graph5 = $rep->phone_type($searchModel);
        $graph6 = $rep->whatsup($searchModel);
        $graph7 = $rep->agm($searchModel);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'graph1' => $graph1,
                    'graph2' => $graph2,
                    'graph3' => $graph3,
                    'graph4' => $graph4,
                    'graph5' => $graph5,
                    'graph6' => $graph6,
                    'graph7' => $graph7,
        ]);
    }
  public function actionSelection() {
      if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM,MasterRole::ROLE_DIVISIONAL_COMMISSIONER,MasterRole::ROLE_RSETIS_STATE_UNIT,MasterRole::ROLE_RSETIS_DISTRICT_UNIT,MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
         if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModel->graph_selection=1;
        $searchModel->status= SrlmBcApplication::STATUS_PROVISIONAL;
        $rep = new Graph();
        $graph1 = $rep->mu($searchModel);
        $graph2 = $rep->edu($searchModel);
        $graph3 = $rep->cast($searchModel);
        $graph4 = $rep->age($searchModel);
        $graph5 = $rep->phone_type($searchModel);
        $graph6 = $rep->whatsup($searchModel);
        $graph7 = $rep->agm($searchModel);
        return $this->render('selection', [
                    'searchModel' => $searchModel,
                    'graph1' => $graph1,
                    'graph2' => $graph2,
                    'graph3' => $graph3,
                    'graph4' => $graph4,
                    'graph5' => $graph5,
                    'graph6' => $graph6,
                    'graph7' => $graph7,
        ]);
    }
}

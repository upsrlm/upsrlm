<?php

namespace bccallcenter\modules\monitoring\controllers;

use yii\web\Controller;
use common\models\dynamicdb\internalcallcenter\platform\search\CallingListSearch;
use Yii;
use common\models\master\MasterRole;

/**
 * agent controller for the `monitoring` module
 */
class IbdController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'calldetail'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'calldetail'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Agent Progress
     *
     * @return void
     */
    public function actionIndex() {
        $user_model = \Yii::$app->user->identity;
        $searchModel = new \common\models\dynamicdb\internalcallcenter\platform\BcCallingAgentProgressIbd();
        $searchModel->calling_date = date('Y-m-d');
        if (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
            $searchModel->calling_agent_role = MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE;
        } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
            $searchModel->calling_agent_role = MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVEE;
        } elseif (in_array($user_model->role, [MasterRole::ROLE_ADMIN])) {
            
        } else {
            $searchModel->calling_agent_id = $user_model->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
                        'index',
                        [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'user_model'=>$user_model
                        ]
        );
    }

    /**
     * Call Detail
     *
     * @return void
     */
    public function actionCalldetail() {
        $searchModel = new \common\models\dynamicdb\internalcallcenter\platform\search\CallingAgentProgressIbdSearch();
        $searchModel->calling_date = date('Y-m-d');
        $dataProvider = $searchModel->calldetailsearch(Yii::$app->request->queryParams);

        return $this->render(
                        'calldetail',
                        [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider
                        ]
        );
    }

}

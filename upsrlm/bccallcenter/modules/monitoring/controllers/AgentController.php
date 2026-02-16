<?php

namespace bccallcenter\modules\monitoring\controllers;

use yii\web\Controller;
use common\models\dynamicdb\internalcallcenter\platform\search\CallingListSearch;
use Yii;
use common\models\master\MasterRole;

/**
 * agent controller for the `monitoring` module
 */
class AgentController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['progress', 'calldetail'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['progress', 'calldetail'],
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
    public function actionProgress() {
        $user_model = \Yii::$app->user->identity;
        $searchModel = new \common\models\dynamicdb\internalcallcenter\platform\BcCallingAgentProgressSearch();
        $searchModel->calling_date = date('Y-m-d');
        if (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
            $searchModel->calling_agent_role = MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE;
        } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
            $searchModel->calling_agent_role = MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE;
        } elseif (in_array($user_model->role, [MasterRole::ROLE_ADMIN])) {
            $searchModel->calling_agent_role = [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE,MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE];
        } else {
            $searchModel->calling_agent_id = $user_model->id;
        }
        $dataProvider = $searchModel->searcha(Yii::$app->request->queryParams);

        return $this->render(
                        'progress',
                        [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'user_model' => $user_model
                        ]
        );
    }

    /**
     * Call Detail
     *
     * @return void
     */
    public function actionCalldetail() {
        $searchModel = new \common\models\dynamicdb\internalcallcenter\platform\BcCallingAgentProgressSearch();
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

<?php

namespace bccallcenter\modules\monitoring\controllers;

use yii\web\Controller;
use common\models\dynamicdb\internalcallcenter\platform\search\CallingProgressSearch;
use Yii;

/**
 * Default controller for the `monitoring` module
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModelCtc = new \common\models\dynamicdb\internalcallcenter\platform\BcCallingAgentProgressSearch();
        $searchModelCtc->calling_date = date('Y-m-d');

        $searchModelIbd = new \common\models\dynamicdb\internalcallcenter\platform\BcCallingAgentProgressIbdSearch();
        $searchModelIbd->calling_date = date('Y-m-d');

        return $this->render(
                        'index',
                        [
                            'searchModelCtc' => $searchModelCtc,
                            'searchModelIbd' => $searchModelIbd,
                        ]
        );
    }

}

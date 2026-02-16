<?php

namespace bccallcenter\modules\rsetis\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\report\models\form\ReportSearchForm;
use bc\models\BcCumulativeReportDistrict;
use bc\models\BcCumulativeReportDistrictSearch;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportBlock;
use bc\models\BcCumulativeReportBlockSearch;

class PendencyController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
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

        $model = BcCumulativeReportDistrict::find()->select(['date'])->orderBy("date DESC")->limit(1)->one();
        $searchModel = new BcCumulativeReportDistrictSearch();
        $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        return $this->render('pendencyd', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDb($district_code) {

        $model = \bc\models\BcCumulativeReportBlock::find()->orderBy("date DESC")->limit(1)->one();
        $dis_model = \bc\models\master\MasterDistrict::findOne(['district_code' => $district_code]);
        if($dis_model==null){
          return $this->redirect(['/report/cumulative/pendencyd']);  
        }
        $searchModel = new BcCumulativeReportBlockSearch();
        $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
        $searchModel->district_code = $district_code;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        return $this->render('pendencydb', [
                    'dis_model' => $dis_model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}

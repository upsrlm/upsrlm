<?php

namespace bc\modules\selection\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\models\srlm\SrlmBcApplicationGroupFamily;
use common\models\master\MasterRole;
use bc\components\srlm\BcApplication;
use bc\models\srlm\report\Graph;
use bc\modules\selection\models\form\Call1StatusForm;

/**
 * Default controller for the `nfsaSurvey` module
 */
class StandbyController extends Controller {

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
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest );
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'alreadycertified' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new \bc\models\master\MasterGramPanchayatSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
        $dataProvider->query->andWhere(['=', 'gp_post_vacant', '1']);
       

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCsvsupport() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');

//        $user_model = Yii::$app->user->identity;
//        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
//
//        $searchModels = new SrlmBcApplicationSearch();
//        $dataProvider = $searchModels->verify($searchModel, Yii::$app->user->identity, 1000, 'srlm_bc_application.id');
        try {
            $file_name = "stand_by_BC.csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'id', 'Application No', 'Name of BC', 'Mobile Number', 'OTP Verified mobile no', 'District', 'District code', 'Block', 'Block code', 'Gram Panchayat', 'Gram Panchayat code', 'SHG Name', 'Office Bearers '));
//        $models = $dataProvider->getModels();


            $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'srlm_bc_application.status', "2"])->andWhere(['srlm_bc_application.form_number' => 6])->andWhere(['srlm_bc_application.gender' => 2])->asArray()->all();
            $sr_no = 1;
            foreach ($models as $model) {
                $model = SrlmBcApplication::findOne($model['id']);
                $shg = \cbo\models\Shg::findOne($model->cbo_shg_id);
                $row = [
                    $sr_no,
                    $model->id,
                    $model->application_id,
                    $model->name,
                    $model->mobile_number,
                    $model->user->mobile_no,
                    $model->district_name,
                    $model->district_code,
                    $model->block_name,
                    $model->block_code,
                    $model->gram_panchayat_name,
                    $model->gram_panchayat_code,
                    isset($shg) ? $shg->name_of_shg : '',
                    isset($model->agm) ? $model->agm->name_eng : '',
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
        exit;
    }

    /**
     * Finds the NfsaBaseSurvey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NfsaBaseSurvey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SrlmBcApplication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

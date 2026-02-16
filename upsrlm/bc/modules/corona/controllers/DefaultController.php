<?php

namespace bc\modules\corona\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\corona\models\BcCoronaFeedback;
use bc\modules\corona\models\BcCoronaFeedbackSearch;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\corona\models\master\CoronaFeedbackMasterQues1a;
use bc\modules\corona\models\master\CoronaFeedbackMasterQues2a;
use bc\modules\corona\models\master\CoronaFeedbackMasterQues3a;
use bc\modules\corona\models\master\CoronaFeedbackMasterQues4a;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `corona` module
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'csvdownload'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'csvdownload'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new BcCoronaFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
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
        $searchModel->q1_option = ArrayHelper::map(CoronaFeedbackMasterQues1a::find()->where(['status' => 1])->all(), 'id', 'name_hi');
        $searchModel->q2_option = ArrayHelper::map(CoronaFeedbackMasterQues2a::find()->where(['status' => 1])->all(), 'id', 'name_hi');
        $searchModel->q3_option = ArrayHelper::map(CoronaFeedbackMasterQues3a::find()->where(['status' => 1])->all(), 'id', 'name_hi');
        $searchModel->q4_option = ArrayHelper::map(CoronaFeedbackMasterQues4a::find()->where(['status' => 1])->all(), 'id', 'name_hi');
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCsvdownload() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            $searchModel = new BcCoronaFeedbackSearch();
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, true);
            $query = BcCoronaFeedback::find();
            $query->select(['id']);
            $query->andWhere(['!=', BcCoronaFeedback::getTableSchema()->fullName . '.status', -1]);
            if ($searchModel->district_code) {
                $query->andWhere([BcCoronaFeedback::getTableSchema()->fullName . '.district_code' => $searchModel->district_code]);
            }
            $models = $query->asArray()->all();
            $file = "corona_feedback_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'District', 'Block', 'Gram Panchayat', 'क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार साँस की तकलीफ़ सीने में जकड़न इत्यादि की शिकायत है', 'अगर हाँ तो %', 'पिछले एक दो महीने में गाँव/ ग्रा०प० में कितने लोगों की मृत्यु हुई है', 'पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है', 'Name', 'Form Fill time'));

            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {

                $model = BcCoronaFeedback::findOne($model['id']);
                $row = [
                    $sr_no,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->q1a != null ? $model->q1a->name_hi : '',
                    ($model->que1a == 1 and $model->q2a != null) ? $model->q2a->name_hi : '',
                    $model->q3a != null ? $model->q3a->name_hi : '',
                    $model->q4a != null ? $model->q4a->name_hi : '',
                    $model->bc_name,
                    date('Y-m-d G:i:s', $model->created_at)
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }
    }

}

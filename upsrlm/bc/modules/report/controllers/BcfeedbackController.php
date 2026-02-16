<?php

namespace bc\modules\report\controllers;

use Yii;
use bc\models\report\Graph;
use yii\web\Controller;
use bc\modules\selection\models\BcPbtFeedback;
use bc\modules\selection\models\BcPbtFeedbackSearch;
use bc\modules\selection\models\base\GenralModel;

/**
 * Default controller for the `report` module
 */
class BcfeedbackController extends Controller {

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

        $searchModel = new BcPbtFeedbackSearch();
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = GenralModel::districtoption($searchModel);
        if ($searchModel->district_code) {
            $searchModel->block_option = GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::gpoption($searchModel);
        }

        $searchModel->q1_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        $searchModel->q2_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        $searchModel->q3_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        $searchModel->q4_option = [1 => 'बिलकुल जानकारी नहीं मिली है', 2 => 'और जानकारी और स्पष्टता की ज़रूरत है', 3 => 'अच्छी समझ बनी है - ख़तरों से स्वयं निपट सकेंगे'];
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGraph() {
        $searchModel = new BcPbtFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = GenralModel::districtoption($searchModel);
        if ($searchModel->district_code) {
            $searchModel->block_option = GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::gpoption($searchModel);
        }

        $searchModel->q1_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        $searchModel->q2_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        $searchModel->q3_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        $searchModel->q4_option = [1 => 'बिलकुल जानकारी नहीं मिली है', 2 => 'और जानकारी और स्पष्टता की ज़रूरत है', 3 => 'अच्छी समझ बनी है - ख़तरों से स्वयं निपट सकेंगे'];
        $rep = new \bc\modules\selection\models\report\Feedback();
        $graph = $rep->graph($searchModel);
        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";

        return $this->render('graph', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'graph' => $graph,
        ]);
    }

    public function actionCsvdownload() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            $searchModel = new BcPbtFeedbackSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
            $models = $dataProvider->getModels();
            $file = "training_and_sensitization _" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'BC Name', 'District', 'Block', 'Gram Panchayat', 'Partner agencies', '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे', '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय', '3. नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके ।', '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?', 'Form Fill time'));

            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bcapplication) ? $model->bcapplication->name : '',
                    isset($model->bcapplication) ? $model->bcapplication->district_name : '',
                    isset($model->bcapplication) ? $model->bcapplication->block_name : '',
                    isset($model->bcapplication) ? $model->bcapplication->gram_panchayat_name : '',
                    isset($model->bcapplication->pbank) ? $model->bcapplication->pbank->bank_name : '',
                    $model->ques1,
                    $model->ques2,
                    $model->ques3,
                    $model->ques4,
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

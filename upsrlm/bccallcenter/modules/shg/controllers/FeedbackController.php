<?php

namespace bccallcenter\modules\shg\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use cbo\models\Shg;
use cbo\models\sakhi\RishtaShgFeedback;
use cbo\models\sakhi\RishtaShgFeedbackSearch;
use common\models\master\MasterRole;
use common\models\base\GenralModel;

/**
 * Default controller for the `clf` module
 */
class FeedbackController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index','view', 'downloadcsv'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view', 'downloadcsv'],
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
        $searchModel = new RishtaShgFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadcsv() {
        try {
            ini_set('max_execution_time', 1200);
            ini_set('memory_limit', '2048M');
            $searchModel = new RishtaShgFeedbackSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            $models = $dataProvider->getModels();
            $file = "SHG_feedback_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array(
                'Sr No',
                'Name of SHG',
                'District',
                'Block',
                'GP',
                '1. आपके समूह को वचत करते हुए कितना समय हो गया है',
                '2. समूह में कितने सदस्य को अबतक राज्य ग्रामीण आजीविका मिशन या बैंक से ऋण मिल पाया है?',
                '3. समूह में जिन्हें अबतक ऋण नहीं मिला है उन में से कितने सदस्य को ऋण की त्वरित आवश्यकता है',
                '4. समूह में जिन्हें अबतक ऋण मिला है उन में से कितने सदस्य को दोबारा ऋण की त्वरित आवश्यकता है?',
                '5. आप को संकुल के लेखा सम्बन्धी खाताबही के रखरखाव के लिए कौन सी व्यवस्था ज़्यादा आसान लगती है ?',
                '6.1. बहुत ही अच्छा; हमारे समूह के सभी सदस्यों की ज़िंदगी बदल गयी',
                '6.2. ठीक ठाक मिशन के कार्यक्रमों के कारण हमारे जीवन में अच्छे बदलाव की सम्भावना है ।',
                '6.3. कुछ बता नहीं सकते; काफ़ी समय हो जाने के बाद भी कार्यक्रम से हमें कुछ ख़ास लाभ नहीं मिल पाया है',
                '6.4. समूह संचालन की प्रक्रिया हमारे सक्षमता से से कही ज़्यादा जटिल है – प्रशिक्षण होने पर भी सफलता पूर्वक करना मुश्किल है ।',
                '6.5. समूह में  बैठक़, वचत एवं अन्य गतिविधि में काफ़ी समय जाता है; आजीविका से जुड़े विषय पर धीमी प्रगति होती है',
                '6.6. मिशन मैनेजर हमसे तभी सम्बद्ध होते हैं जब मिशन से समूह के बारे में सूचनाएँ माँगी जाती है ।',
                '6.7. लम्बे समय तक इंतज़ार करने पर भी ऋण मिलने पर कोई बात नहीं होती है ।',
                '6.8. मिशन मैनेजर के प्रभाव से ही समूह की प्राथमिकता तय होती है – वे ही निश्चित करते हैं कि समूह कैसे चलेगा',
                '6.9. लेन देन के बही खाते लिखना मुश्किल है, BMM के मदद के बिना समूह का कार्यवाही चलाना मुश्किल है ।',
                '6.10. ऋण लेन देन की प्रक्रिया सही नहीं है – पक्षपात/ धांधली होता है  इसमें सुधार की ज़रूरत है ।',
                '6.11. माइक्रो-क्रेडिट प्लान (MCP) भरना बहुत ही जटिल है; इसे नहीं भर पाने के कारण ऋण मिलने में देरी होती है ।',
                '6.12. समूहों के सदस्यों के आजीविका व उनके ऋण प्राप्ति पर शुरू से ही प्रमुखता दी जाए',
                '6.13. बैंक से ऋण प्राप्त करने से ज़्यादा प्राथमिकता मिशन के माध्यम से ऋण प्राप्त करने पर दिया जाए',
                '6.14. सभी सदस्य के लिए माइक्रो-क्रेडिट प्लान (MCP) भर कर रखा जाए ताकि रोटेशन आने पर उन्हें ऋण मिलने देरी ना हो',
                '6.15. हर समूह के सदस्य को ये स्पष्ट समय सीमा बताया जाए कि उनके कितने समय में ऋण मिल सकेगा',
                '6.16. सभी सदस्य को ऋण मिलने से पूर्व, उनके सम्भावित रोज़गार/ उद्यम से सम्बंधित प्रशिक्षण/ जानकारी दी जाए ताकि वे सफल हो सकें ।',
                '6.17. हो सके तो ऋण पाने वाले सम्भावित सदस्यों को पूर्व सूचना हो कि ग्राम संगठन (VO) या संकुल (CLF) से उन को भुगतान किस दिन हो सकेगी',
                '6.18. सभी समूह के पास जानकारी के लिए और आवश्यक हो तो शिकायत करने के लिए कॉल सेंटर की व्यवस्था हो ताकि मिशन के मुख्यालय तक हमारी बात पहुँच सके ',
                '7. समूह के कुल कितने सदस्य को त्वरित ऋण की आवश्यकता है',
                '8. प्रति सदस्य औसत कितने रुपए की ऋण की आवश्यकता है'
            ));
            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    $model->shg != null ? $model->shg->name_of_shg : '',
                    $model->shg != null ? $model->shg->district_name : '',
                    $model->shg != null ? $model->shg->block_name : '',
                    $model->shg != null ? $model->shg->gram_panchayat_name : '',
                    $model->ques1,
                    $model->ques_2,
                    $model->ques_3,
                    $model->ques_4,
                    $model->ques5,
                    $model->ques6p1_1 != null ? 'Yes' : '',
                    $model->ques6p1_2 != null ? 'Yes' : '',
                    $model->ques6p1_3 != null ? 'Yes' : '',
                    $model->ques6p2_4 != null ? 'Yes' : '',
                    $model->ques6p2_5 != null ? 'Yes' : '',
                    $model->ques6p2_6 != null ? 'Yes' : '',
                    $model->ques6p2_7 != null ? 'Yes' : '',
                    $model->ques6p2_8 != null ? 'Yes' : '',
                    $model->ques6p2_9 != null ? 'Yes' : '',
                    $model->ques6p2_10 != null ? 'Yes' : '',
                    $model->ques6p2_11 != null ? 'Yes' : '',
                    $model->ques6p3_12 != null ? 'Yes' : '',
                    $model->ques6p3_13 != null ? 'Yes' : '',
                    $model->ques6p3_14 != null ? 'Yes' : '',
                    $model->ques6p3_15 != null ? 'Yes' : '',
                    $model->ques6p3_16 != null ? 'Yes' : '',
                    $model->ques6p3_17 != null ? 'Yes' : '',
                    $model->ques6p3_18 != null ? 'Yes' : '',
                    $model->ques_7,
                    $model->ques8,
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

    public function actionView($shgfeedbackid) {
        return $this->render('view', [
                    'model' => $this->findModel($shgfeedbackid),
        ]);
    }

    protected function findModel($id) {
        if (($model = RishtaShgFeedback::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

<?php

namespace bccallcenter\modules\clf\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use cbo\models\CboClf;
use cbo\models\CboClfSearch;
use cbo\models\CboClfFeedback;
use cbo\models\CboClfFeedbackSearch;
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
                'only' => ['index', 'downloadcsv', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'downloadcsv', 'view'],
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
        $searchModel = new CboClfFeedbackSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadcsv() {
        try {

            $searchModel = new CboClfFeedbackSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            $models = $dataProvider->getModels();
            $file = "CLF_feedback_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array(
                'Sr No',
                'Name of CLF',
                'District',
                'Block',
                '1. क्या अबतक मोबाइल ऐप को भरने/ एडिट करने में आपका अनुभव कैसा रहा?',
                '2. क्या संकुल के पदाधिकारी एवं लेखाकार में से किसी या सभी के पास टचवाला फ़ोन है?',
                '3. अगर किसी के पास टच वाला फ़ोन नहीं हैं तो मोबाइल ऐप का उपयोग कैसे करेंगे',
                '4. जब ये प्रश्नोत्तर आपके द्वारा भरा जा रहा है, उस समय संकुल के कितने पदाधिकारी/ सदस्य उपस्थित हैं?',
                '5. आप को संकुल के लेखा सम्बन्धी खाताबही के रखरखाव के लिए कौन सी व्यवस्था ज़्यादा आसान लगती है ?',
                '6.1. मोबाइल-ऐप पर लिखने का कष्ट नहीं रहेगा – सिर्फ़ टच से सही उत्तर चुनना होगा – जैसा अभी हम संकुल के ऐप पर कर रहें हैं ।',
                '6.2. मोबाइल पर खाता बही का सभी रिकार्ड रखना आसान होगा ।',
                '6.3. मोबाइल पर कार्य करने सुविधा होने से संकुल के बैठक में लम्बे समय तक रहने की बाध्यता नहीं होगी; समय बचेगा ।',
                '6.4. मोबाइल पर खाता बही की सुविधा होने से मिशन मैनेजर/ मिशन के अधिकारियों पर निर्भरता कम होगी – हम स्वयं सक्षम होंगे – बिना किसी के हस्तक्षेप के काम कर पाएँगे',
                '6.5. मोबाइल ऐप पर अंकगणित/ हिसाब करने सुविधाएँ उपलब्ध होंगी – ग़लतियाँ नहीं होगी ।',
                '6.6. और भी कई सुविधाएँ हो सकती हैं',
                '7. अगर इस तरह का मोबाइल ऐप लागू होता है तो क्या संकुल के कार्य में समय, ऊर्जा और खर्च बचेगा?',
                '8. क्या मोबाइल ऐप के लिए कोई शुल्क निर्धारित होना चाहिए?',
                '9.1. मोबाइल ऐप पर ही इसके संचालन के लिए उपयुक्त दिशा-निर्देश/ गाइडलाइन मिले ।',
                '9.2. राज्य मिशन से मिलनेवाले ऋणों व अन्य सुविधाओं की मोबाइल ऐप पर मैसज से पूर्व सूचना प्राप्त होना ।',
                '9.3. मोबाइल ऐप पर संकुल के खाता बही रखरखाव सम्बन्धी कार्य किया जा सके – रजिस्टर पर कार्य करने की आवश्यकता ना हो ।',
                '9.4. संकुल (CLF), ग्राम संगठन (VO), एवं समूह (SHG) स्तर पर ऋण के लेनदेन की पूरी रिकार्ड रखा जा सके । माहवार मूलधन व ब्याज सहित ऋण वापसी (EMI) की जानकारी मिले ।',
                '9.5. ऋण का भुगतान एवं ऋण वापसी की जानकारी का मैसज, ऋण देने व ऋण प्राप्त करने वाले दोनो को, मोबाइल ऐप पर ही मिले ।',
                '9.6. संकुल के खाताबही एवं अन्य सभी रिकार्ड का प्रिंट निकालने की सुविधा हो ।',
                '9.7. वित्तीय एवं डिजिटल साक्षरता सम्बन्धी सभी उपयोगी जानकारी उपलब्ध हो । प्रिंट निकालने की सुविधा हो ।',
                '9.8. मोबाइल ऐप प्रयोग करने पर अगर कोई शुल्क निर्धारित हो रहा हो तो उनका बिल एवं शुल्क भुगतान की रसीद ऐप पर ही मिले – ज़रूरत हो तो प्रिंट निकाला जा सके ।',
                '9.9. मोबाइल ऐप के उपयोग में असुविधा हो तों तत्काल मदद के लिए हेल्पलाइन की सुविधा हो',
                '10. आपने सभी प्रश्नों का जवाब कैसे भरा'
            ));
            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    $model->clf != null ? $model->clf->name_of_clf : '',
                    $model->clf != null ? $model->clf->district_name : '',
                    $model->clf != null ? $model->clf->block_name : '',
                    $model->ques1,
                    $model->ques2,
                    $model->ques3,
                    $model->ques4,
                    $model->ques5,
                    $model->ques_61 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_62 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_63 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_64 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_65 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_66 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques7,
                    $model->ques8,
                    ($model->ques_8 == 1 and $model->ques_91) ? $model->ques_91a : '',
                    ($model->ques_8 == 1 and $model->ques_92) ? $model->ques_92a : '',
                    ($model->ques_8 == 1 and $model->ques_93) ? $model->ques_93a : '',
                    ($model->ques_8 == 1 and $model->ques_94) ? $model->ques_94a : '',
                    ($model->ques_8 == 1 and $model->ques_95) ? $model->ques_95a : '',
                    ($model->ques_8 == 1 and $model->ques_96) ? $model->ques_96a : '',
                    ($model->ques_8 == 1 and $model->ques_97) ? $model->ques_97a : '',
                    ($model->ques_8 == 1 and $model->ques_98) ? $model->ques_98a : '',
                    ($model->ques_8 == 1 and $model->ques_99) ? $model->ques_99a : '',
                    $model->ques10
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

    public function actionView($feedbackid) {
        return $this->render('view', [
                    'model' => $this->findModel($feedbackid),
        ]);
    }

    protected function findModel($id) {
        if (($model = CboClfFeedback::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

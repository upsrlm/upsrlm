<?php

namespace bc\modules\selection\controllers;

use Yii;
use yii\web\Controller;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\modules\selection\models\form\DashboardSearchForm;

/**
 * Default controller for the `nfsaSurvey` module
 */
class BcdataController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index',],
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
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM,MasterRole::ROLE_MD,MasterRole::ROLE_DIVISIONAL_COMMISSIONER,MasterRole::ROLE_RSETIS_STATE_UNIT,MasterRole::ROLE_RSETIS_DISTRICT_UNIT,MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new MasterDistrictSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity);
        return $this->render('district', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        return $this->render('index');
    }

    public function actionReportpdf() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM,MasterRole::ROLE_MD,MasterRole::ROLE_DIVISIONAL_COMMISSIONER,MasterRole::ROLE_RSETIS_STATE_UNIT,MasterRole::ROLE_RSETIS_DISTRICT_UNIT,MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        date_default_timezone_set("Asia/Calcutta");
        $this->layout = 'pdf';

        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->verify($searchModel, Yii::$app->user->identity, false);
        //$dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, false);
        $block = \bc\models\master\MasterBlock::findOne(['block_code' => $searchModel->block_code]);
        $file_name = $block->district_name . " (" . $block->block_name . ")_BC";
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 9,
            'default_font' => 'freesans',
            'margin_header' => 0,
            'margin_footer' => 10,
        ]);

        $mpdf->SetHeader('<table style="width:100%;vertical-align: top;border:none">
            <tr>
            <td style="vertical-align: top;border:none"><img width="40px" src="/images/sgrca_logo.png"></td>
            <td style="vertical-align: top;border:none;color: #F79520;margin-top: 2px;margin-bottom: 4px;">State Rural Livelihood Mission : Selection of BC Sakhi
            <br/>District (Block) : ' . $block->district_name . ' (' . $block->block_name . ')
            </td>
            
<tr>
</table>');
        $mpdf->setFooter('{PAGENO} / {nb}');
        if ($mpdf->PageNo() == 1) {
            
        }



        $content = $this->renderPartial('report_pdf', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        $html = '<style>
            
table {
  width:100%;
}
table, th, td {
  border: 1px solid grey;
  border-collapse: collapse;
}
th, td {
  padding: 3px;
  text-align: left;
}
table#t01 tr:nth-child(even) {
  background-color: #eee;
}
table#t01 tr:nth-child(odd) {
 background-color: #fff;
}
table#t01 th {
  background-color: black;
  color: white;
}
</style>';
        $html .= $content;


        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($file_name . '.pdf', 'D');
        exit;
    }

}

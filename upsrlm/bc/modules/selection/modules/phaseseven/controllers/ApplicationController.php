<?php

namespace bc\modules\selection\modules\phaseseven\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use yii\grid\GridView;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\SrlmBcApplication7;
use bc\modules\selection\models\SrlmBcApplication7Search;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcSelectionUserSearch;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\models\master\MasterGramPanchayatSearch;
use common\models\master\MasterRole;
use bc\modules\selection\components\BcApplication;

ini_set('max_execution_time', 1200);
ini_set('memory_limit', '-1');

/**
 * Bcselection controller for the `srlm` module
 */
class ApplicationController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'pdf', 'list', 'listdownload', 'report', 'singleapplication', 'highestscore', 'selected', 'reportpdf', 'validateform', 'dublicate'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'pdf', 'list', 'listdownload', 'report', 'singleapplication', 'highestscore', 'selected', 'reportpdf', 'validateform', 'dublicate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {

        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplication7Search();
        if ($searchModel->section_at) {
            $searchModels->form_number = $searchModel->section_at;
        }
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['!=', 'form_number', '0']);

        return $this->render('index_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList() {

        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplication7Search();
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $models = $dataProvider->getModels();

        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['!=', 'already_group_member', '1']);
        return $this->render('list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListdownload() {

        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplication7Search();

        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere(['!=', 'already_group_member', '1']);
        $count = $dataProvider->query->count();
        $models = $dataProvider->getModels();
        $file = "BC_Sakhi_List_" . date("Y_m_d_H-m-s") . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'District', 'Block', 'GP', 'Name', 'Guardian Name', 'Mobile Number', 'Otp Verified Mobile No', 'Phone no. of other member of SHG 1', 'Phone no. of other member of SHG 2', 'Phone no. of other member of SHG 3', 'Phone no. of other member of SHG 4', 'Phone no. of other member of SHG 5'));
        $sr_no = 1;
        $row = [];
        foreach ($models as $model) {
            $model = SrlmBcApplication6::findOne($model['id']);
            $row = [
                $sr_no,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->name,
                $model->guardian_name,
                $model->mobile_number,
                $model->user != null ? $model->user->mobile_no : '',
                isset($model->family[0]) ? $model->family[0]->mobile_no : '',
                isset($model->family[1]) ? $model->family[1]->mobile_no : '',
                isset($model->family[2]) ? $model->family[2]->mobile_no : '',
                isset($model->family[3]) ? $model->family[3]->mobile_no : '',
                isset($model->family[4]) ? $model->family[4]->mobile_no : ''
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit();
    }

    public function actionReport() {

        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplication7Search();
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $models = $dataProvider->getModels();

        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        return $this->render('report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSingleapplication() {

        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModel->singleapplication = 1;
        $searchModels = new SrlmBcApplication7Search();
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $models = $dataProvider->getModels();

        $district_option_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['district_code', 'district_name'])->distinct('district_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['and',
                    ['master_gram_panchayat_detail_bc.seventh_vacant' => 1],
                ])->all();
        $block_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['block_code', 'block_name'])->distinct('block_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['and',
            ['master_gram_panchayat_detail_bc.seventh_vacant' => 1],
        ]);
        if ($searchModel->district_code) {
            $block_model->andWhere(['district_code' => $searchModel->district_code]);
        }
        $block_option_model = $block_model->all();
        $searchModel->district_option = \yii\helpers\ArrayHelper::map($district_option_model, 'district_code', 'district_name');
        $searchModel->block_option = \yii\helpers\ArrayHelper::map($block_option_model, 'block_code', 'block_name');
        if ($searchModel->block_code) {
            $gp_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['master_gram_panchayat.gram_panchayat_code', 'gram_panchayat_name'])->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['and',
                ['master_gram_panchayat_detail_bc.seventh_vacant' => 1],
            ]);
            if ($searchModel->district_code) {
                $gp_model->andWhere(['district_code' => $searchModel->district_code]);
            }
            $gp_model->andWhere(['block_code' => $searchModel->block_code]);
            $gp_option_model = $gp_model->all();
            $searchModel->gp_option = \yii\helpers\ArrayHelper::map($gp_option_model, 'gram_panchayat_code', 'gram_panchayat_name');
        }
        return $this->render('singleapplication', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHighestscore() {

        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModel->highest_score_in_gp = 1;
        $searchModels = new SrlmBcApplication7Search();
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $models = $dataProvider->getModels();

        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        return $this->render('highestscore', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
//        try {  
        $model = $this->findModel($id);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
            ]);
        }
//         } catch (\Exception $ex) {
//             print_r($ex->getMessage());
//        }
    }

    public function actionValidateform($id) {
        $bc_model = $this->findModel($id);
        if ($bc_model->form_data_validate != '0') {
            return $this->redirect(['/selection/phase7/application?DashboardSearchForm[form_data_validate]=0']);
        }

        $model = new \bc\modules\selection\modules\phaseseven\models\form\ValidateByTliForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $model->bc_model->form_data_validate = $model->form_data_validate;

                if ($model->bc_model->save()) {
                    \Yii::$app->getSession()->setFlash('success', 'Application form validation successfully');
                    $t = [];

                    $t = SrlmBcApplication7::find()->where(['form_number' => 6, 'form_data_validate' => 0])->one();

                    if (!empty($t)) {
                        return $this->redirect('/selection/phase7/application/view?id=' . $t->id);
                    } else {
                        return $this->redirect(['/selection/phase7/application?DashboardSearchForm[form_data_validate]=0']);
                    }
                }
            }
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('validate_by_tli_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('validate_by_tli_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDublicate() {

        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModel->second_vacant = 1;
        $searchModels = new SrlmBcApplication7Search();
        $dataProvider = $searchModels->dublicate($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        return $this->render('dublicate', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPdf($id) {
        date_default_timezone_set("Asia/Calcutta");
        $this->layout = 'pdf';

        $model = $this->findModel($id);
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 9,
            'default_font' => 'freesans',
            'margin_header' => 0,
            'margin_footer' => 10,
        ]);

        $mpdf->SetHeader('<table style="width:100%;vertical-align: top;border:none">
            <tr>
            <td style="vertical-align: top;border:none"><img width="40px" src="/images/sgrca_logo.png"></td>
            <td style="vertical-align: top;border:none;color: #F79520;margin-top: 2px;margin-bottom: 4px;">State Rural Livelihood Mission : Selection of BC Sakhi</td>
            
<tr>
</table>');
        $mpdf->setFooter('{PAGENO} / {nb}');
        if ($mpdf->PageNo() == 1) {
            
        }



        $content = $this->renderPartial('_pdf', ['model' => $model]);

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
        $mpdf->Output($model->name . '.pdf', 's');
        exit;
    }

    public function actionReportpdf() {
        date_default_timezone_set("Asia/Calcutta");
        $this->layout = 'pdf';
        $file_name = "srlm_bc_selection_report_" . date("Y_m_d_H-m-s");
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplication7Search();
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, false);
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 9,
            'default_font' => 'freesans',
            'margin_header' => 0,
            'margin_footer' => 10,
        ]);

        $mpdf->SetHeader('<table style="width:100%;vertical-align: top;border:none">
            <tr>
            <td style="vertical-align: top;border:none"><img width="40px" src="/images/sgrca_logo.png"></td>
            <td style="vertical-align: top;border:none;color: #F79520;margin-top: 2px;margin-bottom: 4px;">State Rural Livelihood Mission : Selection of BC Sakhi</td>
            
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

    public function actionDistrictgp($no = 0) {

        $district_query = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['district_code', 'district_name'])->distinct('district_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['master_gram_panchayat_detail_bc.seventh_vacant' => 1]);
        if ($no) {
            $district_query->andWhere(['master_gram_panchayat_detail_bc.seventh_vacant' => 0]);
        }
        $district_model = $district_query->orderBy('district_name asc')->all();
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $district_model,
            'pagination' => false,
        ]);
        return $this->render('districtgp', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBlock($no = 0) {

        $district_query = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['block_code', 'block_name', 'district_name'])->distinct('block_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['master_gram_panchayat_detail_bc.seventh_vacant' => 1]);
        if ($no) {
            $district_query->andWhere(['master_gram_panchayat_detail_bc.seventh_complete' => 0]);
        }
        $district_model = $district_query->orderBy('district_name asc,block_name asc')->all();
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $district_model,
            'pagination' => false,
        ]);
        return $this->render('block', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGp() {

        $searchModel = new MasterGramPanchayatSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $dataProvider->query->andWhere(['master_gram_panchayat_detail_bc.seventh_vacant' => 1]);
        if ($searchModel->seventh_complete != '') {
            $dataProvider->query->andWhere(['master_gram_panchayat_detail_bc.seventh_complete' => $searchModel->seventh_complete]);
        }
        $dataProvider->query->orderBy(['district_name' => SORT_ASC, 'block_name' => SORT_ASC, 'gram_panchayat_name' => SORT_ASC]);
        $district_option_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['district_code', 'district_name'])->distinct('district_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['and',
                    ['master_gram_panchayat_detail_bc.seventh_vacant' => 1],
                ])->all();
        $block_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['block_code', 'block_name'])->distinct('block_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['and',
            ['master_gram_panchayat_detail_bc.seventh_vacant' => 1],
        ]);
        if ($searchModel->district_code) {
            $block_model->andWhere(['district_code' => $searchModel->district_code]);
        }
        $block_option_model = $block_model->all();
        $searchModel->district_option = \yii\helpers\ArrayHelper::map($district_option_model, 'district_code', 'district_name');
        $searchModel->block_option = \yii\helpers\ArrayHelper::map($block_option_model, 'block_code', 'block_name');
        if ($searchModel->block_code) {
            $gp_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['master_gram_panchayat.gram_panchayat_code', 'gram_panchayat_name'])->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['and',
                ['master_gram_panchayat_detail_bc.seventh_vacant' => 1],
            ]);
            if ($searchModel->district_code) {
                $gp_model->andWhere(['district_code' => $searchModel->district_code]);
            }
            $gp_model->andWhere(['block_code' => $searchModel->block_code]);
            $gp_option_model = $gp_model->all();
            $searchModel->gp_option = \yii\helpers\ArrayHelper::map($gp_option_model, 'gram_panchayat_code', 'gram_panchayat_name');
        }
        return $this->render('gp', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPdfgp() {
        $this->layout = 'pdf';

        $searchModel = new MasterGramPanchayatSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);

        $dataProvider->query->andWhere(['master_gram_panchayat_detail_bc.seventh_vacant' => 1]);
        if ($searchModel->seventh_complete != '') {
            $dataProvider->query->andWhere(['master_gram_panchayat_detail_bc.seventh_complete' => $searchModel->seventh_complete]);
        }
        $dataProvider->query->orderBy(['district_name' => SORT_ASC, 'block_name' => SORT_ASC, 'gram_panchayat_name' => SORT_ASC]);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 9,
            'default_font' => 'freesans',
            'margin_header' => 0,
            'margin_footer' => 10,
        ]);

        $mpdf->SetHeader('<table style="width:100%;vertical-align: top;border:none">
            <tr>
            <td style="vertical-align: top;border:none"><img width="40px" src="/images/sgrca_logo.png"></td>
            <td style="vertical-align: top;border:none;color: #F79520;margin-top: 2px;margin-bottom: 4px;">Uttar Pradesh State Rural Livelihood Mission : Selection of BC Sakhi</td>
            
<tr>
</table>');
        $mpdf->setFooter('{PAGENO} / {nb}');
        if ($mpdf->PageNo() == 1) {
            
        }



        $content = $this->renderPartial('pdfgrampanchayat', [
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
        $mpdf->Output('srlm_bc_selection_gp_' . date('d-m-Y-h-i-s') . '.pdf', 'D');
        exit;
    }

    public function actionCsvgp() {
        $searchModel = new MasterGramPanchayatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);

        $dataProvider->query->andWhere(['master_gram_panchayat_detail_bc.seventh_vacant' => 1]);
        if ($searchModel->seventh_complete != '') {
            $dataProvider->query->andWhere(['master_gram_panchayat_detail_bc.seventh_complete' => $searchModel->seventh_complete]);
        }
        $dataProvider->query->orderBy(['district_name' => SORT_ASC, 'block_name' => SORT_ASC, 'gram_panchayat_name' => SORT_ASC]);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $count = $dataProvider->query->count();
        if ($count <= \bc\modules\selection\models\base\GenralModel::MAX_ROW_DOWNLOAD_CSV) {

            $models = $dataProvider->getModels();
            $temp_data = "#,"
                    . "Gram Panchayat Name,"
                    . "Block Name,"
                    . "District,"
                    . "Application Complete\n";
            $file_name = "srlm_bc_selection_gp_" . date("Y_m_d_H-m-s");
            $filePath = Yii::$app->params['tmp'] . $file_name . ".csv";
            $fp = fopen($filePath, 'a+');
            $sr_no = 1;
            foreach ($models as $model) {
                $gp_name = '"' . $model->gram_panchayat_name . '"';
                $block_name = '"' . $model->block_name . '"';
                $district_name = '"' . $model->district_name . '"';
                $application_complete = $model->gpdetail->six_complete;

                $temp_data .= "$sr_no,"
                        . "$gp_name,"
                        . "$block_name,"
                        . "$district_name,"
                        . "$application_complete\n";
                $sr_no++;
            }

            fwrite($fp, $temp_data);
            fclose($fp);

            header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
            header("Content-Type: application/csv");
            header("Content-Length: " . filesize($filePath));
            header("Content-Disposition: attachment; filename=$file_name.csv");
            readfile($filePath);
            exit();
        } else {
            $this->flash_message = 'It is too large to  download results <br> It must be less than ' . GenralModel::MAX_ROW_DOWNLOAD_CSV . ' results'; //'You are try downloading larger data please .';
            \Yii::$app->getSession()->setFlash('error', \Yii::t('user', $this->flash_message));
            if (isset(\Yii::$app->request->referrer)) {
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }
    }

    /**
     * Finds the NfsaBaseSurvey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NfsaBaseSurvey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SrlmBcApplication7::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

<?php

namespace bc\modules\selection\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\SrlmBcApplicationHistory;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcSelectionUserSearch;
use bc\modules\selection\models\form\DownloadCSVForm;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\models\master\MasterGramPanchayatSearch;
use bc\modules\selection\models\base\GenralModel;

date_default_timezone_set("Asia/Calcutta");

/**
 * Default controller for the `srlm` module
 */
class ApplicationController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['dublicate','district','districtgp', 'block', 'grampanchayat', 'pdfdistrict', 'pdfblock', 'pdfgp', 'csvdistrict', 'csvblock', 'csvgp'],
                'rules' => [
                    [
                        'actions' => ['dublicate','district','districtgp', 'block', 'grampanchayat', 'pdfdistrict', 'pdfblock', 'pdfgp', 'csvdistrict', 'csvblock', 'csvgp'],
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

    public function actionDublicate() {
        if (Yii::$app->user->identity->role == MasterRole::ROLE_DM) {
            return $this->redirect(['/selection/preselected']);
        }
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->dublicate($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        return $this->render('dublicate', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDistrict() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $searchModel = new MasterDistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        return $this->render('district', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDistrictgp() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $searchModel = new MasterDistrictSearch();
        if (Yii::$app->user->identity->role == MasterRole::ROLE_DM) {
            return $this->redirect(['/selection/preselected']);
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        return $this->render('districtgp', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCsvdistrictgp() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        if (Yii::$app->user->identity->role == MasterRole::ROLE_DM) {
            return $this->redirect(['/selection/preselected']);
        }
        $searchModel = new MasterDistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        $count = $dataProvider->query->count();
        if ($count <= GenralModel::MAX_ROW_DOWNLOAD_CSV) {

            $models = $dataProvider->getModels();
            $temp_data = "#,District Code,"
                    . "District,"
                    . "No of GPs,"
                    . "No of GPs with zero registration\n";
            $file_name = "srlm_bc_selection_district_gp_" . date("Y_m_d_H-m-s");
            $filePath = Yii::$app->params['tmp'] . $file_name . ".csv";
            $fp = fopen($filePath, 'a+');
            $sr_no = 1;
            foreach ($models as $model) {
                $district_code = '"' . $model->district_code . '"';
                $district_name = '"' . $model->district_name . '"';
                $total_gp = $model->getGp()->count();
                $no_reg_gp = $model->getGpnoreg()->count();

                $temp_data .= "$sr_no,"
                        . "$district_code,"
                        . "$district_name,"
                        . "$total_gp,"
                        . "$no_reg_gp\n";
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

    public function actionPdfdistrictgp() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $this->layout = 'pdf';

        $searchModel = new MasterDistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
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



        $content = $this->renderPartial('pdfdistrictgp', [
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
        $mpdf->Output('srlm_bc_selection_district_gp_' . date('d-m-Y-h-i-s') . '.pdf', 'D');
        exit;
    }

    public function actionCsvdistrict() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $searchModel = new MasterDistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        $count = $dataProvider->query->count();
        if ($count <= GenralModel::MAX_ROW_DOWNLOAD_CSV) {

            $models = $dataProvider->getModels();
            $temp_data = "#,District Code,"
                    . "District,"
                    . "Total Registration,"
                    . "Registration Start,"
                    . "Application Complete\n";
            $file_name = "srlm_bc_selection_district_" . date("Y_m_d_H-m-s");
            $filePath = Yii::$app->params['tmp'] . $file_name . ".csv";
            $fp = fopen($filePath, 'a+');
            $sr_no = 1;
            foreach ($models as $model) {
                $district_code = '"' . $model->district_code . '"';
                $district_name = '"' . $model->district_name . '"';
                $total_reg = $model->getBcall()->count();
                $reg_start = $model->getBasicprofile()->count();
                $application_complete = $model->getPart4()->count();

                $temp_data .= "$sr_no,"
                        . "$district_code,"
                        . "$district_name,"
                        . "$total_reg,"
                        . "$reg_start,"
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

    public function actionPdfdistrict() {
        $this->layout = 'pdf';

        $searchModel = new MasterDistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
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



        $content = $this->renderPartial('pdfdistrict', [
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
        $mpdf->Output('srlm_bc_selection_district_' . date('d-m-Y-h-i-s') . '.pdf', 'D');
        exit;
    }

    public function actionBlock() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $searchModel = new MasterBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        return $this->render('block', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPdfblock() {
        $this->layout = 'pdf';

        $searchModel = new MasterBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
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



        $content = $this->renderPartial('pdfblock', [
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
        $mpdf->Output('srlm_bc_selection_block_' . date('d-m-Y-h-i-s') . '.pdf', 'D');
        exit;
    }

    public function actionCsvblock() {
        $searchModel = new MasterBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        $count = $dataProvider->query->count();
        if ($count <= GenralModel::MAX_ROW_DOWNLOAD_CSV) {

            $models = $dataProvider->getModels();
            $temp_data = "#,District,"
                    . "Block Name,"
                    . "Total Registration,"
                    . "Registration Start,"
                    . "Application Complete\n";
            $file_name = "srlm_bc_selection_block_" . date("Y_m_d_H-m-s");
            $filePath = Yii::$app->params['tmp'] . $file_name . ".csv";
            $fp = fopen($filePath, 'a+');
            $sr_no = 1;
            foreach ($models as $model) {
                $district_name = '"' . $model->district_name . '"';
                $block_name = '"' . $model->block_name . '"';
                $total_reg = $model->getBcall()->count();
                $reg_start = $model->getBasicprofile()->count();
                $application_complete = $model->getPart4()->count();

                $temp_data .= "$sr_no,"
                        . "$district_name,"
                        . "$block_name,"
                        . "$total_reg,"
                        . "$reg_start,"
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

    public function actionGrampanchayat() {
        if (Yii::$app->user->identity->role == MasterRole::ROLE_DM) {
            return $this->redirect(['/selection/preselected']);
        }
        $searchModel = new MasterGramPanchayatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        return $this->render('grampanchayat', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPdfgp() {
        $this->layout = 'pdf';

        $searchModel = new MasterGramPanchayatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
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
        $count = $dataProvider->query->count();
        if ($count <= GenralModel::MAX_ROW_DOWNLOAD_CSV) {

            $models = $dataProvider->getModels();
            $temp_data = "#,"
                    . "Gram Panchayat Name,"
                    . "Block Name,"
                    . "District,"
                    . "Total Registration,"
                    . "Registration Start,"
                    . "Application Complete\n";
            $file_name = "srlm_bc_selection_gp_" . date("Y_m_d_H-m-s");
            $filePath = Yii::$app->params['tmp'] . $file_name . ".csv";
            $fp = fopen($filePath, 'a+');
            $sr_no = 1;
            foreach ($models as $model) {
                $gp_name = '"' . $model->gram_panchayat_name . '"';
                $block_name = '"' . $model->block_name . '"';
                $district_name = '"' . $model->district_name . '"';
                $total_reg = $model->getBcall()->count();
                $reg_start = $model->getBasicprofile()->count();
                $application_complete = $model->getPart4()->count();

                $temp_data .= "$sr_no,"
                        . "$gp_name,"
                        . "$block_name,"
                        . "$district_name,"
                        . "$total_reg,"
                        . "$reg_start,"
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

    public function actionPdfnotreggp() {
        $this->layout = 'pdf';
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new MasterGramPanchayatSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false);
        $dataProvider->query->joinWith(['bcall']);
        $dataProvider->query->andWhere(['srlm_bc_application.id' => null]);
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



        $content = $this->renderPartial('pdfnotreggrampanchayat', [
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
        $mpdf->Output('srlm_bc_selection_zero_registration_gp_' . date('d-m-Y-h-i-s') . '.pdf', 'D');
        exit;
    }

    public function actionCsvnotreggp() {
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new MasterGramPanchayatSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false);
        $dataProvider->query->joinWith(['bcall']);
        $dataProvider->query->andWhere(['srlm_bc_application.id' => null]);
        $count = $dataProvider->query->count();
        $models = $dataProvider->getModels();
        $file = "srlm_bc_application_not_start_registration_" . date("Y_m_d_H-m-s") . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Gram Panchayat Name', 'Block Name', 'District', 'Total Registration'));
        $sr_no = 1;
        $row = [];
        foreach ($models as $model) {
            $row = [
                $sr_no,
                $model->gram_panchayat_name,
                $model->block_name,
                $model->district_name,
                $model->getBcall()->count(),
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit();
    }

    public function actionCsvstartnotcomgp() {
        try {


            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat.gram_panchayat_code' => ArrayHelper::getColumn(SrlmBcApplication::find()->select('gram_panchayat_code')->where(['srlm_bc_application.form_number' => 6])->asArray()->all(), 'gram_panchayat_code')]]);
            $dataProvider->query->joinWith(['bcalls']);
            $dataProvider->query->andWhere(['!=', 'srlm_bc_application.form_number', '0']);
            $dataProvider->query->andWhere(['!=', 'srlm_bc_application.form_number', '6']);
            $dataProvider->query->andWhere(['<', 'srlm_bc_application.form_number', '6']);
            $count = $dataProvider->query->count();
            $models = $dataProvider->getModels();
            $file = "srlm_bc_application_start_registration_but_incomplete_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Gram Panchayat Name', 'Block Name', 'District', 'Total Registration', 'OTP Verified mobile no'));
            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $t = '';
                foreach ($model->bcalls as $bc) {
                    $t .= $bc->user->mobile_no . ' ,';
                }
                $row = [
                    $sr_no,
                    $model->gram_panchayat_name,
                    $model->block_name,
                    $model->district_name,
                    $model->getBcall()->count(),
                    rtrim($t, ','),
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

    public function actionRegistration() {
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels1 = new MasterDistrictSearch();
        $dataProvider1 = $searchModels1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size100']);
        $dataProvider1->query->joinWith(['bcall']);
        $dataProvider1->query->andWhere(['srlm_bc_application.id' => null]);
        $searchModels2 = new MasterBlockSearch();
        $dataProvider2 = $searchModels2->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size100']);
        $dataProvider2->query->joinWith(['bcall']);
        $dataProvider2->query->andWhere(['srlm_bc_application.id' => null]);
        $dataProvider2->query->orderBy(['district_name' => 'asc', 'block_name' => 'asc']);
        $searchModels3 = new MasterGramPanchayatSearch();
        $dataProvider3 = $searchModels3->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size100']);
        $dataProvider3->query->joinWith(['bcall']);
        $dataProvider3->query->andWhere(['srlm_bc_application.id' => null]);
        $searchModels4 = new MasterGramPanchayatSearch();
        $dataProvider4 = $searchModels4->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size100']);
        $dataProvider4->query->andWhere(['NOT', ['master_gram_panchayat.gram_panchayat_code' => ArrayHelper::getColumn(SrlmBcApplication::find()->select('gram_panchayat_code')->where(['srlm_bc_application.form_number' => 6])->asArray()->all(), 'gram_panchayat_code')]]);
        $dataProvider4->query->joinWith(['bcalls']);
        $dataProvider4->query->distinct('srlm_bc_application.gram_panchayat_code');
        $dataProvider4->query->andWhere(['!=', 'srlm_bc_application.form_number', '0']);
        $dataProvider4->query->andWhere(['!=', 'srlm_bc_application.form_number', '6']);
        $dataProvider4->query->andWhere(['<', 'srlm_bc_application.form_number', '6']);

        $button_type = isset($_REQUEST['button_type']) ? ($_REQUEST['button_type']) : "";
        if ($button_type == "1") {
            \Yii::$app->params['title'] = $button_type . '. District with zero registration';
            \Yii::$app->params['class'] = 'widget-box widget-color-blue';

            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . '. Block with zero registration';
            \Yii::$app->params['class'] = 'widget-box widget-color-green';
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "3") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . '. GP not start registration';
            \Yii::$app->params['class'] = 'widget-box widget-color-blue';
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "4") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . '. GP start registration but incomplete ';
            \Yii::$app->params['class'] = 'widget-box widget-color-green';
            $dataProvider = $dataProvider4;
        }

        return $this->render('registration', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4,
        ]);
    }

    public function actionRegistereduser() {
        $csv_data = \bc\modules\selection\models\BcApplicationCrone::findOne(1);
        $searchModel = new SrlmBcSelectionUserSearch();
        $searchModel->csv_data = $csv_data;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);

        return $this->render('registereduser', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadcsvgp() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        $searchModel = new MasterGramPanchayatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
//        $dataProvider->query->joinWith(['bcall']);
//        $dataProvider->query->andWhere(['srlm_bc_application.id' => null]);
        $count = $dataProvider->query->count();

        $models = $dataProvider->getModels();
        $file = "srlm_bc_application_gp" . time() . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Gram Panchayat Name', 'Block Name', 'District', 'Application submitted', 'Complete applications', 'Complete applications female', 'SC / ST', 'OBC', 'General'));
        $sr_no = 1;
        $row = [];
        foreach ($models as $model) {
            $row = [
                $sr_no,
                $model->gram_panchayat_name,
                $model->block_name,
                $model->district_name,
                $model->getBcalls()->count(),
                $model->getComp()->count(),
                $model->getComp()->andWhere(['gender' => 2])->count(),
                $model->getComp()->andWhere(['gender' => 2, 'cast' => 1])->count(),
                $model->getComp()->andWhere(['gender' => 2, 'cast' => 2])->count(),
                $model->getComp()->andWhere(['gender' => 2, 'cast' => 3])->count()
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit();
    }

    public function actionDownload() {
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '1024M');
        $file_name = "registered_user";
        $filePath = \Yii::$app->params['datapath'] . 'srlm/bcselection/report/' . $file_name . ".csv";
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        header("Content-Type: application/csv");
        header("Content-Length: " . filesize($filePath));
        header("Content-Disposition: attachment; filename=$file_name.csv");
        readfile($filePath);
        exit();
    }

    public function actionIncomreg() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        if ($searchModel->section_at) {
            $searchModels->form_number = $searchModel->section_at;
        }
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider->query->andWhere(['<', 'form_number', '6']);
        $file_name = "srlm_bc_selection_incomplete_applications_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Aadhar Number', 'Gender', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Section At', 'Started Filling Form On', 'Number of completed on the basic of mobile number', 'Number of completed on the basic of aadhar number', 'OTP Verified mobile no'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
            $gender = $model->genderrel != null ? $model->genderrel->name_eng : '';
            $cast = $model->castrel != null ? $model->castrel->name_eng : '';
            $form_start_date = $model->form_start_date != null ? $model->form_start_date : '';
            $row = [
                $sr_no,
                $model->name,
                $model->guardian_name,
                $model->mobile_number,
                common\helpers\Utility::maskaadhar($model->aadhar_number),
                $gender,
                $model->age,
                $cast,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->village_name,
                $model->hamlet,
                $model->form_number,
                $form_start_date,
                SrlmBcApplication::find()->select('id')->where(['mobile_number' => $model->mobile_number, 'form_number' => 6])->asArray()->count(),
                SrlmBcApplication::find()->select('id')->where(['aadhar_number' => $model->aadhar_number, 'form_number' => 6])->asArray()->count(),
                $model->user->mobile_no,
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

    public function actionFormnotstart() {
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '2048M');
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();

        $searchModels->form_number = 0;

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere(['=', 'form_number', '0']);
        $file_name = "srlm_bc_selection_form_not_statrted_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'OTP Verified mobile no', 'OTP Verified On'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
            $row = [
                $sr_no,
                $model->user->mobile_no,
                \Yii::$app->formatter->asDatetime($model->user->created_at, "php:d-M-Y h:i:sa"),
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

    public function actionDownloadcomplete() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        date_default_timezone_set("Asia/Calcutta");
        $model = new DownloadCSVForm();
        $model->total = SrlmBcApplication::find()->select('id')
                        ->andWhere(['!=', 'form_number', '0'])
                        ->andWhere(['=', 'form_number', '6'])
                        ->andWhere(['=', 'gender', '2'])
                        ->orderBy(['id' => SORT_ASC])
                        ->asArray()->count();
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            //print $model->end . $model->start; exit;
            if ($model->end - $model->start > 10000) {
                //throw new NotFoundHttpException('Invalid range selection.  Max of 10,000 recods can be downlaoded at a time.');
            }
            $models = SrlmBcApplication::find()->select('id')
                            ->andWhere(['!=', 'form_number', '0'])
                            ->andWhere(['=', 'form_number', '6'])
                            ->andWhere(['=', 'gender', '2'])
                            ->orderBy(['id' => SORT_ASC])
                            ->limit($model->end - $model->start + 1)
                            ->offset($model->start - 1)
                            ->asArray()->all();
            $file_name = "srlm_bc_selection_complete_applications_" . date("Y_m_d_H-m-s") . '.csv';
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $sr_no = 1;
            foreach ($models as $model) {
                $model = SrlmBcApplication::findOne($model['id']);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->user->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        }
        return $this->render('csvdownload', [
                    'model' => $model,
        ]);
    }

    public function actionDownloadcomapplication() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        date_default_timezone_set("Asia/Calcutta");
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $file_name = "srlm_bc_selection_complete_applications_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
            $cast = $model->castrel != null ? $model->castrel->name_eng : '';
            $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
            $row = [
                $sr_no,
                $model->name,
                $model->guardian_name,
                $model->mobile_number,
                $model->age,
                $cast,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->village_name,
                $model->hamlet,
                $form_end_date,
                $model->user->mobile_no,
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

    public function actionDelete($id) {
        $model = SrlmBcApplication::findOne([$id]);
        $model->status = -1;
        $model->save();
        $condition = ['and',
            ['=', 'parent_id', $model->id],
        ];
        SrlmBcApplicationHistory::updateAll([
            'status' => -1,
                ], $condition);
        \Yii::$app->getSession()->setFlash('success', 'successfully deleted');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDownloadselectedapplication() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        date_default_timezone_set("Asia/Calcutta");
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        // $dataProvider->query->andWhere(['status'=> SrlmBcApplication::STATUS_SELECTED]);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $file_name = "srlm_bc_selection_selected_applications_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
            $cast = $model->castrel != null ? $model->castrel->name_eng : '';
            $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
            $row = [
                $sr_no,
                $model->name,
                $model->guardian_name,
                $model->mobile_number,
                $model->age,
                $cast,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->village_name,
                $model->hamlet,
                $form_end_date,
                $model->user->mobile_no,
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

}

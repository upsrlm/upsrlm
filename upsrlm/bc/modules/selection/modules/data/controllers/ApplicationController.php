<?php

namespace bc\modules\selection\modules\data\controllers;

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
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcSelectionUserSearch;
use common\models\master\MasterDistrictSearch;
use common\models\master\MasterBlockSearch;
use common\models\master\MasterGramPanchayatSearch;
use common\models\master\MasterRole;
use bc\modules\selection\components\BcApplication;

/**
 * Bcselection controller for the `srlm` module
 */
class ApplicationController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'pdf', 'list', 'listdownload', 'report', 'singleapplication', 'highestscore', 'selected', 'reportpdf'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'pdf', 'list', 'listdownload', 'report', 'singleapplication', 'highestscore', 'selected', 'reportpdf'],
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
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['!=', 'form_number', '0']);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $models = $dataProvider->getModels();
        if (!empty($models)) {
            foreach ($models as $model) {
                $bc_application = new BcApplication($model->id);
                $bc_application->calculaterating();
            }
        }
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['!=', 'already_group_member', '1']);
        return $this->render('list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListdownload() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();

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
            $model = SrlmBcApplication::findOne($model['id']);
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
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }

        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $models = $dataProvider->getModels();
        if (!empty($models)) {
            foreach ($models as $model) {
                $bc_application = new BcApplication($model->id);
                $bc_application->calculaterating();
            }
        }
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        return $this->render('report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSingleapplication() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModel->singleapplication = 1;
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $models = $dataProvider->getModels();
        if (!empty($models)) {
            foreach ($models as $model) {
                $bc_application = new BcApplication($model->id);
                $bc_application->calculaterating();
            }
        }
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        return $this->render('singleapplication', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHighestscore() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModel->highest_score_in_gp = 1;
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $models = $dataProvider->getModels();
        if (!empty($models)) {
            foreach ($models as $model) {
                $bc_application = new BcApplication($model->id);
                $bc_application->calculaterating();
            }
        }
        $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        return $this->render('highestscore', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

//    public function actionSelected($id) {
//        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
//            return $this->redirect(['/selection/preselected']);
//        }
//        $application_model = $this->findModel($id);
//        if (in_array($application_model->status, [SrlmBcApplication::STATUS_RECIEVED, SrlmBcApplication::STATUS_PROVISIONAL, SrlmBcApplication::STATUS_STAND_BY_1, SrlmBcApplication::STATUS_STAND_BY_2]) and $application_model->form_number == 6 and $application_model->gender == 2) {
//            $application_model->status = SrlmBcApplication::STATUS_SELECTED;
//            $application_model->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//            $application_model->selection_by = Yii::$app->user->identity->id;
//            $application_model->selection_datetime = new \yii\db\Expression('NOW()');
//            $application_model->gp->selected_application_id = $application_model->id;
//            $application_model->updated_at = time();
//            if ($application_model->update() and $application_model->gp->update()) {
//                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Applicant slected successfuly'));
//                return $this->redirect('/selection/data/application/view?id=' . $id);
//            }
//        } else {
//            \Yii::$app->getSession()->setFlash('error', \Yii::t('user', 'Invalid action'));
//            return $this->redirect('/selection/data/application/view?id=' . $id);
//        }
//    }

//    public function actionStandby1($id) {
//        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
//            return $this->redirect(['/selection/preselected']);
//        }
//        $application_model = $this->findModel($id);
//        if (in_array($application_model->status, [SrlmBcApplication::STATUS_RECIEVED, SrlmBcApplication::STATUS_PROVISIONAL]) and $application_model->form_number == 6 and $application_model->gender == 2) {
//            $application_model->status = SrlmBcApplication::STATUS_STAND_BY_1;
//            $application_model->action_type = SrlmBcApplication::ACTION_TYPE_STAND_BY1;
//            $application_model->selection_by = Yii::$app->user->identity->id;
//            $application_model->selection_datetime = new \yii\db\Expression('NOW()');
//            $application_model->updated_at = time();
//            if ($application_model->update()) {
//                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Applicant First standby successfuly'));
//                return $this->redirect('/selection/data/application/view?id=' . $id);
//            }
//        } else {
//            \Yii::$app->getSession()->setFlash('error', \Yii::t('user', 'Invalid action'));
//            return $this->redirect('/selection/data/application/view?id=' . $id);
//        }
//    }

//    public function actionStandby2($id) {
//        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
//            return $this->redirect(['/selection/preselected']);
//        }
//        $application_model = $this->findModel($id);
//        if (in_array($application_model->status, [SrlmBcApplication::STATUS_RECIEVED, SrlmBcApplication::STATUS_PROVISIONAL]) and $application_model->form_number == 6 and $application_model->gender == 2) {
//            $application_model->status = SrlmBcApplication::STATUS_STAND_BY_2;
//            $application_model->action_type = SrlmBcApplication::ACTION_TYPE_STAND_BY2;
//            $application_model->selection_by = Yii::$app->user->identity->id;
//            $application_model->selection_datetime = new \yii\db\Expression('NOW()');
//            $application_model->updated_at = time();
//            if ($application_model->update()) {
//                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Applicant second standby successfuly'));
//                return $this->redirect('/selection/data/application/view?id=' . $id);
//            }
//        } else {
//            \Yii::$app->getSession()->setFlash('error', \Yii::t('user', 'Invalid action'));
//            return $this->redirect('/selection/data/application/view?id=' . $id);
//        }
//    }

    public function actionView($id) {
//        try {  
        $model = $this->findModel($id);
        $bc_application = new BcApplication($model->id);
        $bc_application->calculaterating();
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
        $searchModels = new SrlmBcApplicationSearch();
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

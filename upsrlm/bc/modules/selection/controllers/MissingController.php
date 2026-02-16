<?php

namespace bc\modules\selection\controllers;

use Yii;
use bc\modules\selection\models\BcMissing;
use bc\modules\selection\models\BcMissingSearch;
use bc\modules\selection\models\SrlmBcApplication;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MissingController implements the CRUD actions for BcMissing model.
 */
class MissingController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all BcMissing models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BcMissingSearch();
        $searchModel->bc_missing_listed = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BcMissing model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
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
    }

    public function actionMap($id) {
        $modelbc = $this->findModel($id);
        $model = new \bc\modules\selection\models\form\MissingBCMapForm($modelbc);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $bc = SrlmBcApplication::find()->where(['id' => $model->bc_application_id])->one();
            if ($bc != null) {
                $modelbc->bc_application_id = $bc->id;
                $modelbc->bc_selection_user_id = $bc->srlm_bc_selection_user_id;
                $listed_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $bc->gram_panchayat_code, 'status' => 2])->one();
                if ($listed_bc != null) {
                    $modelbc->listed_bc_training_status = $listed_bc->training_status;
                    $modelbc->listed_bc_application_id = $listed_bc->id;
                    $modelbc->listed_bc_selection_user_id = $listed_bc->srlm_bc_selection_user_id;
                }
                $modelbc->save();
            }
            \Yii::$app->getSession()->setFlash('success', 'Map BC successfully');
            return $this->redirect(['/selection/missing/index?BcMissingSearch[bc_application_id]=0']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('map', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('map', [
                        'model' => $model,
            ]);
        }
    }

    public function actionComment($id) {
        $modelbc = $this->findModel($id);
        $model = new \bc\modules\selection\models\form\MissingCommentForm($modelbc);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->save()) {

            \Yii::$app->getSession()->setFlash('success', 'Comment on BC successfully');
            return $this->redirect(['/selection/missing']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('comment', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('comment', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDownload() {
        $searchModel = new BcMissingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false, false);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        $count = $dataProvider->query->count();

        $models = $dataProvider->getModels();
        $temp_data = "#,"
                . "Rseti BC Name,"
                . "Rseti BC Mobile Number,"
                . "Rseti BC OTP Verified mobile no,"
                . "Rseti BC District Name,"
                . "Rseti BC Block Name,"
                . "Rseti BC Gram Panchayat Name,"
                . "Rseti Certified,"
                . "Rseti BC Age,"
                . "Rseti BC Education,"
                . "Rseti Bc Shg Member,"
                . "Rseti Bc Application Status,"
                . "Rseti Over all rating,"
                . "Listed BC Name,"
                . "Listed BC Mobile Number,"
                . "Listed BC OTP Verified mobile no,"
                . "Listed BC District Name,"
                . "Listed BC Block Name,"
                . "Listed BC Gram Panchayat Name,"
                . "Listed BC Training Status,"
                . "Listed BC Age,"
                . "Listed BC Education,"
                . "Listed Bc Shg Member,"
                . "Listed Bc Over all rating,"
                . "Listed Bc onnboard,"
                . "Listed Bc Funds Transfer,"
                . "Rseti Listed Bc Same,"
                . "Comment\n";
        $file_name = "missing_bc_" . date("Y_m_d_H-m-s");
        $filePath = Yii::$app->params['tmp'] . $file_name . ".csv";
        $fp = fopen($filePath, 'a+');
        $sr_no = 1;
        foreach ($models as $model) {
            $rbc_name = $model->bc_name;
            $rbc_mobile_no = $model->mobile_number;
            $rbc_otp_mobile_no = isset($model->bc->mobile_no) ? $model->bc->mobile_no : '';
            $rbc_district = $model->district_name;
            $rbc_block = $model->block_name;
            $rbc_gp = $model->gram_panchayat_name;
            $rbc_certified = $model->certified;
            $rbc_age = isset($model->bc) ? $model->bc->age : '';
            $rbc_education = isset($model->bc->readingskills) ? $model->bc->readingskills->name_eng : '';
            $rbc_shg_member = '';
            if ($model->bc_application_id != 0) {
                if ($model->rseti_bc_shg_member == 1) {
                    $rbc_shg_member = 'Yes';
                } else {
                    $rbc_shg_member = 'No';
                }
            }
            $rseti_bc_application_status = '';
            if ($model->bc_application_id != 0) {
                if ($model->rseti_bc_application_status == 1) {
                    $rseti_bc_application_status = 'Complete';
                } else {
                    $rseti_bc_application_status = 'Not Complete';
                }
            }
            $rbc_over_all_rating = isset($model->bc->over_all) ? $model->bc->over_all . '/' . SrlmBcApplication::MAX_NO_TOTAL . '  (' . \common\helpers\Utility::percentageOf($model->bc->over_all, SrlmBcApplication::MAX_NO_TOTAL) . ')' : '';
            $lbc_name = isset($model->listedbc->name) ? $model->listedbc->name : '';
            $lbc_mobile_no = isset($model->listedbc->mobile_number) ? $model->listedbc->mobile_number : '';
            $lbc_otp_mobile_no = isset($model->listedbc->mobile_no) ? $model->listedbc->mobile_no : '';
            $lbc_district = isset($model->listedbc->district_name) ? $model->listedbc->district_name : '';
            $lbc_block = isset($model->listedbc->block_name) ? $model->listedbc->block_name : '';
            $lbc_gp = isset($model->listedbc->gram_panchayat_name) ? $model->listedbc->gram_panchayat_name : '';
            $array = [null => '', 0 => 'Default', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', 7 => 'Onboarding', '4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent'];
            $lbc_certified = isset($model->listedbc) ? $array[$model->listedbc->training_status] : '';
            $lbc_age = isset($model->listedbc) ? $model->listedbc->age : '';
            $lbc_education = isset($model->listedbc->readingskills) ? $model->listedbc->readingskills->name_eng : '';
            $lbc_shg_member = '';
            if ($model->bc_application_id != 0) {
                if ($model->listed_bc_shg_member == 1) {
                    $lbc_shg_member = 'Yes';
                } else {
                    $lbc_shg_member = 'No';
                }
            }
            $listed_bc_onboard = '';
            if ($model->bc_application_id != 0) {
                if ($model->listed_bc_onboard == 1) {
                    $listed_bc_onboard = 'Yes';
                } else {
                    $listed_bc_onboard = 'No';
                }
            }
            $listed_bc_funds_transfer = '';
            if ($model->bc_application_id != 0) {
                if ($model->listed_bc_funds_transfer == 1) {
                    $listed_bc_funds_transfer = 'Yes';
                } else {
                    $listed_bc_funds_transfer = 'No';
                }
            }
            $bc_same = '';
            if ($model->bc_application_id != 0) {
                if ($model->bc_same == 1) {
                    $bc_same = 'Yes';
                } else {
                    $bc_same = 'No';
                }
            }
            $lbc_over_all_rating = isset($model->listedbc->over_all) ? $model->listedbc->over_all . '/' . SrlmBcApplication::MAX_NO_TOTAL . '   (' . \common\helpers\Utility::percentageOf($model->listedbc->over_all, SrlmBcApplication::MAX_NO_TOTAL) . ')' : '';

            $comment = isset($model->comment) ? '"' . $model->comment . '"' : '';
            $temp_data .= "$sr_no,"
                    . "$rbc_name,"
                    . "$rbc_mobile_no,"
                    . "$rbc_otp_mobile_no,"
                    . "$rbc_district,"
                    . "$rbc_block,"
                    . "$rbc_gp,"
                    . "$rbc_certified,"
                    . "$rbc_age,"
                    . "$rbc_education,"
                    . "$rbc_shg_member,"
                    . "$rseti_bc_application_status,"
                    . "$rbc_over_all_rating,"
                    . "$lbc_name,"
                    . "$lbc_mobile_no,"
                    . "$lbc_otp_mobile_no,"
                    . "$lbc_district,"
                    . "$lbc_block,"
                    . "$lbc_gp,"
                    . "$lbc_certified,"
                    . "$lbc_age,"
                    . "$lbc_education,"
                    . "$lbc_shg_member,"
                    . "$lbc_over_all_rating,"
                    . "$listed_bc_onboard,"
                    . "$listed_bc_funds_transfer,"
                    . "$bc_same,"
                    . "$comment\n";
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
    }

    /**
     * Finds the BcMissing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BcMissing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BcMissing::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

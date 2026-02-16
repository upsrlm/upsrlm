<?php

namespace app\modules\page\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use bc\models\master\MasterGramPanchayatSearch;
use common\models\base\GenralModel;

/**
 * Default controller for the `page` module
 */
class GpController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function actionOpenbcapplication() {
        $this->layout = '@common/themes/fiori/views/layouts/static_no_menu';
        $searchModel = new MasterGramPanchayatSearch();
        $dataProvider = $searchModel->searchopenapplcation(Yii::$app->request->queryParams, Yii::$app->user->identity, 300);
        $district_option_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['district_code', 'district_name'])->distinct('district_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['and',
                    ['master_gram_panchayat_detail_bc.seventh_vacant' => 1],
                ])->all();

        $searchModel->district_option = \yii\helpers\ArrayHelper::map($district_option_model, 'district_code', 'district_name');
        $block_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['block_code', 'block_name'])->distinct('block_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['and',
            ['master_gram_panchayat_detail_bc.seventh_vacant' => 1],
        ]);
        if ($searchModel->district_code) {
            $block_model->andWhere(['district_code' => $searchModel->district_code]);
        }
        $block_option_model = $block_model->all();
        $searchModel->block_option = \yii\helpers\ArrayHelper::map($block_option_model, 'block_code', 'block_name');

        return $this->render('/default/gp', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}

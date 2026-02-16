<?php

namespace hr\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\master\MasterRole;
use common\models\UserSearch;
use common\models\User;
use common\models\form\AddUserForm;
use common\models\base\GenralModel;
use common\models\form\UserProfileForm;
use common\models\form\ResetPasswordForm;
use backend\models\form\BDOForm;

class BmmuController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /** @inheritdoc */
    public function actionIndex() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_BMMU;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $dataProvider->query->andWhere(['user.dummy_column' => 0]);
        $searchModel->block_option = $searchModel->district_code == '' || $searchModel->district_code == null ? [] : GenralModel::blockopption($searchModel); //GenralModel::blockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->verification_status) and $searchModel->verification_status != '') {
            $dataProvider->query->joinWith(['profile']);
            $dataProvider->query->andWhere(['user_profile.verification_status' => $searchModel->verification_status]);
        }
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['blockdis']);
            $dataProvider->query->andWhere(['master_block.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('master_block.district_code');
        }
        if (isset($searchModel->block_code) and $searchModel->block_code != '') {
            $dataProvider->query->joinWith(['blocks']);
            $dataProvider->query->andWhere(['relation_user_bdo_block.block_code' => $searchModel->block_code]);
            $dataProvider->query->distinct('relation_user_bdo_block.block_code');
        }
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    protected function findModel($id) {
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }

}

<?php

namespace bc\modules\partneragencies\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\master\MasterRole;
use common\models\UserSearch;
use common\models\User;
use common\models\form\AddUserForm;
use common\models\base\GenralModel;
use common\models\form\UserProfileForm;
use common\models\form\ResetPasswordForm;
use backend\models\form\BDOForm;

class UserController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'resetpassword', 'block', 'add', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'resetpassword', 'block', 'add', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'block' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        Url::remember('', 'actions-redirect');

        $user_model = \Yii::$app->user->identity;
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL;
        $searchModel->status = User::STATUS_ACTIVE;
        if (!isset(\Yii::$app->request->queryParams['UserSearch']))
            $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());

        $dataProvider->query->andWhere(['user.role' => [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL]]);
        if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
            
        } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            $dataProvider->query->joinWith(['profile']);
            $dataProvider->query->andWhere(['user_profile.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        } else {
            $dataProvider->query->where('0=1');
        }
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->partner_bank_option = ArrayHelper::map(\bc\models\master\MasterPartnerBank::find()->where(['status' => 1])->all(), 'id', 'bank_name');
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }
        if (isset($searchModel->master_partner_bank_id) and $searchModel->master_partner_bank_id != '') {
            $dataProvider->query->joinWith(['profile']);
            $dataProvider->query->andWhere(['user_profile.master_partner_bank_id' => $searchModel->master_partner_bank_id]);
            $dataProvider->query->distinct('user_profile.master_partner_bank_id');
        }
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

//
    public function actionBankfipcorporatebc() {
        Url::remember('', 'actions-redirect');

        $user_model = \Yii::$app->user->identity;
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_CORPORATE_BCS;
        $searchModel->status = User::STATUS_ACTIVE;
        if (!isset(\Yii::$app->request->queryParams['UserSearch']))
            $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());

        $dataProvider->query->andWhere(['user.role' => [MasterRole::ROLE_CORPORATE_BCS]]);
        if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
            
        } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            $dataProvider->query->joinWith(['profile']);
            $dataProvider->query->andWhere(['user_profile.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        } else {
            $dataProvider->query->where('0=1');
        }
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->partner_bank_option = ArrayHelper::map(\bc\models\master\MasterPartnerBank::find()->where(['status' => 1])->all(), 'id', 'bank_name');
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }
        if (isset($searchModel->master_partner_bank_id) and $searchModel->master_partner_bank_id != '') {
            $dataProvider->query->joinWith(['profile']);
            $dataProvider->query->andWhere(['user_profile.master_partner_bank_id' => $searchModel->master_partner_bank_id]);
            $dataProvider->query->distinct('user_profile.master_partner_bank_id');
        }
        return $this->render('bankfipcorporatebc', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionView($userid) {
        $model = $this->findModel($userid);
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

    public function actionBlock($userid) {
        if ($userid == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', 'You can not block your own account');
        } else {
            $user = $this->findModel($userid);
            if (!in_array($user->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                return $this->redirect(['/partneragencies/user']);
            }
            if ($user->status == User::STATUS_INACTIVE) {
                $user->status = User::STATUS_ACTIVE;
                $user->update();
                \Yii::$app->getSession()->setFlash('success', 'User has been unblocked');
            } else {
                $user->status = User::STATUS_INACTIVE;
                $user->update();
                \Yii::$app->getSession()->setFlash('success', 'User has been blocked');
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionResetpassword($userid) {
        $model = $this->findModel($userid);
        /** @var User $user */
        if (!in_array($model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
            return $this->redirect(['/partneragencies/user']);
        }
        $user = new ResetPasswordForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Reset Password Of " . $user->user->name . " successfully");
            if (in_array($model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                return $this->redirect(['/partneragencies/user']);
            }
            return $this->redirect(['/partneragencies/user']);
        }

        return $this->render('resetpassword', [
                    'user' => $user
        ]);
    }

    public function actionAdd() {
        $model = null;
        /** @var User $user */
        $user = new \common\models\form\PartnerDistrictNodalForm($model);
        $user->status = User::STATUS_ACTIVE;
        $user->role = MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL;
        $user_model = Yii::$app->user->identity;
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_ADMIN])) {
            
        } else {
            if (!$user_model->master_partner_bank_id) {
                \Yii::$app->getSession()->setFlash('error', "you are not authorized to perform this operation ");
                return $this->redirect('');
                exit;
            } else {
                $user->master_partner_bank_id = $user_model->master_partner_bank_id;
            }
        }
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Add user  successfully");

            return $this->redirect(['/partneragencies/user/bankfipcorporatebc']);
        }

        return $this->render('adduser', [
                    'user' => $user
        ]);
    }

    public function actionAddcorporatebcs() {
        $model = null;
        /** @var User $user */
        $user = new \common\models\form\PartnerDistrictNodalForm($model);
        $user->status = User::STATUS_ACTIVE;
        $user->role = MasterRole::ROLE_CORPORATE_BCS;
        $user_model = Yii::$app->user->identity;
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_ADMIN])) {
            
        } else {
            if (!$user_model->master_partner_bank_id) {
                \Yii::$app->getSession()->setFlash('error', "you are not authorized to perform this operation ");
                return $this->redirect('');
                exit;
            } else {
                $user->master_partner_bank_id = $user_model->master_partner_bank_id;
            }
        }
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Add user  successfully");

            return $this->redirect(['/partneragencies/user/bankfipcorporatebc']);
        }

        return $this->render('addcorporatebcs', [
                    'user' => $user
        ]);
    }

    public function actionUpdate($userid) {
        $model = $this->findModel($userid);
        /** @var User $user */
        if (!in_array($model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
            return $this->redirect(['/partneragencies/user']);
        }
        $user = new \common\models\form\PartnerDistrictNodalForm($model);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "update user  successfully");

            return $this->redirect(['/partneragencies/user']);
        }

        return $this->render('update', [
                    'model' => $user
        ]);
    }

    public function actionUpdatebankfipcorpratebc($userid) {
        $model = $this->findModel($userid);
        /** @var User $user */
        if (!in_array($model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
            return $this->redirect(['/partneragencies/user/bankfipcorporatebc']);
        }
        $user = new \common\models\form\PartnerDistrictNodalForm($model);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "update user  successfully");

            return $this->redirect(['/partneragencies/user/bankfipcorporatebc']);
        }

        return $this->render('updatebankfipcorpratebc', [
                    'model' => $user
        ]);
    }

    public function actionSwitch($id) {

        if (!Yii::$app->user->identity->isAdmin) {
            throw new ForbiddenHttpException();
        }

        $user = $this->findModel($id);

        Yii::$app->user->switchIdentity($user, 3600);

        return $this->goHome();
    }

    protected function findModel($id) {
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }
}

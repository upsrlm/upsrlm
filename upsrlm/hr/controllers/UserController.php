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

class UserController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors() {
        return [
//            'access' => [
//                'class' => \yii\filters\AccessControl::className(),
//                'only' => ['bmmu', 'resetpassword', 'block'],
//                'rules' => [
//                    [
//                        'actions' => ['bmmu'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            return (!Yii::$app->user->isGuest and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_HR_ADMIN]));
//                        }
//                    ],
//                    [
//                        'actions' => ['resetpassword'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            return (!Yii::$app->user->isGuest and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_HR_ADMIN]));
//                        }
//                    ],
//                    [
//                        'actions' => ['block'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            return (!Yii::$app->user->isGuest and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_HR_ADMIN]));
//                        }
//                    ],
//                ],
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'introemail' => ['post', 'get'],
                    'forgotpassword' => ['post'],
                    'block' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        if (!isset(\Yii::$app->request->queryParams['UserSearch']))
            $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $dataProvider->query->andWhere(['user.role' => [MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE]]);
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionBmmu() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_BMMU;
        //if (!isset(\Yii::$app->request->queryParams['UserSearch']))
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->block_option = $searchModel->district_code == '' || $searchModel->district_code == null ? [] : GenralModel::blockopption($searchModel); //GenralModel::blockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
//        if (isset($searchModel->profile_status) and $searchModel->profile_status != '') {
//            $dataProvider->query->joinWith(['profile']);
//            if ($searchModel->profile_status == 1) {
//                $dataProvider->query->andWhere(['user_profile.id' => null]);
//            }
//            if ($searchModel->profile_status == 2) {
//                $dataProvider->query->andWhere(['user_profile.is_profile_complete' => 0]);
//            }
//            if ($searchModel->profile_status == 3) {
//                $dataProvider->query->andWhere(['user_profile.is_profile_complete' => 1]);
//            }
//        }
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
            $dataProvider->query->distinct('$searchModel.block_code');
        }
        return $this->render('bmmu', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDmmu() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_DMMU;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }
        if (isset($searchModel->profile_status) and $searchModel->profile_status != '') {
            $dataProvider->query->andWhere(['user.profile_status' => $searchModel->profile_status]);
        }
        if (isset($searchModel->verification_status) and $searchModel->verification_status != '') {
            $dataProvider->query->joinWith(['profile']);
            $dataProvider->query->andWhere(['user_profile.verification_status' => $searchModel->verification_status]);
        }
        return $this->render('dmmu', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionSmmu() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_SMMU;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }
        if (isset($searchModel->profile_status) and $searchModel->profile_status != '') {
            $dataProvider->query->andWhere(['user.profile_status' => $searchModel->profile_status]);
        }
        if (isset($searchModel->verification_status) and $searchModel->verification_status != '') {
            $dataProvider->query->joinWith(['profile']);
            $dataProvider->query->andWhere(['user_profile.verification_status' => $searchModel->verification_status]);
        }
        return $this->render('smmu', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionViewbmmuprofile($userid) {
        $model = new UserProfileForm($userid);

        return $this->render('viewbmmuprofile', [
                    'model' => $model,
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

    public function actionVerifyvalidate($userid) {
        $user_model = $this->findModel($userid);
        $model = new \common\models\form\ProfileVerifictionForm($userid);
        $this->performAjaxValidation($model);
    }

    public function actionVerify($userid) {
        $user_model = $this->findModel($userid);
        $model = new \common\models\form\ProfileVerifictionForm($userid);
        if ($model->load(Yii::$app->request->post())) {
            $model->profle_model->verification_status1 = $model->verification_status1;
            $model->profle_model->verification_status2 = $model->verification_status2;
            $model->profle_model->verification_status3 = $model->verification_status3;
            $model->profle_model->verification_status4 = $model->verification_status4;
            $model->profle_model->verification_status5 = $model->verification_status5;
            if ($model->verification_status1 and $model->verification_status2 and $model->verification_status3 and $model->verification_status4 and $model->verification_status5) {
                $model->profle_model->verification_status = 1;
            } else {
                $model->profle_model->verification_status = 2;
            }
            $model->profle_model->comment = $model->comment;
            $model->profle_model->verification_by = \Yii::$app->user->identity->id;
            $model->profle_model->verification_datetime = new \yii\db\Expression('NOW()');
            if ($model->validate() and $model->profle_model->update()) {
//                \Yii::$app->getSession()->setFlash('success', 'successfully');
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => true];
                if ($user_model->role == MasterRole::ROLE_SMMU) {
//                    return $this->redirect(['/user/smmu']);
                }
                if ($user_model->role == MasterRole::ROLE_BMMU) {
//                    return $this->redirect(['/user/bmmu']);
                }
                if ($user_model->role == MasterRole::ROLE_DMMU) {
//                    return $this->redirect(['/user/dmmu']);
                }
            } else {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return \yii\widgets\ActiveForm::validate($model);
                }
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_verifyform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_verifyform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionBlock($userid) {
        if ($userid == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', 'You can not block your own account');
        } else {
            $user = $this->findModel($userid);
            if ($user->status == User::STATUS_INACTIVE) {
                $user->status = User::STATUS_ACTIVE;
                $user->action_type = 2;
                $user->update();
                \Yii::$app->getSession()->setFlash('success', 'User has been unblocked');
            } else {
                $user->status = User::STATUS_INACTIVE;
                $user->action_type = 2;
                $user->update();
                \Yii::$app->getSession()->setFlash('success', 'User has been blocked');
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionResetpassword($userid) {
        $model = $this->findModel($userid);
        /** @var User $user */
        $user = new ResetPasswordForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Reset Password Of " . $user->user->name . " successfully");
            return $this->redirect(['/user']);
        }

        return $this->render('resetpassword', [
                    'user' => $user
        ]);
    }

    public function actionChangerole($userid) {
        $model = $this->findModel($userid);
        /** @var User $user */
        $user = new \common\models\form\ChangeRoleForm($model);
        $user->role_option = [
            MasterRole::ROLE_BMMU => 'BMMU',
            MasterRole::ROLE_DMMU => 'DMMU',
            MasterRole::ROLE_SMMU => 'SMMU',
            MasterRole::ROLE_SPM_FI_MF => 'SPM FI & MF',
            MasterRole::ROLE_SPM_FINANCE => 'SPM Finance',
        ];
        unset($user->role_option[$model->role]);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "change user role successfully");

            if ($model->role == MasterRole::ROLE_BMMU) {
                return $this->redirect(['/user/updatebmmu?userid=' . $user->user->id]);
            }

            if ($user->role == MasterRole::ROLE_DMMU) {
                return $this->redirect(['/user/updatedmmu?userid=' . $user->user->id]);
            }
            if ($user->role == MasterRole::ROLE_SMMU) {
                return $this->redirect(['/user/smmu']);
            }
            return $this->redirect(['/user/']);
        }

        return $this->render('_change_role_form', [
                    'model' => $user
        ]);
    }

    public function actionUpdatebmmu($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_BMMU) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new BDOForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            if ($model->role == MasterRole::ROLE_BMMU) {
                return $this->redirect(['/user']);
            }

            return $this->redirect(['/user']);
        }

        return $this->render('updatebmmu', [
                    'user' => $user
        ]);
    }

    public function actionUpdatedmmu($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_DMMU) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $user->role = MasterRole::ROLE_DMMU;
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user']);
        }

        return $this->render('updatedmmu', [
                    'model' => $user
        ]);
    }

    public function actionAdd() {
        $model = null;
        /** @var User $user */
        $user = new AddUserForm($model);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Add user  successfully");

            if ($user->role == MasterRole::ROLE_BMMU) {
                return $this->redirect(['/user/updatebmmu?userid=' . $user->user_model->id]);
            }

            if ($user->role == MasterRole::ROLE_DMMU) {
                return $this->redirect(['/user/updatedmmu?userid=' . $user->user_model->id]);
            }

            return $this->redirect(['/user']);
        }

        return $this->render('adduser', [
                    'user' => $user
        ]);
    }

    public function actionUpdate($userid) {
        $model = $this->findModel($userid);
        /** @var User $user */
        $user = new AddUserForm($model);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "update user  successfully");
            if ($model->role == MasterRole::ROLE_BDO) {
                return $this->redirect(['/user/bdo']);
            }
            if ($model->role == MasterRole::ROLE_BMMU) {
                return $this->redirect(['/user/bmmu']);
            }
            if ($model->role == MasterRole::ROLE_DM) {
                return $this->redirect(['/user/dm']);
            }
            if ($model->role == MasterRole::ROLE_DIVISIONAL_COMMISSIONER) {
                return $this->redirect(['/user/dc']);
            }
            if ($model->role == MasterRole::ROLE_RSETIS_DISTRICT_UNIT) {
                return $this->redirect(['/user/rsethis']);
            }
            if ($model->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
                return $this->redirect(['/user/bankdu']);
            }
            if ($model->role == MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL) {
                return $this->redirect(['/user/bankfipdnodal']);
            }
            if ($model->role == MasterRole::ROLE_CORPORATE_BCS) {
                return $this->redirect(['/user/bankfipcorporate']);
            }
            if ($user->role == MasterRole::ROLE_DC_NRLM) {
                return $this->redirect(['/user/dcnrlm']);
            }
            if ($user->role == MasterRole::ROLE_DMMU) {
                return $this->redirect(['/user/dmmu']);
            }
            if ($user->role == MasterRole::ROLE_SMMU) {
                return $this->redirect(['/user/smmu']);
            }
            return $this->redirect(['/user/']);
        }

        return $this->render('update', [
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

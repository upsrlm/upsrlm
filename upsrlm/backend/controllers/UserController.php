<?php

namespace backend\controllers;

use Yii;
use yii\base\ExitException;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use common\models\RelationUserDivisionSearch;
use common\models\RelationUserUlbSearch;
use common\models\RelationUserGramPanchayat;
use common\models\RelationUserBdoBlockSearch;
use common\models\RelationUserDistrictSearch;
use common\models\User;
use common\models\UserSearch;
use common\models\master\MasterRole;
use common\models\form\AddUserForm;
use common\models\form\ResetPasswordForm;
use backend\models\form\BDOForm;
use common\models\base\GenralModel;

class UserController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'mopup', 'deleted', 'bc', 'bmmu', 'dmmu', 'smmu', 'dm', 'supportunit', 'cbo', 'rsethis', 'nodalbank', 'dcnrlm', 'bankdu', 'bankfipdnodal', 'dc', 'yp', 'bdo', 'update', 'add', 'switch', 'rsethibacthcreator', 'updatersethibacthcreator', 'cdo', 'updatecdo', 'resetmenu', 'ado', 'dpro', 'dpm', 'districtconsultants', 'divisionalconsultants', 'bdosupporter'],
                'rules' => [
                    [
                        'actions' => ['index', 'mopup', 'deleted', 'bc', 'bmmu', 'dmmu', 'smmu', 'dm', 'supportunit', 'cbo', 'rsethis', 'nodalbank', 'dcnrlm', 'bankdu', 'bankfipdnodal', 'dc', 'yp', 'bdo', 'rsethibacthcreator', 'updatersethibacthcreator', 'cdo', 'updatecdo', 'resetmenu', 'ado', 'dpro', 'dpm', 'districtconsultants', 'divisionalconsultants', 'bdosupporter'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN]));
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN]));
                        }
                    ],
                    [
                        'actions' => ['add'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN]));
                        }
                    ],
                    [
                        'actions' => ['switch'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN]));
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'introemail' => ['post', 'get'],
                    'forgotpassword' => ['post'],
                    'block' => ['post'],
                    'switch' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        if (!isset(\Yii::$app->request->queryParams['UserSearch']))
            $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionMopup() {
        Url::remember('', 'actions-redirect');
        $null = new \yii\db\Expression('NULL');
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new UserSearch();
        if (!isset(\Yii::$app->request->queryParams['UserSearch']))
            $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($params, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['user.mopup' => 1]);
        $dataProvider->query->joinWith(['grampanchayat']);
        $dataProvider->query->andWhere(['not', ['relation_user_gram_panchayat.id' => null]]);

        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->andWhere(['relation_user_gram_panchayat.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_gram_panchayat.district_code');
        }
        if (isset($searchModel->block_code) and $searchModel->block_code != '') {
            $dataProvider->query->andWhere(['relation_user_gram_panchayat.block_code' => $searchModel->block_code]);
            $dataProvider->query->distinct('relation_user_gram_panchayat.block_code');
        }
        if (isset($searchModel->gram_panchayat_code) and $searchModel->gram_panchayat_code != '') {
            $dataProvider->query->andWhere(['relation_user_gram_panchayat.gram_panchayat_code' => $searchModel->gram_panchayat_code]);
            $dataProvider->query->distinct('relation_user_gram_panchayat.gram_panchayat_code');
        }
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->block_option = $searchModel->district_code == '' || $searchModel->district_code == null ? [] : GenralModel::blockopption($searchModel);
        if ($searchModel->block_code)
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);

        return $this->render('mopup', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDeleted() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();

        $dataProvider = $searchModel->deleted(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());

        return $this->render('deleted', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionBmmu() {
        //echo Yii::$app->request->referrer;exit;
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
        return $this->render('bmmu', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDm() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_DM;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, 100, GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('dm', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDpm() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_DPM;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, 100, GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('dpm', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionSupportunit() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_SUPPORT_UNIT;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('supportunit', [
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

        return $this->render('dmmu', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDpro() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_DPRO;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('dpro', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDivisionalconsultants() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_DIVISIONAL_CONSULTANTS;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('divisionalconsultants', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDistrictconsultants() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_DISTRICT_CONSULTANTS;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('districtconsultants', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionFrontiermarket() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = [MasterRole::ROLE_FRONTIER_MARKET_ADMIN, MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN];
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, 100);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('frontiermarket', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionSmmu() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_SMMU;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, 100);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('smmu', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionBc() {
        try {


            Url::remember('', 'actions-redirect');
            $searchModel = new UserSearch();
            $searchModel->role = MasterRole::ROLE_CBO_USER;
            $searchModel->status = User::STATUS_ACTIVE;
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());

            $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
            $searchModel->block_option = $searchModel->district_code == '' || $searchModel->district_code == null ? [] : GenralModel::blockopption($searchModel); //GenralModel::blockopption($searchModel);
            $dataProvider->query->joinWith(['cboprofile']);

            $dataProvider->query->andWhere(['cbo_member_profile.bc' => 1]);
            if ($searchModel->block_code)
                $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
            if ($searchModel->district_code or $searchModel->block_code or $searchModel->gram_panchayat_code) {
                $dataProvider->query->joinWith(['cboprofile']);
            }
            if (isset($searchModel->district_code) and $searchModel->district_code != '') {
                $dataProvider->query->andWhere(['cbo_member_profile.district_code' => $searchModel->district_code]);
                $dataProvider->query->distinct('cbo_member_profile.district_code');
            }
            if (isset($searchModel->block_code) and $searchModel->block_code != '') {
                $dataProvider->query->andWhere(['cbo_member_profile.block_code' => $searchModel->block_code]);
                $dataProvider->query->distinct('cbo_member_profile.block_code');
            }
            if (isset($searchModel->gram_panchayat_code) and $searchModel->gram_panchayat_code != '') {
                $dataProvider->query->andWhere(['cbo_member_profile.gram_panchayat_code' => $searchModel->gram_panchayat_code]);
                $dataProvider->query->distinct('cbo_member_profile.gram_panchayat_code');
            }

            return $this->render('bc', [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
            ]);
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            print_r($ex->getTrace());
        }
    }

    public function actionCbo() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_CBO_USER;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->member_option = [5 => 'Samuh Sakhi', 4 => 'BC', 3 => 'CLF', 2 => 'VO', 1 => 'SHG'];
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        $searchModel->block_option = $searchModel->district_code == '' || $searchModel->district_code == null ? [] : GenralModel::blockopption($searchModel); //GenralModel::blockopption($searchModel);
        $dataProvider->query->joinWith(['cboprofile']);
        if ($searchModel->block_code)
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        if ($searchModel->district_code or $searchModel->block_code or $searchModel->gram_panchayat_code) {
            $dataProvider->query->joinWith(['cboprofile']);
        }
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->andWhere(['cbo_member_profile.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('cbo_member_profile.district_code');
        }
        if (isset($searchModel->block_code) and $searchModel->block_code != '') {
            $dataProvider->query->andWhere(['cbo_member_profile.block_code' => $searchModel->block_code]);
            $dataProvider->query->distinct('cbo_member_profile.block_code');
        }
        if (isset($searchModel->gram_panchayat_code) and $searchModel->gram_panchayat_code != '') {
            $dataProvider->query->andWhere(['cbo_member_profile.gram_panchayat_code' => $searchModel->gram_panchayat_code]);
            $dataProvider->query->distinct('cbo_member_profile.gram_panchayat_code');
        }
        if (isset($searchModel->member) and is_array($searchModel->member)) {
            if (in_array(5, $searchModel->member)) {
                $dataProvider->query->andWhere(['cbo_member_profile.samuh_sakhi' => 1]);
            }
            if (in_array(4, $searchModel->member)) {
                $dataProvider->query->andWhere(['cbo_member_profile.bc' => 1]);
            }
            if (in_array(3, $searchModel->member)) {
                $dataProvider->query->andWhere(['cbo_member_profile.clf' => 1]);
            }
            if (in_array(2, $searchModel->member)) {
                $dataProvider->query->andWhere(['cbo_member_profile.vo' => 1]);
            }
            if (in_array(1, $searchModel->member)) {
                $dataProvider->query->andWhere(['cbo_member_profile.shg' => 1]);
            }
        }
        return $this->render('cbo', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionRsethis() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT];
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('rsethis', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionNodalbank() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_RSETIS_NODAL_BANK;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }
        return $this->render('nodalbank', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDcnrlm() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_DC_NRLM;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('dcnrlm', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionCdo() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_CDO;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('cdo', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionBankdu() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_BANK_DISTRICT_UNIT;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('bankdu', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionBankfipdnodal() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
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
        return $this->render('bankfipdnodal', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionBankfipcorporate() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_CORPORATE_BCS;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
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
        return $this->render('bankfipcorporate', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionDc() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_DIVISIONAL_COMMISSIONER;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->division_option = GenralModel::nfsaoptiondivision($searchModel);

        if (isset($searchModel->division_code) and $searchModel->division_code != '') {
            $dataProvider->query->joinWith(['division']);
            $dataProvider->query->andWhere(['relation_user_division.division_code' => $searchModel->division_code]);
            $dataProvider->query->distinct('relation_user_division.division_code');
        }

        return $this->render('dc', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionYp() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_YOUNG_PROFESSIONAL;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->division_option = GenralModel::nfsaoptiondivision($searchModel);

        if (isset($searchModel->division_code) and $searchModel->division_code != '') {
            $dataProvider->query->joinWith(['division']);
            $dataProvider->query->andWhere(['relation_user_division.division_code' => $searchModel->division_code]);
            $dataProvider->query->distinct('relation_user_division.division_code');
        }

        return $this->render('yp', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
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

    public function actionBdo() {
        Url::remember('', 'actions-redirect');
        $user_model = Yii::$app->user->identity;
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_BDO;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->block_option = $searchModel->district_code == '' || $searchModel->district_code == null ? [] : GenralModel::blockopption($searchModel); //GenralModel::blockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

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

        return $this->render('bdo', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionBdosupporter() {
        Url::remember('', 'actions-redirect');
        $user_model = Yii::$app->user->identity;
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_BDO_SUPPORTER;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($params, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->block_option = $searchModel->district_code == '' || $searchModel->district_code == null ? [] : GenralModel::blockopption($searchModel); //GenralModel::blockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

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

        return $this->render('bdosupporter', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionAdo() {
        Url::remember('', 'actions-redirect');
        $user_model = Yii::$app->user->identity;
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_ADO;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->block_option = $searchModel->district_code == '' || $searchModel->district_code == null ? [] : GenralModel::blockopption($searchModel); //GenralModel::blockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

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

        return $this->render('ado', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionRsethibacthcreator() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_RSETIS_BATCH_CREATOR;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('rsethibacthcreator', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionAdd() {
        $model = null;
        /** @var User $user */
        $user = new AddUserForm($model);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Add user  successfully");
            if ($user->role == MasterRole::ROLE_BDO) {
                return $this->redirect(['/user/updatebdo?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_BDO_SUPPORTER) {
                return $this->redirect(['/user/updatebdo?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_ADO) {
                return $this->redirect(['/user/updatebdo?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_BMMU) {
                return $this->redirect(['/user/updatebdo?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_DM) {
                return $this->redirect(['/user/updatedm?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_DPRO) {
                return $this->redirect(['/user/updatedm?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_DIVISIONAL_CONSULTANTS) {
                return $this->redirect(['/user/updatedm?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_DISTRICT_CONSULTANTS) {
                return $this->redirect(['/user/updatedm?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_DPM) {
                return $this->redirect(['/user/updatedm?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_DIVISIONAL_COMMISSIONER) {
                return $this->redirect(['/user/updatedc?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_RSETIS_DISTRICT_UNIT) {
                return $this->redirect(['/user/updatersethisdu?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_RSETIS_BATCH_CREATOR) {
                return $this->redirect(['/user/updatersethibacthcreator?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_RSETIS_NODAL_BANK) {
                return $this->redirect(['/user/updatenodalbank?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
                return $this->redirect(['/user/updatebankdu?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL) {
                return $this->redirect(['/user/updatebankfipdnodal?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_DC_NRLM) {
                return $this->redirect(['/user/updatedcnrlm?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_CDO) {
                return $this->redirect(['/user/updatecdo?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_DMMU) {
                return $this->redirect(['/user/updatedmmu?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_SUPPORT_UNIT) {
                return $this->redirect(['/user/updatesupportunit?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_SMMU) {
                return $this->redirect(['/user/smmu']);
            }
            if ($user->role == MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN) {
                return $this->redirect(['/user/updatefmda?userid=' . $user->user_model->id]);
            }
            if ($user->role == MasterRole::ROLE_FRONTIER_MARKET_ADMIN) {
                return $this->redirect(['/user/frontiermarket']);
            }
            return $this->redirect(['/user']);
        }

        return $this->render('adduser', [
                    'user' => $user
        ]);
    }

    public function actionUpdate($userid) {
        $model = $this->findModel($userid);
        if (in_array($model->role, [41, 42, 43, 44, 45, 46, 47, 100, 120])) {
            return $this->redirect(['/user']);
        }
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
            if ($user->role == MasterRole::ROLE_DC_NRLM) {
                return $this->redirect(['/user/dcnrlm']);
            }
            if ($user->role == MasterRole::ROLE_DMMU) {
                return $this->redirect(['/user/dmmu']);
            }
            if ($user->role == MasterRole::ROLE_SMMU) {
                return $this->redirect(['/user/smmu']);
            }
            if ($user->role == MasterRole::ROLE_BDO_SUPPORTER) {
                return $this->redirect(['/user/bdosupporter']);
            }
            return $this->redirect(['/user/']);
        }

        return $this->render('update', [
                    'model' => $user
        ]);
    }

    public function actionChangeloginmethod($userid) {
        $model = $this->findModel($userid);
        /** @var User $user */
        $user = new \common\models\form\ChangeLoginTypeForm($model);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "change login method successfully");
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
            if ($model->role == MasterRole::ROLE_DC_NRLM) {
                return $this->redirect(['/user/dcnrlm']);
            }
            if ($model->role == MasterRole::ROLE_DMMU) {
                return $this->redirect(['/user/dmmu']);
            }
            if ($model->role == MasterRole::ROLE_SMMU) {
                return $this->redirect(['/user/smmu']);
            }
            if ($user->role == MasterRole::ROLE_BDO_SUPPORTER) {
                return $this->redirect(['/user/bdosupporter']);
            }
            if ($user->role == MasterRole::ROLE_ADO) {
                return $this->redirect(['/user/ado']);
            }
            if ($user->role == MasterRole::ROLE_DPM) {
                return $this->redirect(['/user/dpm']);
            }
            if ($user->role == MasterRole::ROLE_DPRO) {
                return $this->redirect(['/user/dpro']);
            }
            return $this->redirect(['/user/']);
        }

        return $this->render('_change_login_method_form', [
                    'model' => $user
        ]);
    }

    public function actionChangerole($userid) {
        $model = $this->findModel($userid);
        /** @var User $user */
        $user = new \common\models\form\ChangeRoleForm($model);
        unset($user->role_option[$model->role]);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate() && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "change user role successfully");
            if ($model->role == MasterRole::ROLE_BDO) {
                return $this->redirect(['/user/updatebdo?userid=' . $user->user->id]);
            }
            if ($model->role == MasterRole::ROLE_BMMU) {
                return $this->redirect(['/user/updatebdo?userid=' . $user->user->id]);
            }
            if ($model->role == MasterRole::ROLE_DM) {
                return $this->redirect(['/user/updatedm?userid=' . $user->user->id]);
            }
            if ($model->role == MasterRole::ROLE_DIVISIONAL_COMMISSIONER) {
                return $this->redirect(['/user/updatedc?userid=' . $user->user->id]);
            }
            if ($model->role == MasterRole::ROLE_RSETIS_DISTRICT_UNIT) {
                return $this->redirect(['/user/updatersethisdu?userid=' . $user->user->id]);
            }
            if ($model->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
                return $this->redirect(['/user/updatebankdu?userid=' . $user->user->id]);
            }
            if ($model->role == MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL) {
                return $this->redirect(['/user/updatebankfipdnodal?userid=' . $user->user->id]);
            }
            if ($user->role == MasterRole::ROLE_DC_NRLM) {
                return $this->redirect(['/user/updatedcnrlm?userid=' . $user->user->id]);
            }
            if ($user->role == MasterRole::ROLE_DMMU) {
                return $this->redirect(['/user/updatedmmu?userid=' . $user->user->id]);
            }
            if ($user->role == MasterRole::ROLE_SMMU) {
                return $this->redirect(['/user/smmu']);
            }
            if ($user->role == MasterRole::ROLE_BDO_SUPPORTER) {
                return $this->redirect(['/user/bdosupporter']);
            }
            if ($user->role == MasterRole::ROLE_ADO) {
                return $this->redirect(['/user/ado']);
            }
            if ($user->role == MasterRole::ROLE_DPM) {
                return $this->redirect(['/user/dpm']);
            }
            if ($user->role == MasterRole::ROLE_DPRO) {
                return $this->redirect(['/user/dpro']);
            }
            return $this->redirect(['/user/']);
        }

        return $this->render('_change_role_form', [
                    'model' => $user
        ]);
    }

    public function actionUpdatebdo($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_BDO || $model->role == MasterRole::ROLE_BMMU || $model->role == MasterRole::ROLE_ADO || $model->role == MasterRole::ROLE_BDO_SUPPORTER) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new BDOForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            if ($model->role == MasterRole::ROLE_BMMU) {
                return $this->redirect(['/user/bmmu']);
            }
            if ($model->role == MasterRole::ROLE_BDO) {
                return $this->redirect(['/user/bdo']);
            }
            if ($model->role == MasterRole::ROLE_BDO_SUPPORTER) {
                return $this->redirect(['/user/bdosupporter']);
            }
            if ($model->role == MasterRole::ROLE_ADO) {
                return $this->redirect(['/user/ado']);
            }
            return $this->redirect(['/user']);
        }

        return $this->render('updatebdo', [
                    'user' => $user
        ]);
    }

    public function actionUpdatedc($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_DIVISIONAL_COMMISSIONER) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DivisionCommisnorForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/dc']);
        }

        return $this->render('updatedivcom', [
                    'model' => $user
        ]);
    }

    public function actionUpdatedm($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_DM or $model->role == MasterRole::ROLE_DPRO or $model->role == MasterRole::ROLE_DPM or $model->role == MasterRole::ROLE_DIVISIONAL_CONSULTANTS or $model->role == MasterRole::ROLE_DISTRICT_CONSULTANTS) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            if ($model->role == MasterRole::ROLE_DM) {
                return $this->redirect(['/user/dm']);
            }
            if ($model->role == MasterRole::ROLE_DPRO) {
                return $this->redirect(['/user/dpro']);
            }
            if ($model->role == MasterRole::ROLE_DPM) {
                return $this->redirect(['/user/dpm']);
            }
            if ($model->role == MasterRole::ROLE_DIVISIONAL_CONSULTANTS) {
                return $this->redirect(['/user/divisionalconsultants']);
            }
            if ($model->role == MasterRole::ROLE_DISTRICT_CONSULTANTS) {
                return $this->redirect(['/user/districtconsultants']);
            }
        }

        return $this->render('updatedm', [
                    'model' => $user
        ]);
    }

    public function actionUpdatersethibacthcreator($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_RSETIS_BATCH_CREATOR) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/rsethibacthcreator']);
        }

        return $this->render('updatersethibacthcreator', [
                    'model' => $user
        ]);
    }

    public function actionUpdatefmda($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $user->saheli = 1;
        $user->district_option = GenralModel::nfsaoptiondistrict($user);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/frontiermarket']);
        }

        return $this->render('updatefrontiermarket', [
                    'model' => $user
        ]);
    }

    public function actionUpdatesupportunit($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_SUPPORT_UNIT) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $user->role = MasterRole::ROLE_SUPPORT_UNIT;
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/supportunit']);
        }

        return $this->render('updatesupportunit', [
                    'model' => $user
        ]);
    }

    public function actionUpdatedcnrlm($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_DC_NRLM) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/dcnrlm']);
        }

        return $this->render('updatedcnrlm', [
                    'model' => $user
        ]);
    }

    public function actionUpdatecdo($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_CDO) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/cdo']);
        }

        return $this->render('updatecdo', [
                    'model' => $user
        ]);
    }

    public function actionUpdatebankdu($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/bankdu']);
        }

        return $this->render('updatebankdu', [
                    'model' => $user
        ]);
    }

    public function actionUpdatebankfipdnodal($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/bankfipdnodal']);
        }

        return $this->render('updatebankfipdnodal', [
                    'model' => $user
        ]);
    }

    public function actionUpdatersethisdu($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_RSETIS_DISTRICT_UNIT) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/rsethis']);
        }

        return $this->render('updatersethisdu', [
                    'model' => $user
        ]);
    }

    public function actionUpdatenodalbank($userid) {
        $model = $this->findModel($userid);
        if ($model->role == MasterRole::ROLE_RSETIS_NODAL_BANK) {
            
        } else {
            return $this->redirect(['/user']);
        }
        /** @var User $user */
        $user = new \backend\models\form\DMForm($model);
        $user->role = MasterRole::ROLE_RSETIS_NODAL_BANK;
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Update " . $user->user_model->name . " successfully");
            return $this->redirect(['/user/nodalbank']);
        }

        return $this->render('updatenodalbank', [
                    'model' => $user
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
            return $this->redirect(['/user/dmmu']);
        }

        return $this->render('updatedmmu', [
                    'model' => $user
        ]);
    }

    public function actionResetpassword($userid) {
        $model = $this->findModel($userid);
        /** @var User $user */
        $user = new ResetPasswordForm($model);
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', "Reset Password Of " . $user->user->name . " successfully");
            if ($model->role == MasterRole::ROLE_BDO) {
                return $this->redirect(['/user/bdo']);
            } else if ($model->role == MasterRole::ROLE_BMMU) {
                return $this->redirect(['/user/bmmu']);
            } else if ($model->role == MasterRole::ROLE_DM) {
                return $this->redirect(['/user/dm']);
            } else if ($model->role == MasterRole::ROLE_DIVISIONAL_COMMISSIONER) {
                return $this->redirect(['/user/dc']);
            } else if ($model->role == MasterRole::ROLE_RSETIS_DISTRICT_UNIT) {
                return $this->redirect(['/user/rsethis']);
            } else if ($model->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
                return $this->redirect(['/user/bankdu']);
            } else if ($model->role == MasterRole::ROLE_DC_NRLM) {
                return $this->redirect(['/user/dcnrlm']);
            } else if ($model->role == MasterRole::ROLE_CDO) {
                return $this->redirect(['/user/cdo']);
            } else if ($model->role == MasterRole::ROLE_RSETIS_NODAL_BANK) {
                return $this->redirect(['/user/nodalbank']);
            } else if ($model->role == MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL) {
                return $this->redirect(['/user/bankfipdnodal']);
            } else if ($model->role == MasterRole::ROLE_DMMU) {
                return $this->redirect(['/user/dmmu']);
            } else if ($model->role == MasterRole::ROLE_SMMU) {
                return $this->redirect(['/user/smmu']);
            } else if ($model->role == MasterRole::ROLE_SUPPORT_UNIT) {
                return $this->redirect(['/user/supportunit']);
            } else if ($model->role == MasterRole::ROLE_FRONTIER_MARKET_ADMIN) {
                return $this->redirect(['/user/frontiermarket']);
            } else if ($model->role == MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN) {
                return $this->redirect(['/user/frontiermarket']);
            } else if ($model->role == MasterRole::ROLE_DPRO) {
                return $this->redirect(['/user/dpro']);
            } else if ($model->role == MasterRole::ROLE_DPM) {
                return $this->redirect(['/user/dpm']);
            } else if ($model->role == MasterRole::ROLE_DIVISIONAL_CONSULTANTS) {
                return $this->redirect(['/user/divisionalconsultants']);
            } elseif ($model->role == MasterRole::ROLE_DISTRICT_CONSULTANTS) {
                return $this->redirect(['/user/districtconsultants']);
            }
            return $this->redirect(['/user']);
        }

        return $this->render('resetpassword', [
                    'user' => $user
        ]);
    }

    public function actionView($userid) {
        $model = $this->findModel($userid);

        return $this->render('view', [
                    'model' => $model
        ]);
    }

    public function actionChangepassword() {
        /** @var User $user */
        $user = \Yii::createObject([
            'class' => \app\models\form\ChangePasswordForm::className(),
        ]);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Password Change successfuly');
            return $this->goHome();
        }

        return $this->render('changepassword', [
                    'user' => $user
        ]);
    }

    public function actionResetmenu($userid) {
        $user_model = $this->findModel($userid);
        if ($user_model->role == 100) {
            $rista = new \sakhi\components\Rishta($user_model);
            $user_model->user_app_data_update = 1;
            $user_model->menu_version_major = \common\models\base\GenralModel::MENU_MAJOR_VERSION;
            $user_model->menu_version_minor = ($user_model->menu_version_minor + 1);
            $user_model->menu_version = ($user_model->menu_version_major + ('.' . $user_model->menu_version_minor));
            $user_model->splash_screen = $rista->splash_screen($user_model);
            $user_model->last_menu_updatetime = date("Y-m-d h:i:s");
            $user_model->save();
            $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
            if ($rishta_user_data_model == null) {
                $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
            }
            $rishta_user_data_model->user_id = $user_model->id;
            $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
            $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
            if ($rishta_user_data_model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Reset menu successfully');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAddairphone($userid) {
        $user_model = $this->findModel($userid);
        if ($user_model->airphone == null) {
            $res = Yii::$app->AirPhone->setAgentNumber($user_model->username)->addAgent($user_model->name);
            if ($res) {
                $airphone = new \common\models\AirphoneCallerStatus();
                $airphone->name = $user_model->name;
                $airphone->username = $user_model->username;
                $airphone->user_id = $user_model->id;
                $airphone->airphone_user = 1;
                $airphone->outbound = 1;
                $airphone->airphone_status = 0;
                $airphone->airphone_last_update = new \yii\db\Expression('NOW()');
                if ($airphone->save()) {
                    $res1 = Yii::$app->AirPhone->setAgentNumber($user_model->username)->updateAgentStatus('Active');
                    if ($res) {
                        $airphone->airphone_status = 1;
                        $airphone->airphone_last_update = new \yii\db\Expression('NOW()');
                        if ($airphone->airphone->save()) {
                            
                        }
                    }
                }
            }
        }
        \Yii::$app->getSession()->setFlash('success', 'Caller Add Airphone successfully');
        return $this->redirect(['/user']);
    }

    public function actionActiveairphone($userid) {
        $user_model = $this->findModel($userid);
//        print_r($user_model);exit;
        if ($user_model->airphone) {
            $res = Yii::$app->AirPhone->setAgentNumber($user_model->username)->updateAgentStatus('Active');
            if ($res) {
                $user_model->airphone->airphone_status = 1;
                $user_model->airphone->airphone_last_update = new \yii\db\Expression('NOW()');
                if ($user_model->airphone->save()) {
                    
                }
            }
            \Yii::$app->getSession()->setFlash('success', 'Caller active Airphone successfully');
            return $this->redirect(['/user']);
        }
    }

    public function actionInctiveairphone($userid) {
        $user_model = $this->findModel($userid);
        if ($user_model->airphone != null) {
            $res = Yii::$app->AirPhone->setAgentNumber($user_model->username)->updateAgentStatus('Inactive');
            if ($res) {
                $user_model->airphone->airphone_status = 0;
                $user_model->airphone->airphone_last_update = new \yii\db\Expression('NOW()');
                if ($user_model->airphone->save()) {
                    
                }
            }
            \Yii::$app->getSession()->setFlash('success', 'Caller Inactive Airphone successfully');
            return $this->redirect(['/user']);
        }
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

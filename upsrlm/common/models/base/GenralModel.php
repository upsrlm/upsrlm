<?php

namespace common\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use common\models\User;
use common\models\master\MasterRole;
use common\models\master\MasterArea;
use common\models\master\MasterDivisionSearch;
use common\models\master\MasterDistrictSearch;
use common\models\master\MasterBlockSearch;
use common\models\master\MasterGramPanchayatSearch;
use common\models\master\MasterVillageSearch;
use common\models\master\MasterTownSearch;
use common\models\master\MasterTown;
use common\models\master\MasterUlbSearch;
use common\models\master\MasterWardSearch;
use common\models\RelationUserGramPanchayatSearch;
use common\models\RelationUserUlbSearch;
use common\models\RelationUserDistrictSearch;
use common\models\RelationUserBdoBlockSearch;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;

class GenralModel extends \yii\base\Model {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const AREA_RURAL = 1;
    const AREA_URBAN = 2;
    const STATUS_DELETE = -1;
    const STATUS_SUBMIT = 1;
    const STATUS_ELIGIBLE = 2;
    const STATUS_NOTELIGLE = 31;
    const STATUS_SKIP = 4;
    const TOWN_TYPE_MCORP = 1;
    const TOWN_TYPE_NPP = 2;
    const TOWN_TYPE_NP = 3;
    const TOWN_TYPE_CT = 4;
    // Cloud Connectio status constant
    const CONNECTION_STATUS_PHONE_PICKED = 1;
    const CONNECTION_STATUS_BELL_RINGS = 21;
    const CONNECTION_STATUS_BUSY = 22;
    const CONNECTION_STATUS_UNREACHEBLE = 23;
    const CONNECTION_STATUS_MOBILE_SWITCH_OFF = 24;
    const CONNECTION_STATUS_WRONG_NO_DOES_NOT_EXIST = 30;
    // end Connectio status
    // Cloud Call status constant
    const CALL_STATUS_CALL_CONTINUED = 10;
    const CALL_STATUS_WRONG_NUMBER = 11;
    const CALL_STATUS_OTHER_FAMILY_MEMBER = 12;
    const CALL_STATUS_DID_NOT_TALK = 13;
    // end call status

    const CALL_TYPE_OUTBOUND = 1;
    const CALL_TYPE_INBOUND = 2;
    const CALL_SCENARIO_RSETHI_BATCH_CREATE = 1;
    const CALL_SCENARIO_SHG_MEMBER_CHAIRPERSION_VERIFY = 300;
    const CALL_SCENARIO_SHG_MEMBER_SECRETARY_VERIFY = 301;
    const CALL_SCENARIO_SHG_MEMBER_TREASURER_VERIFY = 302;
    const CALL_SCENARIO_SHG_CST_MEMBER_CONFIRM_GOT_APP_SMS = 303;
    const CALL_SCENARIO_SHG_CST_MEMBER_CONFIRM_APP_INSTALL = 304;
    const CALL_SCENARIO_SHG_CST_MEMBER_CONFIRM_APP_DOWNLOAD = 305;
    const CALL_SCENARIO_SHG_CST_MEMBER_NOMINATE_SAMUH_SAKHI = 306;
    const CALL_SCENARIO_SHG_CST_MEMBER_CONFIRM_SUGESST_SAMUH_SAKHI = 401;
    const CALL_SCENARIO_SHG_SAMUH_SAKHI_FORM_COMPLETE = 404;
    const CALL_SCENARIO_BMMU_WADA_INFO = 2000;
    const MAX_ROW_DOWNLOAD_CSV = 6000;
    const APP_CLF_BG_COLOR = '#59e2fe';
    const APP_VO_BG_COLOR = '#a3f0ff';
    const APP_SHG_BG_COLOR = '#d7f8ff';
    const APP_BC_BG_COLOR = '#FDB5DF';
    const APP_ONLINE_BG_COLOR = '#c6e8f7';
    const APP_MOPUP_COLOR = '#0018F9';
    const MENU_MAJOR_VERSION = 1;
    // SHG Member source constant
    const SHG_MEMBER_SOURCE_BMMU = 1;
    const SHG_MEMBER_SOURCE_BC = 2;
    const SHG_MEMBER_SOURCE_CALL_CENTER = 3;
    const SHG_MEMBER_SOURCE_CBO = 4;
    // end SHG Member source constant
    // SHG Member status constant
    const SHG_MEMBER_STATUS_ACTIVE = 1;
    const SHG_MEMBER_STATUS_DELETED = -1;
    const SHG_MEMBER_STATUS_WRONG_MOBILE_NO = -2;

    // end SHG Member source constant
    public static $coll_district = 'district_code';
    public static $coll_sub_district = 'sub_district_code';
    public static $coll_village = 'village_code';
    public static $coll_block = 'block_code';
    public static $coll_gram_panchayat = 'gram_panchayat_id';

    public static function nfsahhsoption() {
        $array = [];
        if (isset(Yii::$app->user->identity)) {
            $user_model = Yii::$app->user->identity;
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_SUBMIT, NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_RETURN_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_SUBMIT, NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_RETURN_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_SUBMIT, NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_RETURN_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_SUBMIT, NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_RETURN_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_SUBMIT, NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_RETURN_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_SUBMIT, NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_RETURN_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_SUBMIT, NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_RETURN_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_SECONDARY_ENUMERATOR])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_SUBMIT, NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_RETURN_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MC])) {
                $model = NfsaMasterHhsStatus::find()->where(['id' => [NfsaBaseSurvey::STATUS_ELIGIBLE_BY_BDO, NfsaBaseSurvey::STATUS_NOTELIGLE_BY_BDO, NfsaBaseSurvey::STATUS_APPLICATION_RECEIVED], 'status' => self::STATUS_ACTIVE])->all();
                $array = ArrayHelper::map($model, 'id', 'english_name');
            } else {
                
            }
        }
        return $array;
    }

    public static function nfsaprimaryruraloptiongp($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new RelationUserGramPanchayatSearch();
            $searchModel->role = [MasterRole::ROLE_GP_SAACHIV, MasterRole::ROLE_GP_ADHIKARI];
            $searchModel->status = 1;
            $searchModel->user_status = 1;
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->block_code) and $md->block_code) {
                $searchModel->block_code = $md->block_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, \app\models\RelationUserGramPanchayatSearch::$coll_secondary_user);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'user_id', function ($model) {
                    return $model->user->name . ' (' . implode(', ', ArrayHelper::getColumn($model->user->grampanchayat, 'gp.gram_panchayat_name')) . ')';
                }) : [];
        return isset($model) ? ArrayHelper::map($model, 'user_id', 'user.name') : [];
    }

    public static function nfsaprimaryruraloption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new RelationUserGramPanchayatSearch();
            $searchModel->role = [MasterRole::ROLE_GP_SAACHIV, MasterRole::ROLE_GP_ADHIKARI];
            $searchModel->status = 1;
            $searchModel->user_status = 1;
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->block_code) and $md->block_code) {
                $searchModel->block_code = $md->block_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, \app\models\RelationUserGramPanchayatSearch::$coll_secondary_user);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'user_id', 'user.name') : [];
    }

    public static function nfsaprimaryurbanoption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new RelationUserUlbSearch();
            $searchModel->role = [MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR];
            $searchModel->status = 1;
            $searchModel->user_status = 1;
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->ulb_code) and $md->ulb_code) {
                $searchModel->ulb_code = $md->ulb_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, RelationUserUlbSearch::$coll_secondary_user);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'user_id', 'user.name') : [];
    }

    public static function nfsasecondaryruraloption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \app\models\RelationUserGramPanchayatSearch();
            $searchModel->role = [\app\models\master\MasterRole::ROLE_URBAN_SECONDARY_ENUMERATOR];
            $searchModel->status = 1;
            $searchModel->user_status = 1;
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->block_code) and $md->block_code) {
                $searchModel->block_code = $md->block_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, \app\models\RelationUserGramPanchayatSearch::$coll_secondary_user);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'user_id', 'user.name') : [];
    }

    public static function nfsasecondaryurbanoption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new RelationUserUlbSearch();
            $searchModel->role = [MasterRole::ROLE_GP_SAACHIV, MasterRole::ROLE_GP_ADHIKARI];
            $searchModel->status = 1;
            $searchModel->user_status = 1;
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->ulb_code) and $md->ulb_code) {
                $searchModel->ulb_code = $md->ulb_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, RelationUserUlbSearch::$coll_secondary_user);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'user_id', 'user.name') : [];
    }

    public static function nfsaaraeoption($md = null) {
        $model = MasterArea::find()->where(['status' => self::STATUS_ACTIVE])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'english_name') : [];
    }

    public static function nfsaoptionrole($md = null) {
        $model = MasterRole::find()->andWhere(['!=', 'id', MasterRole::ROLE_ADMIN])->andWhere(['!=', 'id', MasterRole::ROLE_SUPER_ADMIN])->andWhere(['status' => self::STATUS_ACTIVE])->orderBy('role_name asc')->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'role_name') : [];
    }

    public static function roleoption($md = null) {
        $model = MasterRole::find()->andWhere(['!=', 'id', MasterRole::ROLE_ADMIN])->andWhere(['!=', 'id', MasterRole::ROLE_SUPER_ADMIN])->andWhere(['status' => self::STATUS_ACTIVE])->orderBy('role_name asc')->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'role_name') : [];
    }

    public static function nfsaoptiondivision($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterDivisionSearch();
            $dataProvider = $searchModel->search([], Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'division_code', 'division_name') : [];
    }

    public static function nfsaoptiondistrict($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterDistrictSearch();
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->master_partner_bank_id) and $md->master_partner_bank_id) {
                $searchModel->master_partner_bank_id = $md->master_partner_bank_id;
            }
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            if (isset($md->wada) and $md->wada) {
                $searchModel->wada_district = $md->wada;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, GenralModel::select_district_drop_columns());
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'district_code', 'district_name') : [];
    }

    public static function district_options($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterDistrictSearch();
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->state_code) and $md->state_code) {
                $searchModel->state_code = $md->state_code;
            }
            if (isset($md->master_partner_bank_id) and $md->master_partner_bank_id) {
                $searchModel->master_partner_bank_id = $md->master_partner_bank_id;
            }
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            if (isset($md->wada) and $md->wada) {
                $searchModel->wada_district = $md->wada;
            }
            $dataProvider = $searchModel->search($searchModel, null, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'district_code', 'district_name') : [];
    }

    public static function state_options($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \common\models\master\MasterStateSearch();

            $dataProvider = $searchModel->search($searchModel, null, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'state_code', 'state_name') : [];
    }

    public static function nfsaoptionulb($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterUlbSearch();
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'ulb_code', 'ulb_name') : [];
    }

    public static function nfsaoptionward($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterWardSearch();
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->ulb_code) and $md->ulb_code) {
                $searchModel->ulb_code = $md->ulb_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'ward_code', 'ward_name') : [];
    }

    public static function nfsaoptionblock($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterBlockSearch();
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            if (isset($md->wada) and $md->wada) {
                $searchModel->wada_block = $md->wada;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'block_code', 'block_name') : [];
    }

    public static function nfsaoptionblockdistrict($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterBlockSearch();
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->district_code)) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            if (isset($md->wada) and $md->wada) {
                $searchModel->wada_block = $md->wada;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'block_code', function ($model) {
                    return $model->block_name . ' (' . $model->district->district_name . ')';
                }) : [];
    }

    public static function nfsaoptiongp($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterGramPanchayatSearch();
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->block_code) and $md->block_code) {
                $searchModel->block_code = $md->block_code;
            }
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            if (isset($md->wada) and $md->wada) {
                $searchModel->wada_gp = $md->wada;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, null, GenralModel::select_gp_drop_columns());
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'gram_panchayat_code', 'gram_panchayat_name') : [];
    }

    public static function nfsaoptionvillage($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterVillageSearch();
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->block_code) and $md->block_code) {
                $searchModel->block_code = $md->block_code;
            }
            if (isset($md->gram_panchayat_code) and $md->gram_panchayat_code) {
                $searchModel->gram_panchayat_code = $md->gram_panchayat_code;
            }
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'village_code', 'village_name') : [];
    }

    public static function nfsaoptionruralprimaryuser($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new RelationUserGramPanchayatSearch();
            $searchModel->status = GenralModel::STATUS_ACTIVE;
            $searchModel->role = [MasterRole::ROLE_GP_SAACHIV, MasterRole::ROLE_GP_ADHIKARI];
            if (isset($md->district_code)) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->block_code)) {
                $searchModel->block_code = $md->block_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, \app\models\RelationUserGramPanchayatSearch::$coll_primary_user);

            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'primary_user_id', 'primaryuser.name') : [];
    }

    public static function nfsaoptionurbanprimaryuser($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new RelationUserUlbSearch();
            $searchModel->status = GenralModel::STATUS_ACTIVE;
            $searchModel->user_status = GenralModel::STATUS_ACTIVE;
            $searchModel->role = [MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR];
            if (isset($md->ulb_code)) {
                $searchModel->ulb_code = $md->ulb_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, \app\models\RelationUserUlbSearch::$coll_primary_user);

            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'primary_user_id', 'primaryuser.name') : [];
    }

    public static function nfsaoptionreturnreasion($md = null) {
        $array = [
            1 => 'आधार कार्ड पर दी गई जानकारी का घर के पते या मुखिया की जानकारी से मेल न खाना ',
            2 => 'आधार कार्ड का नंबर आधार की फोटो से न मिलना I',
            3 => 'घर के मुखिया का नाम, फोटो, आधार (फोटो एवं नंबर) एवं बैंक पासबुक के सूचना एकरूपता न होना;',
            4 => "(a) घर के मुखिया, (b) परिवार के सभी सदस्यों का ग्रुप फोटो, एवं (c) घर का फोटो के स्थान पर, 'फोटो का फोटो' लगा होना  ",
            5 => 'आधार, बैंक पासबुक इत्यादि की फोटो का अस्पष्ट होना, धुंधले व अस्पष्ट फोटो लेना',
            6 => 'गृह का फोटो सम्पूर्णता में ना होना; यह स्पष्ट न होना कि आवेदनकर्ता का घर कौन सा है I ',
            7 => 'असम्पूर्ण आवेदन- फॉर्म में मांगी गई जानकारियों का पूर्ण न होना;',
            8 => 'आवेदनकर्ता की आयु अठारह वर्ष से कम होना/ जानकारी का संशयपूर्ण/ गलत होना',
        ];
        return $array;
    }

    public static function nfsaoptionnoteligblereasion($md = null) {
        $array = [
            1 => 'निष्कासन के आधार में दिए गए विकल्पों में किसी एक पर सही का निशान होना',
            2 => 'आवेदनकर्ता का बैंक खाता न होना',
            3 => 'आवेदनकर्ता का आधार कार्ड न होना',
        ];
        return $array;
    }

    public static function townoption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterTownSearch();
            if (isset($md->district_name)) {
                $searchModel->district_name = $md->district_name;
            }
            $dataProvider = $searchModel->search($searchModel, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'district_code', 'district_name') : [];
    }

    public static function blockopption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterBlockSearch();
            if (isset($md->district_code)) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, GenralModel::select_block_drop_columns());
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'block_code', function ($model) {
                    return $model->block_name . ' (' . $model->district_name . ')';
                }) : [];
    }

    public static function srlmblockopption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterBlockSearch();
            if (isset($md->district_code)) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, GenralModel::select_block_drop_columns(), true);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'block_code', function ($model) {
                    return $model['block_name'] . ' (' . $model['district_name'] . ')';
                }) : [];
    }

    public static function optiondistrict($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterVillageSearch();
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            $dataProvider = $searchModel->search($md, Yii::$app->user->identity, false, static::$coll_district);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'district_code', 'district_name') : [];
    }

    public static function optionsubdistrict($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterVillageSearch();
            $dataProvider = $searchModel->search($md, Yii::$app->user->identity, false, static::$coll_sub_district);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'sub_district_code', 'sub_district_name') : [];
    }

    public static function optionblock($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterVillageSearch();
            $dataProvider = $searchModel->search($md, Yii::$app->user->identity, false, static::$coll_block);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'block_code', 'block_name') : [];
    }

    public static function optiongp($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterVillageSearch();
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            $dataProvider = $searchModel->search($md, Yii::$app->user->identity, false, static::$coll_gram_panchayat);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'gram_panchayat_id', 'gram_panchayat_name') : [];
    }

    public static function cbo_shgs_option($md = null) {
        if (isset(Yii::$app->user->identity)) {
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                return [];
            } else {
                $searchModel = new \cbo\models\ShgSearch();
                $dataProvider = $searchModel->search($md, Yii::$app->user->identity, false);
                $dataProvider->query->andWhere(['is', 'cbo_vo_id', new \yii\db\Expression('null')]);
                $model = $dataProvider->getModels();
            }
        }
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_of_shg') : [];
    }

    public static function optionvillage($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterVillageSearch();
            if (isset($md->saheli) and $md->saheli) {
                $searchModel->saheli = $md->saheli;
            }
            $dataProvider = $searchModel->search($md, Yii::$app->user->identity, false, static::$coll_village);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'village_code', 'village_name') : [];
    }

    public static function srlmcostoption($md = null) {
        $model = \bc\modules\selection\models\master\BcApplicationMasterCast::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function cbo_funds_type_option($type = null) {
        $query = \cbo\models\master\CboMasterFundtype::find()->where(['status' => 1]);
        if ($type == "shg") {
            $query->andWhere(['shg' => 1])->orderBy(['shg_order' => SORT_ASC]);
        }
        if ($type == "vo") {
            $query->andWhere(['vo' => 1])->orderBy(['vo_order' => SORT_ASC]);
        }
        if ($type == "clf") {
            $query->andWhere(['clf' => 1])->orderBy(['clf_order' => SORT_ASC]);
        }
        $model = $query->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'fund_type') : [];
    }

    public static function rishta_funds_type_option($type = null) {
        $query = \common\models\dynamicdb\cbo_detail\master\CboMasterFundtype::find()->where(['status' => 1]);
        if ($type == "shg") {
            $query->andWhere(['shg' => 1])->orderBy(['shg_order' => SORT_ASC]);
        }
        if ($type == "vo") {
            $query->andWhere(['vo' => 1])->orderBy(['vo_order' => SORT_ASC]);
        }
        if ($type == "clf") {
            $query->andWhere(['clf' => 1])->orderBy(['clf_order' => SORT_ASC]);
        }
        $model = $query->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'fund_type') : [];
    }

    public static function rishta_bank_option($md = null) {
        $model = \common\models\dynamicdb\cbo_detail\master\CboMasterBank::find()->where(['status' => 1])->orderBy('bank_name asc')->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'bank_name') : [];
    }

    public static function cbo_bank_option($md = null) {
        $model = \cbo\models\master\CboMasterBank::find()->where(['status' => 1])->orderBy('bank_name asc')->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'bank_name') : [];
    }

    public static function cbo_member_role_option($md = null) {
        $model = \cbo\models\master\CboMasterMemberRole::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'role') : [];
    }

    public static function srlmagegrouptoption($md = null) {
        $model = [1 => '18-25 Years', 2 => '26-32 Years', 3 => '33-40 Years', 4 => '41-50 Years', 5 => 'Above 50'];
        return isset($model) ? $model : [];
    }

    public static function srlmreadingskillsoption($md = null) {
        $model = \bc\modules\selection\models\master\BcApplicationMasterReadingSkills::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function srlmphonetypeoption($md = null) {
        $model = \bc\modules\selection\models\master\BcApplicationMasterPhoneType::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function srlmmaritalstatusoption($md = null) {
        $model = [1 => 'Married', 2 => 'Unmarried'];
        return isset($model) ? $model : [];
    }

    public static function profilesoption() {
        $model = [0 => 'Not Initiated', 2 => 'Incomplete', 1 => 'Complete'];
        return isset($model) ? $model : [];
    }

    public static function srlmalreadygroupmemberoption($md = null) {
        $model = \bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function shg_feedback_ques6p1_option() {
        $model = [
            1 => '6.1 बहुत ही अच्छा; हमारे समूह के सभी सदस्यों की ज़िंदगी बदल गयी ।',
            2 => '6.2 ठीक ठाक; मिशन के कार्यक्रमों के कारण हमारे जीवन में अच्छे बदलाव की सम्भावना है ।',
            3 => '6.3 कुछ बता नहीं सकते; काफ़ी समय हो जाने के बाद भी कार्यक्रम से हमें कुछ ख़ास लाभ नहीं मिल पाया है ।'
        ];
        return isset($model) ? $model : [];
    }

    public static function shg_feedback_ques6p2_option() {
        $model = [
            4 => '6.4 समूह संचालन की प्रक्रिया हमारे सक्षमता से से कही ज़्यादा जटिल है – प्रशिक्षण होने पर भी सफलता पूर्वक करना मुश्किल है ।',
            5 => '6.5 समूह में  बैठक़, वचत एवं अन्य गतिविधि में काफ़ी समय जाता है; आजीविका से जुड़े विषय पर धीमी प्रगति होती है;',
            6 => '6.6 मिशन मैनेजर हमसे तभी सम्बद्ध होते हैं जब मिशन से समूह के बारे में सूचनाएँ माँगी जाती है ।',
            7 => '6.7 लम्बे समय तक इंतज़ार करने पर भी ऋण मिलने पर कोई बात नहीं होती है ।',
            8 => '6.8 मिशन मैनेजर के प्रभाव से ही समूह की प्राथमिकता तय होती है – वे ही निश्चित करते हैं कि समूह कैसे चलेगा ।',
            9 => '6.9 लेन देन के बही खाते लिखना मुश्किल है, BMM के मदद के बिना समूह का कार्यवाही चलाना मुश्किल है ।',
            10 => '6.10 ऋण लेन देन की प्रक्रिया सही नहीं है – पक्षपात/ धांधली होता है;  इसमें सुधार की ज़रूरत है ।',
            11 => '6.11 माइक्रो-क्रेडिट प्लान (MCP) भरना बहुत ही जटिल है; इसे नहीं भर पाने के कारण ऋण मिलने में देरी होती है ।'
        ];
        return isset($model) ? $model : [];
    }

    public static function shg_feedback_ques6p3_option() {
        $model = [
            12 => '6.12 समूहों के सदस्यों के आजीविका व उनके ऋण प्राप्ति पर शुरू से ही प्रमुखता दी जाए;',
            13 => '6.13 बैंक से ऋण प्राप्त करने से ज़्यादा प्राथमिकता मिशन के माध्यम से ऋण प्राप्त करने पर दिया जाए;',
            14 => '6.14 सभी सदस्य के लिए माइक्रो-क्रेडिट प्लान (MCP) भर कर रखा जाए ताकि रोटेशन आने पर उन्हें ऋण मिलने देरी ना हो;',
            15 => '6.15 हर समूह के सदस्य को ये स्पष्ट समय सीमा बताया जाए कि उनके कितने समय में ऋण मिल सकेगा ।',
            16 => '6.16 सभी सदस्य को ऋण मिलने से पूर्व, उनके सम्भावित रोज़गार/ उद्यम से सम्बंधित प्रशिक्षण/ जानकारी दी जाए ताकि वे सफल हो सकें ।',
            17 => '6.17 हो सके तो ऋण पाने वाले सम्भावित सदस्यों को पूर्व सूचना हो कि ग्राम संगठन (VO) या संकुल (CLF) से उन को भुगतान किस दिन हो सकेगी;',
            18 => '6.18 सभी समूह के पास जानकारी के लिए और आवश्यक हो तो शिकायत करने के लिए कॉल सेंटर की व्यवस्था हो ताकि मिशन के मुख्यालय तक हमारी बात पहुँच सके'
        ];
        return isset($model) ? $model : [];
    }

    public static function rishta_shg_member_option($md = null) {
        $models = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['status' => 1, 'cbo_shg_id' => $md->cbo_shg_id])->orderBy('name asc')->all();

        $array = [];
        foreach ($models as $model) {
            $ch = User::find()->where(['username' => $model->mobile])->andWhere(['!=', 'role', 100])->count();
            if ($ch == '0') {
                $array[$model->id] = $model->name . ' (' . $model->mobile . ')';
            }
        }
        return $array;
    }

    public static function cloud_tel_connection_status_option($md = null) {
        $array = [
            GenralModel::CONNECTION_STATUS_MOBILE_SWITCH_OFF => 'Mobile switch off',
            GenralModel::CONNECTION_STATUS_BELL_RINGS => 'Bell Ring',
            GenralModel::CONNECTION_STATUS_WRONG_NO_DOES_NOT_EXIST => 'Wrong No. does not exist',
            GenralModel::CONNECTION_STATUS_BUSY => 'Busy',
            GenralModel::CONNECTION_STATUS_UNREACHEBLE => 'Unreaceble',
            GenralModel::CONNECTION_STATUS_PHONE_PICKED => 'Phone Picked',
        ];

        return $array;
    }

    public static function cloud_tel_call_status_option($md = null) {
        $array = [
            GenralModel::CALL_STATUS_WRONG_NUMBER => 'Wrong number',
            GenralModel::CALL_STATUS_OTHER_FAMILY_MEMBER => 'Other family member',
            GenralModel::CALL_STATUS_DID_NOT_TALK => 'Did not talk',
            GenralModel::CALL_STATUS_CALL_CONTINUED => 'Call Continued',
        ];

        return $array;
    }

    public static function cloud_tel_api_call_status_option($md = null) {
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterApiCallStatus::find()->where(['status' => self::STATUS_ACTIVE])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return $model['id'] . ' : ' . $model['call_status_ctc'] . '';
                }) : [];
    }

    public static function cloud_tel_api_call_status_genral_option($md = null) {
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterApiCallStatus::find()->where(['status' => self::STATUS_ACTIVE])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return $model['id'] . ' : ' . $model['call_status_genral'] . '';
                }) : [];
    }

    public static function cloud_tel_api_status_code_option($md = null) {
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterApiErrorCode::find()->andWhere(['status' => self::STATUS_ACTIVE])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'error_discription') : [];
    }

    public static function cloud_tel_call_scenario_option($md = null) {
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallScenario::find()->andWhere(['status' => self::STATUS_ACTIVE])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'call_scenario') : [];
    }

    public static function cloud_tel_call_quality_option($md = null) {
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallQuality::find()->andWhere(['status' => self::STATUS_ACTIVE])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'call_quality') : [];
    }

    public static function cloud_tel_call_outcome_option($md = null) {
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallOutcome::find()->andWhere(['status' => self::STATUS_ACTIVE])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'call_outcome') : [];
    }

    public static function cloud_tel_call_again_option($md = null) {
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallAgain::find()->andWhere(['status' => self::STATUS_ACTIVE])->orderBy(['order_by' => SORT_ASC])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'call_again') : [];
    }

    public static function cloud_tel_smart_phone_whose_option($md = null) {
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterSmartPhoneWhose::find()->andWhere(['status' => self::STATUS_ACTIVE])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'smart_phone_whose') : [];
    }

    public static function select_user_columns() {
        $columns = [
            'user.id',
            'user.name',
            'user.username',
            'user.mobile_no',
            'user.email',
            'user.role',
            'user.login_by_otp',
            'user.profile_status',
            'user.otp_value',
            'user.status',
            'user.user_app_data_update'
        ];
        return $columns;
    }

    public static function select_district_drop_columns() {
        $columns = [
            'master_district.id',
            'master_district.district_code',
            'master_district.district_name',
        ];
        return $columns;
    }

    public static function select_block_drop_columns() {
        $columns = [
            'master_block.id',
            'master_block.block_code',
            'master_block.block_name',
            'master_block.district_name',
        ];
        return $columns;
    }

    public static function select_gp_drop_columns() {
        $columns = [
            'master_gram_panchayat.id',
            'master_gram_panchayat.gram_panchayat_code',
            'master_gram_panchayat.gram_panchayat_name',
            'master_gram_panchayat.block_name',
            'master_gram_panchayat.district_code',
            'master_gram_panchayat.district_name',
        ];
        return $columns;
    }

    public static function select_village_drop_columns() {
        $columns = [
            'master_village.id',
            'master_village.village_code',
            'master_village.village_name',
            'master_village.gram_panchayat_name',
            'master_village.block_name',
            'master_village.district_name',
        ];
        return $columns;
    }

    public static function select_cloud_tele_log_columns() {
        $columns = [
            CloudTeleApiLog::getTableSchema()->fullName . '.id',
            CloudTeleApiLog::getTableSchema()->fullName . '.bc_application_id',
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_user_id',
            CloudTeleApiLog::getTableSchema()->fullName . '.api_status_code',
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_scenario',
            CloudTeleApiLog::getTableSchema()->fullName . '.api_request_datetime',
            CloudTeleApiLog::getTableSchema()->fullName . '.ivrSTime',
            CloudTeleApiLog::getTableSchema()->fullName . '.ivrETime',
            CloudTeleApiLog::getTableSchema()->fullName . '.ivrDuration',
            CloudTeleApiLog::getTableSchema()->fullName . '.masterAgent',
            CloudTeleApiLog::getTableSchema()->fullName . '.masterGroupId',
            CloudTeleApiLog::getTableSchema()->fullName . '.talkDuration',
            CloudTeleApiLog::getTableSchema()->fullName . '.agentOnCallDuration',
            CloudTeleApiLog::getTableSchema()->fullName . '.firstAnswerTime',
            CloudTeleApiLog::getTableSchema()->fullName . '.lastHangupTime',
            CloudTeleApiLog::getTableSchema()->fullName . '.lastFirstDuration',
            CloudTeleApiLog::getTableSchema()->fullName . '.custAnswerSTime',
            CloudTeleApiLog::getTableSchema()->fullName . '.custAnswerETime',
            CloudTeleApiLog::getTableSchema()->fullName . '.custAnswerDuration',
            CloudTeleApiLog::getTableSchema()->fullName . '.callStatus',
            CloudTeleApiLog::getTableSchema()->fullName . '.HangupBySourceDetected',
            CloudTeleApiLog::getTableSchema()->fullName . '.totalHoldDuration',
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_connection_status',
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_status',
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_quality',
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_outcome',
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_again',
            CloudTeleApiLog::getTableSchema()->fullName . '.smart_phone_whose',
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_user_mobile_no',
            CloudTeleApiLog::getTableSchema()->fullName . '.customernumber',
            CloudTeleApiLog::getTableSchema()->fullName . '.recording_file',
            CloudTeleApiLog::getTableSchema()->fullName . '.api_status',
            CloudTeleApiLog::getTableSchema()->fullName . '.api_message'
        ];
        return $columns;
    }

    public static function select_cloud_tele_log_columns_no_table_schema() {
        $columns = [
            'id',
            'bc_application_id',
            'upsrlm_user_id',
            'api_status_code',
            'upsrlm_call_scenario',
            'api_request_datetime',
            'ivrSTime',
            'ivrETime',
            'ivrDuration',
            'masterAgent',
            'masterGroupId',
            'talkDuration',
            'agentOnCallDuration',
            'firstAnswerTime',
            'lastHangupTime',
            'lastFirstDuration',
            'custAnswerSTime',
            'custAnswerETime',
            'custAnswerDuration',
            'callStatus',
            'HangupBySourceDetected',
            'totalHoldDuration',
            'upsrlm_connection_status',
            'upsrlm_call_status',
            'upsrlm_call_quality',
            'upsrlm_call_outcome',
            'upsrlm_call_again',
            'smart_phone_whose',
            'upsrlm_user_mobile_no',
            'customernumber',
            'recording_file',
            'api_status',
            'api_message',
            'created_at',
            'updated_at',
        ];
        return $columns;
    }

    public static function select_cbo_shg_columns() {
        $columns = [
            \cbo\models\Shg::getTableSchema()->fullName . '.id',
            \cbo\models\Shg::getTableSchema()->fullName . '.division_name',
            \cbo\models\Shg::getTableSchema()->fullName . '.district_code',
            \cbo\models\Shg::getTableSchema()->fullName . '.district_name',
            \cbo\models\Shg::getTableSchema()->fullName . '.block_code',
            \cbo\models\Shg::getTableSchema()->fullName . '.block_name',
            \cbo\models\Shg::getTableSchema()->fullName . '.gram_panchayat_code',
            \cbo\models\Shg::getTableSchema()->fullName . '.gram_panchayat_name',
            \cbo\models\Shg::getTableSchema()->fullName . '.village_code',
            \cbo\models\Shg::getTableSchema()->fullName . '.village_name',
            \cbo\models\Shg::getTableSchema()->fullName . '.hamlet',
            \cbo\models\Shg::getTableSchema()->fullName . '.name_of_shg',
            \cbo\models\Shg::getTableSchema()->fullName . '.shg_code',
            \cbo\models\Shg::getTableSchema()->fullName . '.no_of_members',
            \cbo\models\Shg::getTableSchema()->fullName . '.return',
            \cbo\models\Shg::getTableSchema()->fullName . '.urban_shg',
            \cbo\models\Shg::getTableSchema()->fullName . '.ch_user_id',
            \cbo\models\Shg::getTableSchema()->fullName . '.se_user_id',
            \cbo\models\Shg::getTableSchema()->fullName . '.te_user_id',
            \cbo\models\Shg::getTableSchema()->fullName . '.ss_user_id',
            \cbo\models\Shg::getTableSchema()->fullName . '.ws_user_id',
            \cbo\models\Shg::getTableSchema()->fullName . '.bc_user_id',
            \cbo\models\Shg::getTableSchema()->fullName . '.no_of_user',
            \cbo\models\Shg::getTableSchema()->fullName . '.no_of_cst_user',
            \cbo\models\Shg::getTableSchema()->fullName . '.no_of_cst_user_used_rishta',
            \cbo\models\Shg::getTableSchema()->fullName . '.no_of_cst_user_login',
            \cbo\models\Shg::getTableSchema()->fullName . '.no_of_cst_user_not_login',
            \cbo\models\Shg::getTableSchema()->fullName . '.is_bc',
            \cbo\models\Shg::getTableSchema()->fullName . '.no_of_user_used_rishta',
            \cbo\models\Shg::getTableSchema()->fullName . '.suggest_samuh_sakhi',
            \cbo\models\Shg::getTableSchema()->fullName . '.suggest_samuh_sakhi_completed_application',
            \cbo\models\Shg::getTableSchema()->fullName . '.suggest_samuh_sakhi_save_application',
            \cbo\models\Shg::getTableSchema()->fullName . '.shg_profile_updated',
            \cbo\models\Shg::getTableSchema()->fullName . '.no_of_member_added',
            \cbo\models\Shg::getTableSchema()->fullName . '.bank_detail_add',
            \cbo\models\Shg::getTableSchema()->fullName . '.no_of_fund_received',
            \cbo\models\Shg::getTableSchema()->fullName . '.total_fund_received_amount',
            \cbo\models\Shg::getTableSchema()->fullName . '.shg_feedback',
            \cbo\models\Shg::getTableSchema()->fullName . '.status',
            \cbo\models\Shg::getTableSchema()->fullName . '.verify_over_all',
            \cbo\models\Shg::getTableSchema()->fullName . '.created_by',
            \cbo\models\Shg::getTableSchema()->fullName . '.updated_by',
        ];
        return $columns;
    }

    public static function current_month_id_cloud() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andFilterWhere(['=', 'month_end_date', $last_day_month])->limit(1)->one();
        return isset($model) ? $model->id : null;
    }

    public static function cloud_monthoption() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $model = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andFilterWhere(['<=', 'month_end_date', $last_day_month])->orderBy('month_end_date desc')->all();
        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->month_end_date, "php:M-Y");
                }) : [];
    }

    public static function dbt_mgnrega_work_day_option($md = null) {
        $array = [
            1 => '7 से कम दिन',
            2 => '7 दिन',
            3 => '14 दिन',
            4 => '21 दिन',
            5 => '28 दिन',
            99 => 'ज़्यादा',
        ];

        return $array;
    }

    public static function relation_option() {
        $relation_option = [1 => 'स्वयं', 2 => 'पति', 3 => 'पत्नी', 4 => 'पिता', 5 => 'पुत्र', 6 => 'ससुर/ जेठ/ देवर', 99 => 'अन्य'];
        return $relation_option;
    }

    public static function month_option_basic_education() {
        $month_option = [];
        $maxdate = \common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiaryBasicEducationPayment::find()->max('payment_date');
        $mindate = \common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiaryBasicEducationPayment::find()->min('payment_date');
        $start = new \DateTime($mindate);
        $start->modify('first day of this month');
        $end = new \DateTime($maxdate);
        $end->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $temp = $dt->format("Y-m") . '-01';
            $month_option[$dt->format("Y-m") . '-01'] = date('F Y', strtotime($temp));
        }
        return $month_option;
    }

    public static function month_option_cloud_call($mindate = '2022-02-01') {
        $month_option = [];
        $maxdate = date('Y-m-d');
        $start = new \DateTime($mindate);
        $start->modify('first day of this month');
        $end = new \DateTime($maxdate);
        $end->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $temp = $dt->format("Y-m") . '-01';
            $month_option[$dt->format("Y-m") . '-01'] = date('F Y', strtotime($temp));
        }
        return $month_option;
    }

    public static function ultrapoor_nolimit_gp() {
        $arr = [
            66347,
            66360,
            66850,
            76447,
            76485,
            76506,
            76511,
            76582,
            76594,
            76600,
            76709,
            76720,
            76730,
            76741,
            76767,
            76777,
            76852,
            76858,
            76957,
            76978,
            268069,
            268135,
            268445,
            268570,
            268742,
            269490,
            272568
        ];
        return $arr;
    }
    public static function bc_grievance_group() {
        $arr = [
            1 => "हैंडहेल्ड मशीन /माइक्रो एटीएम से सम्बंदित (Handheld device)",
            2 => "फ्रॉड ट्रांसक्शन से संबंधित  (Fraud transaction)",
            3 => "बैंक से संबंधित (Problems with bank)",
            4 => "बीसी सखी के कमीशन भुकतान से संबंधित (BC commissions payment)",
            5 => "कोई अन्य समस्या (Any other)",
        ];
        return $arr;
    }
    public static function bc_call_scenario() {
        $arr = [
            501 => "Aadhar & Profile Photo Upload",
            502 => "Personal Bank Details Upload",
            503 => "SHG Bank Details Upload",
            504 => "PAN Card Photo Upload",
            505 => "Personal Bank Passbook Return",
            506 => "SHG Bank Passbook Return",
            507 => "SHG Not Assigned",
            508 => "Delivery of PIN",
            509 => "Received of Support Fund to BC",
            510 => "Photograph of Hand Held Machine",
            511 => "बीसी सखी ऐप से रिश्ता ऐप पर अपग्रेड के लिए",
            512 => 'साड़ी अपडेट',
            513 => 'प्रशिक्षण व संवेदीकरण',
            514 => 'Basic education acknowledge form',
            515 => 'मानदेय अपडेट',
            516 => 'प्रीसलेक्टेड (RSETI ट्रेनिंग व अन्य सूचना के लिए)',
            517 => 'प्रेसलेक्टेड अनविलिंग',
            518 => 'अनवलिंग आफ्टर सर्टिफाइड',
            519 => 'अनवलिंग आफ्टर सर्टिफाइड for support funds',
            530 => 'अन्य शिकायतों से संबंधित',
            550 => 'Transaction से संबंधित',
        ];
        return $arr;
    }
    public static function seconds2human($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;
        if ($hours < 9) {
            $hours = '0' . $hours;
        }
        if ($minutes < 9) {
            $minutes = '0' . $minutes;
        }
        if ($seconds < 9) {
            $seconds = '0' . $seconds;
        }
        return "$hours:$minutes:$seconds";
    }


    /**
     * Get Seconds From Hours:Minute:Seconds 
     *
     * @param [type] $str_time "23:12:95"
     * @return integer
     */
    public static function human2seconds($str_time)
    {
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

        return $hours * 3600 + $minutes * 60 + $seconds;
    }
    public static function bc_tracking_feedback_bc_sakhi_option() {
        $arr = [
            1 => '1.1 घर परिवार पर ज़िम्मेदारी का बोझ है _ जैसे छोटे बच्चे का होना, बड़ा परिवार का होना, खेतीबाड़ी तथा अन्य पारिवारिक व्यवसाय में व्यस्तता',
            2 => '1.2 घर से निकलने में दिक़्क़त – जितने कस्टमर घर पर आ जाते हैं, उनके साथ ही बैंकिंग ट्रांजेक्शन संभव हो पाता है; बाहर निकल कर बीसी का कार्य कर नहीं पाते हैं;',
            3 => '1.3 घर से अपेक्षित सहयोग ना मिल पाना – यहाँ तक कि बैंकिंग कार्य करने के लिए स्वयं का स्मार्ट फ़ोन भी उपलब्ध ना होना'
        ];
        return $arr;
    }
    public static function bc_tracking_feedback_partner_bank_option() {
        $arr = [
            4 => '1.4 स्वयं सहायता समूह से लोन के 75,000/- रुपये मिलने के बाद भी महीनों मशीन ना मिल पाना तथा बीसी के तौर पर कार्य शुरू ना कर पाना। इस से हमारे ऋण वापसी तथा उनपर बढ़ती ब्याज का दवाब बढ़ता जाता है;',
            5 => '1.5 मशीन चलाना नहीं आता है; लंबे समय तक मशीन ख़राब पड़ा रहता है – सुनवाई नहीं होती है; कोई स्थाई व्यवस्था नहीं है कि मशीनें स्वाभाविक रूप से फंक्शनल रहें;',
            6 => '1.6 पार्टनर बैंकों से ऑपरेशनल जुड़ाव, उनसे अपेक्षित मदद का अभाव; उनका हमारे काम पर रुचि ना होना;',
            7 => '1.7 ट्रांजैक्शंस किए जाने पर कमीशन का दर बहुत ही कम होना। अलग अलग बैंकों का कमीशन के दरों में काफ़ी असमानता भी है;'
            
        ];
        return $arr;
    }
    public static function bc_tracking_feedback_bank_option() {
        $arr = [
            8 => '1.8 बैंकों का उदासीन व्यवहार – वे हमसे आम कस्टमर की तरह पेश आतें है, लाइन लगाना पड़ता है – ब्रांच में ही काफ़ी समय _ कभी कभी पूरा दिन का समय लग जाता है;',
            9 => '1.9 बैंक द्वारा प्रयोज्य भारी कस्टमर चार्ज जो की कभी कभी हमारे प्राप्त कमीशन आय से भी ज़्यादा होता है;',
            10 => '1.10 गाँव के नज़दीक में ही बैंक/ जन सुविधा केंद्र का ब्रांच है इसलिए लोग वहीं से बैंकिंग करना सही समझते हैं;',
            11 => '1.11 कुछ बैंकों द्वारा अन्य बैंकों के साथ ट्रांजेक्शन करना अलाउ ना करना (Offus) _ उदाहरण बैंक ऑफ़ बड़ौदा, सेंट्रल तथा canara बैंक इत्यादि;'
        ];
        return $arr;
    }
    public static function bc_tracking_feedback_awareness_gap_option() {
        $arr = [
            12 => '1.12 ग्रामीण कस्टमर्स में हमारे बारे में जागरूकता की कमी। उन्हें बीसी सखियों के माध्यम से बैंकिंग ट्रांजेक्शन करने पर जागरूकता नहीं की गई है।',
            13 => '1.13 ग्राम प्रधान भी हमारे पक्ष में आम लॉग में जागरूकता नहीं बढ़ाते हैं; पंचायत सचिवालय में बैठने तक नहीं देते;',
            14 => '1.14 बीसी सखी के कार्य-स्थल पर इंटरनेट नेटवर्क की कमी – ट्रांजेक्शन में अक्सर दिक़्क़त आना;',
            15 => '1.15 मनी-लाउंड्रिंग, फ्रॉड ट्रांजेक्शन व कमाई पर लगनेवाले टैक्स का डर; इस बारे में हमें कोई ख़ास जानकारी भी नहीं दे जाती है; '
        ];
        return $arr;
    }
    public static function bc_tracking_feedback_operational_issues_option() {
        $arr = [
            16 => '1.16 वर्किंग/ वित्तीय पूँजी की कमी; बैंकिंग का कार्य करने के लिए हाथ में काफ़ी कैश रक़म की ज़रूरत पड़ती है; जिसका अभाव है;',
            17 => '1.17 हमें हमारे संभावित कस्टमर के बारे कोई जानकारी नहीं है; कौन हमारा कस्टमर हो सकते है या कौन नहीं; इसके बारे में स्पष्ट समझ नहीं है;',
            18 => '1.18 कॉल सेंटर पर शिकायत करने पर भी कोई निवारण नहीं होता; ब्लॉक या मिशन मैनेजर/ बीएमएम के पास भी कोई सुनवाई नहीं होती;',
            19 => '1.19 छ माह के लिए प्रस्तावित मानदेय रेगुलर नहीं है। कभी कभी एक एक साल तक मानदेय नहीं मिल पाता है – इस से कार्य की शुरुआती समय में काफ़ी दिक़्क़त होती है; ',
            20 => '1.20 अक्सर कई लोगों द्वारा भ्रष्टाचार/ कमीशन के लिए दवाब बनाना।; '
        ];
        return $arr;
    }
    public static function ultra_poor_department_column() {
        $dep_data = [
            'personal_features_accommodation' => true,
            'personal_features_toilet' => true,
            'personal_features_structure_building_under_narega' => true,
            'personal_features_connection_of_tap_water' => true,
            'other_features_ration' => true,
            'other_features_economic_benefits_of_schooling' => true,
            'other_features_kisan_samman' => true,
            'other_features_benefits_provided_labor_department' => true,
            'other_features_labor_worker_work_in_narega' => true,
            'other_features_benefits_associated_upsrlm' => true,
            'other_features_benefits_of_social_welfare_department' => true,
            'other_features_benefits_of_social_welfare_department' => true,
            'other_features_benefits_of_women_welfare_department' => true,
            'other_features_benefits_of_health_department' => true
        ];
        return $dep_data;
    }
    
    
}

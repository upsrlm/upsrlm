<?php

namespace app\modules\shg\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use app\models\UserModel;
use app\models\master\MasterRole;
use app\models\master\MasterArea;
use app\models\master\MasterDivisionSearch;
use app\models\master\MasterDistrictSearch;
use app\models\master\MasterBlockSearch;
use app\models\master\MasterGramPanchayatSearch;
use app\models\master\MasterVillageSearch;
use app\models\master\MasterTownSearch;
use app\models\master\MasterTown;
use app\models\master\MasterUlbSearch;
use app\models\master\MasterWardSearch;
use app\models\RelationUserGramPanchayatSearch;
use app\models\RelationUserUlbSearch;
use app\models\RelationUserDistrictSearch;
use app\models\RelationUserBdoBlockSearch;
use app\models\nfsa\NfsaMasterHhsStatus;
use app\models\nfsa\NfsaBaseSurvey;

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
    const MAX_ROW_DOWNLOAD_CSV = 6000;

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
            $searchModel = new \app\models\RelationUserGramPanchayatSearch();
            $searchModel->role = [\app\models\master\MasterRole::ROLE_GP_SAACHIV, \app\models\master\MasterRole::ROLE_GP_ADHIKARI];
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
        return isset($model) ? ArrayHelper::map($model, 'user_id', function($model) {
                    return $model->user->name . ' (' . implode(', ', ArrayHelper::getColumn($model->user->grampanchayat, 'gp.gram_panchayat_name')) . ')';
                }) : [];
        return isset($model) ? ArrayHelper::map($model, 'user_id', 'user.name') : [];
    }

    public static function nfsaprimaryruraloption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \app\models\RelationUserGramPanchayatSearch();
            $searchModel->role = [\app\models\master\MasterRole::ROLE_GP_SAACHIV, \app\models\master\MasterRole::ROLE_GP_ADHIKARI];
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
            $searchModel->role = [\app\models\master\MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR];
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
            $searchModel->role = [\app\models\master\MasterRole::ROLE_GP_SAACHIV, \app\models\master\MasterRole::ROLE_GP_ADHIKARI];
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
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'district_code', 'district_name') : [];
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
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'block_code', 'block_name') : [];
    }

    public static function nfsaoptionblockdistrict($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \app\models\master\MasterBlockSearch();
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->district_code)) {
                $searchModel->district_code = $md->district_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'block_code', function($model) {
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
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
//         echo "<pre/>";   print_r($model);
//            exit;
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
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'village_code', 'village_name') : [];
    }

    public static function nfsaoptionruralprimaryuser($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \app\models\RelationUserGramPanchayatSearch();
            $searchModel->status = \app\models\base\GenralModel::STATUS_ACTIVE;
            $searchModel->role = [\app\models\master\MasterRole::ROLE_GP_SAACHIV, \app\models\master\MasterRole::ROLE_GP_ADHIKARI];
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
            $searchModel = new \app\models\RelationUserUlbSearch();
            $searchModel->status = \app\models\base\GenralModel::STATUS_ACTIVE;
            $searchModel->user_status = \app\models\base\GenralModel::STATUS_ACTIVE;
            $searchModel->role = [\app\models\master\MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR];
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
            $searchModel = new \app\models\master\MasterTownSearch();
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
            $searchModel = new \app\models\master\MasterBlockSearch();
            if (isset($md->district_code)) {
                $searchModel->district_code = $md->district_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'block_code', function($model) {
                    return $model->block_name . ' (' . $model->district->district_name . ')';
                }) : [];
    }

    public static function optiondistrict($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterVillageSearch();
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
            $dataProvider = $searchModel->search($md, Yii::$app->user->identity, false, static::$coll_gram_panchayat);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'gram_panchayat_id', 'gram_panchayat_name') : [];
    }

    public static function optionvillage($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterVillageSearch();
            $dataProvider = $searchModel->search($md, Yii::$app->user->identity, false, static::$coll_village);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'village_code', 'village_name') : [];
    }

    public static function srlmcostoption($md = null) {
        $model = \app\models\srlm\master\SrlmMasterCast::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function srlmagegrouptoption($md = null) {
        $model = [1 => '18-25 Years', 2 => '26-32 Years', 3 => '33-40 Years', 4 => '41-50 Years', 5 => 'Above 50'];
        return isset($model) ? $model : [];
    }

    public static function srlmreadingskillsoption($md = null) {
        $model = \app\models\srlm\master\SrlmMasterReadingSkills::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function srlmphonetypeoption($md = null) {
        $model = \app\models\srlm\master\SrlmMasterPhoneType::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function srlmmaritalstatusoption($md = null) {
        $model = [1 => 'Married', 2 => 'Unmarried'];
        return isset($model) ? $model : [];
    }

    public static function srlmalreadygroupmemberoption($md = null) {
        $model = \app\models\srlm\master\SrlmMasterAlreadyGroupMember::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

}

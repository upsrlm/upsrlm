<?php

namespace bc\modules\selection\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use common\models\User;
use common\models\master\MasterRole;
use common\models\master\MasterArea;
use bc\models\master\MasterDivisionSearch;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\models\master\MasterGramPanchayatSearch;
use bc\models\master\MasterVillageSearch;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\training\models\RsetisCenterSearch;
use common\models\master\MasterTownSearch;
use common\models\master\MasterTown;
use common\models\master\MasterUlbSearch;
use common\models\master\MasterWardSearch;
use common\models\RelationUserGramPanchayatSearch;
use common\models\RelationUserUlbSearch;
use common\models\RelationUserDistrictSearch;
use common\models\RelationUserBdoBlockSearch;

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

    public static function state_options($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \common\models\master\MasterStateSearch();

            $dataProvider = $searchModel->search($searchModel, null, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'state_code', 'state_name') : [];
    }

    public static function divisionoption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterDivisionSearch();
            $dataProvider = $searchModel->search([], Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'division_code', 'division_name') : [];
    }

    public static function districtoption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterDistrictSearch();
            if (isset($md->state_code) and $md->state_code) {
                $searchModel->state_code = $md->state_code;
            }
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->master_partner_bank_id) and $md->master_partner_bank_id) {
                $searchModel->master_partner_bank_id = $md->master_partner_bank_id;
            }
            if (isset($md->aspirational) and $md->aspirational != '') {
                $searchModel->aspirational = $md->aspirational;
            }
            if (isset($md->igrs) and $md->igrs != '') {
                $searchModel->igrs = $md->igrs;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, GenralModel::select_district_drop_columns(), true);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'district_code', function ($model) {
                    return $model['district_name'];
                }) : [];
    }

    public static function trackinbcdistrictoption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterDistrictSearch();
            $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
            if (isset($md->state_code) and $md->state_code) {
                $searchModel->state_code = $md->state_code;
            }
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->master_partner_bank_id) and $md->master_partner_bank_id) {
                $searchModel->master_partner_bank_id = $md->master_partner_bank_id;
            }
            if (isset($md->aspirational) and $md->aspirational != '') {
                $searchModel->aspirational = $md->aspirational;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, GenralModel::select_district_drop_columns(), true);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'district_code', function ($model) {
                    return $model['district_name'];
                }) : [];
    }

    public static function centeroption($md = null) {
        if (isset(Yii::$app->user->identity->id)) {
            $searchModel = new RsetisCenterSearch();
            if (isset($md->state_code) and $md->state_code) {
                $searchModel->state_code = $md->state_code;
            }
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, false, true);
            $model = $dataProvider->getModels();
        }

        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return $model['name'];
                }) : [];
    }

    // public static function bcselectionuser($md = null) {
    //     if (isset(Yii::$app->user->identity)) {
    //         $searchModel = new SrlmBcApplicationSearch();
    //         if (isset($md->state_code) and $md->state_code) {
    //             $searchModel->state_code = $md->state_code;
    //         }
    //         if (isset($md->district_code) and $md->district_code) {
    //             $searchModel->district_code = $md->district_code;
    //         }
    //         if (isset($md->block_code) and $md->block_code) {
    //             $searchModel->block_code = $md->block_code;
    //         }
    //         $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, false, true);
    //         $model = $dataProvider->getModels();
    //     }
    //     return isset($model) ? ArrayHelper::map($model, 'id', function($model) {
    //                 return $model['first_name'];
    //             }) : [];
    // }

    public static function blockoption($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new MasterBlockSearch();
            if (isset($md->state_code) and $md->state_code) {
                $searchModel->state_code = $md->state_code;
            }
            if (isset($md->division_code) and $md->division_code) {
                $searchModel->division_code = $md->division_code;
            }
            if (isset($md->district_code) and $md->district_code) {
                $searchModel->district_code = $md->district_code;
            }
            if (isset($md->nretp) and $md->nretp != '') {
                $searchModel->nretp = $md->nretp;
            }
            if (isset($md->aspirational) and $md->aspirational != '') {
                $searchModel->aspirational = $md->aspirational;
            }
            if (isset($md->igrs) and $md->igrs != '') {
                $searchModel->igrs = $md->igrs;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, GenralModel::select_block_drop_columns(), true);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'block_code', function ($model) {
                    return $model['block_name'] . ' (' . $model['district_name'] . ')';
                }) : [];
    }

    public static function gpoption($md = null) {
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
            if (isset($md->master_partner_bank_id) and $md->master_partner_bank_id) {
                $searchModel->master_partner_bank_id = $md->master_partner_bank_id;
            }
            if (isset($md->second_vacant) and $md->second_vacant) {
                $searchModel->second_vacant = $md->second_vacant;
            }
            if (isset($md->aspirational) and $md->aspirational != '') {
                $searchModel->aspirational = $md->aspirational;
            }
            if (isset($md->igrs) and $md->igrs != '') {
                $searchModel->igrs = $md->igrs;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, false, GenralModel::select_gp_drop_columns(), true);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'gram_panchayat_code', function ($model) {
                    return $model['gram_panchayat_name'] . ' (' . $model['block_name'] . ')';
                }) : [];
    }

    public static function villageoption($md = null) {
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
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false, null, GenralModel::select_village_drop_columns(), true);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'village_code', function ($model) {
                    return $model['village_name'] . ' (' . $model['block_name'] . ')';
                }) : [];
    }

    public static function bccostoption($md = null) {
        $model = \bc\modules\selection\models\master\BcApplicationMasterCast::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function bcagegrouptoption($md = null) {
        $model = [1 => '18-25 Years', 2 => '26-32 Years', 3 => '33-40 Years', 4 => '41-50 Years', 5 => 'Above 50'];
        return isset($model) ? $model : [];
    }

    public static function agegrouptoption($md = null) {
        $model = [0 => 'Less than 18', 1 => '18-25 Years', 2 => '26-32 Years', 3 => '33-40 Years', 4 => '41-50 Years', 5 => 'Above 50'];
        return isset($model) ? $model : [];
    }

    public static function bcreadingskillsoption($md = null) {
        $model = \bc\modules\selection\models\master\BcApplicationMasterReadingSkills::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function bcphonetypeoption($md = null) {
        $model = \bc\modules\selection\models\master\BcApplicationMasterPhoneType::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function bcmaritalstatusoption($md = null) {
        $model = [1 => 'Married', 2 => 'Unmarried'];
        return isset($model) ? $model : [];
    }

    public static function bcalreadygroupmemberoption($md = null) {
        $model = \bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->where(['status' => 1])->all();
        return isset($model) ? ArrayHelper::map($model, 'id', 'name_eng') : [];
    }

    public static function center_option($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \bc\modules\training\models\RsetisCenterSearch();
            if (isset($md->district_code)) {
                $searchModel->district_code = $md->district_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return $model['name'];
                }) : [];
    }

    public static function training_option($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $searchModel = new \bc\modules\training\models\RsetisCenterTrainingSearch();
            if (isset($md->district_code)) {
                $searchModel->district_code = $md->district_code;
            }
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
            $model = $dataProvider->getModels();
        }
        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return date("d-m-Y", strtotime($model->training_start_date)) . " to " . date("d-m-Y", strtotime($model->training_start_date));
                }) : [];
    }

    public static function partner_bank_option($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $query = \bc\models\master\MasterPartnerBank::find();
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => Yii::$app->user->identity->id]);
                $query->andWhere([\bc\models\master\MasterPartnerBank::getTableSchema()->fullName . '.id' => Yii::$app->user->identity->master_partner_bank_id]);
            }
            $model = $query->all();
        }
        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return $model->id == 6 ? $model['bank_name'] . " to SBI (Switched Feb. 15’ 24)" : $model['bank_name'];
                }) : [];
    }
    public static function partner_bank_option_current($md = null) {
        if (isset(Yii::$app->user->identity)) {
            $query = \bc\models\master\MasterPartnerBank::find();
            $query->andWhere(['!=','id',6]);
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => Yii::$app->user->identity->id]);
                $query->andWhere([\bc\models\master\MasterPartnerBank::getTableSchema()->fullName . '.id' => Yii::$app->user->identity->master_partner_bank_id]);
            }
            $model = $query->all();
        }
        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return $model->id == 6 ? $model['bank_name'] . " to SBI (Switched Feb. 15’ 24)" : $model['bank_name'];
                }) : [];
    }
    public static function unwilling_reason_rsethis_option($md = null) {
        $array = [
            1 => 'हमें इस कार्यक्रम के बारे में पूर्ण सूचना नहीं थी – हम ये काम नहीं कर पायेंगे',
            2 => 'हमें कम्प्यूटर नहीं आता है – ये काम नहीं कर पाएँगे',
            3 => 'अंतरिम दिक़्क़त_ बाहर चले गए हैं, प्रेगनांट  हैं, घर में छोटे बच्चे सम्भालना है',
            4 => 'माइग्रेट कर गए हैं । अब ग्राम पंचायत में नहीं रहते हैं ',
            5 => 'मुझे वैकल्पिक कार्य मिल गया है – व्यस्त हो गयी हूँ ।',
            6 => 'परिवार से मना किया जा रहा है '
        ];
        return $array;
    }

    public static function unwilling_reason_bank_option_new($md = null) {
        $array = [
            13 => 'बीसी सखी का विवाह हो जाने या किसी अन्य बाध्यकारी कारणों से दूसरे ग्राम पंचायत/शहर/ स्थान पर चली गई है;',
            14 => 'परिवार के ओर से आपत्ति की जा रही है / घर-परिवार की ज़िम्मेदारी',
            15 => 'कार्य करने में रुचि नहीं है; नियमित रूप से कार्य नहीं करती हैं। प्रदर्शन नहीं कर पा रही है',
            16 => 'सर्टिफ़िकेशन के पश्चात, बीसी सपोर्ट फण्ड मिलने में देरी / मिशन द्वारा किए गए प्रावधान के अनुसार मानदेय नहीं मिल पा रहा है।',
            17 => 'बीसी सपोर्ट फण्ड प्राप्त होने के पश्चात हैंडल्ड डिवाइस मिलने में देरी',
            18 => 'PVR मिलने में देरी',
            19 => 'पार्टनर बैंक का असहयोग - वे कमीशन आय के तरफ़ ध्यान नहीं देते',
            20 => 'बीसी सखी की मृत्यु हो गई है (ग़लत सूचना दिये जाने की स्थिति में उचित धाराओं में क़ानूनी कार्यवाही प्रस्तावित हैं)',
            21 => 'ग्राम पंचायत नगर पालिका / नगर निगम में स्थानान्तरित हो गयी हो ।',
        ];
        return $array;
    }
     public static function unwilling_reason_bc_option_new($md = null) {
        $array = [
            13 => 'बीसी सखी का विवाह हो जाने या किसी अन्य बाध्यकारी कारणों से दूसरे ग्राम पंचायत/शहर/ स्थान पर चली गई है;',
            14 => 'परिवार के ओर से आपत्ति की जा रही है / घर-परिवार की ज़िम्मेदारी',
            15 => 'कार्य करने में रुचि नहीं है; नियमित रूप से कार्य नहीं करती हैं। प्रदर्शन नहीं कर पा रही है',
            16 => 'सर्टिफ़िकेशन के पश्चात, बीसी सपोर्ट फण्ड मिलने में देरी / मिशन द्वारा किए गए प्रावधान के अनुसार मानदेय नहीं मिल पा रहा है।',
            17 => 'बीसी सपोर्ट फण्ड प्राप्त होने के पश्चात हैंडल्ड डिवाइस मिलने में देरी',
            18 => 'PVR मिलने में देरी',
            19 => 'पार्टनर बैंक का असहयोग - वे कमीशन आय के तरफ़ ध्यान नहीं देते',
            20 => 'बीसी सखी की मृत्यु हो गई है (ग़लत सूचना दिये जाने की स्थिति में उचित धाराओं में क़ानूनी कार्यवाही प्रस्तावित हैं)',
            21 => 'ग्राम पंचायत नगर पालिका / नगर निगम में स्थानान्तरित हो गयी हो ।',
        ];
        return $array;
    }
     public static function unwilling_reason_cdo_option_new($md = null) {
        $array = [
            13 => 'बीसी सखी का विवाह हो जाने या किसी अन्य बाध्यकारी कारणों से दूसरे ग्राम पंचायत/शहर/ स्थान पर चली गई है;',
            14 => 'परिवार के ओर से आपत्ति की जा रही है / घर-परिवार की ज़िम्मेदारी',
            15 => 'कार्य करने में रुचि नहीं है; नियमित रूप से कार्य नहीं करती हैं। प्रदर्शन नहीं कर पा रही है',
            16 => 'सर्टिफ़िकेशन के पश्चात, बीसी सपोर्ट फण्ड मिलने में देरी / मिशन द्वारा किए गए प्रावधान के अनुसार मानदेय नहीं मिल पा रहा है।',
            17 => 'बीसी सपोर्ट फण्ड प्राप्त होने के पश्चात हैंडल्ड डिवाइस मिलने में देरी',
            18 => 'PVR मिलने में देरी',
            19 => 'पार्टनर बैंक का असहयोग - वे कमीशन आय के तरफ़ ध्यान नहीं देते',
            20 => 'बीसी सखी की मृत्यु हो गई है (ग़लत सूचना दिये जाने की स्थिति में उचित धाराओं में क़ानूनी कार्यवाही प्रस्तावित हैं)',
            21 => 'ग्राम पंचायत नगर पालिका / नगर निगम में स्थानान्तरित हो गयी हो ।',
        ];
        return $array;
    }
    public static function unwilling_reason_upsrlm_option_new($md = null) {
        $array = [
            13 => 'बीसी सखी का विवाह हो जाने या किसी अन्य बाध्यकारी कारणों से दूसरे ग्राम पंचायत/शहर/ स्थान पर चली गई है;',
            14 => 'परिवार के ओर से आपत्ति की जा रही है / घर-परिवार की ज़िम्मेदारी',
            15 => 'कार्य करने में रुचि नहीं है; नियमित रूप से कार्य नहीं करती हैं। प्रदर्शन नहीं कर पा रही है',
            16 => 'सर्टिफ़िकेशन के पश्चात, बीसी सपोर्ट फण्ड मिलने में देरी / मिशन द्वारा किए गए प्रावधान के अनुसार मानदेय नहीं मिल पा रहा है।',
            17 => 'बीसी सपोर्ट फण्ड प्राप्त होने के पश्चात हैंडल्ड डिवाइस मिलने में देरी',
            18 => 'PVR मिलने में देरी',
            19 => 'पार्टनर बैंक का असहयोग - वे कमीशन आय के तरफ़ ध्यान नहीं देते',
            20 => 'बीसी सखी की मृत्यु हो गई है (ग़लत सूचना दिये जाने की स्थिति में उचित धाराओं में क़ानूनी कार्यवाही प्रस्तावित हैं)',
            21 => 'ग्राम पंचायत नगर पालिका / नगर निगम में स्थानान्तरित हो गयी हो ।',
        ];
        return $array;
    }
    public static function unwilling_reason_bank_option($md = null) {
        $array = [
            7 => 'क. बी०सी० सखी की मृत्यु हो जाना ।',
            8 => 'ख. किसी अन्य प्रदेश / जनपद / ग्राम पंचायत में बीसी सखी का विवाह हो जाना ।',
            9 => 'ग. किन्हीं कारणों से लम्बे समय तक के लिए ग्राम पंचायत से बीसी सखी बाहर चली गयी हो ( उस स्थिति में ग्राम सचिव द्वारा प्रमाण पत्र प्राप्त कर खण्ड विकास अधिकारी के माध्यम से उपायुक्त स्वतः रोजगार के माध्यम से उपलब्ध कराया जायेगा) ।',
            10 => 'घ. बीसी सखी द्वारा शैक्षणिक योग्यता का किसी तकनीकी कारणों से त्रुटि पाये जाने के कारण ।',
            11 => 'ड. लिखित रूप से कार्य न किये जाने की सूचना प्रदान करना ।',
            12 => 'च. ग्राम पंचायत नगर पालिका / नगर निगम में स्थानान्तरित हो गयी हो ।'
        ];
        return $array;
    }

    public static function unwilling_reason_call_center_option($md = null) {
        $array = [
            1 => 'हमें कार्यक्रम की पूर्ण सूचना नहीं थी – अब सब कुछ समझने के बाद ऐसा लगता है कि  हम ये काम नहीं कर पायेंगे ',
            2 => 'हमें कम्प्यूटर नहीं आता है – ये काम नहीं कर पाएँगे',
            3 => 'अंतरिम दिक़्क़त_ बाहर चले गए हैं, प्रेगनांट  हैं, घर में छोटे बच्चे सम्भालना है',
            4 => 'माइग्रेट कर गए हैं । अब ग्राम पंचायत में नहीं रहते हैं',
            5 => 'मुझे वैकल्पिक कार्य मिल गया है – व्यस्त हो गयी हूँ ।',
            6 => 'परिवार से मना किया जा रहा है'
        ];
        return $array;
    }

    public static function unwilling_reason_call_unreachable_option($md = null) {
        $array = [
            7 => 'प्रीसिलेक्टेड BC को 20 बार से ज़्यादा/ पिछले 3 महीने से ज़्यादा समय से कॉल करने पर भी उन का फ़ोन नहीं लगता है',
            8 => '20 बार/ तीन महीने से ज़्यादा बार कॉल करने पर भी उनका फ़ोन कोई और व्यक्ति द्वारा उठाया जाता है, कहने के बाद भी अंतत BC से बात नहीं हो पाती है',
        ];
        return $array;
    }

    public static function ineligible_reason_rsethis_option($md = null) {
        $array = [
            1 => 'क्लास 10 पास नहीं हैं,',
            2 => 'उम्र 18 वर्ष से कम या 50 वर्ष से ज़्यादा है ',
            3 => 'आधार के हिसाब से अभ्यर्थी आवेदित ग्राम पंचायत की रहनेवाली नहीं हैं',
            4 => 'नाम व आधार में भिन्नता',
        ];
        return $array;
    }

    public static function form_data_validation_option($md = null) {
        $array = [
            1 => 'Application Validate',
            21 => 'Application Image Missing',
            22 => 'Application Form data Missing',
            23 => 'Application Image and Form data Missing',
        ];
        return $array;
    }

    public static function bctweekoption($md = null) {
        $date = date('Y-m-d');
        $nbDay = date('N', strtotime($date));
        $monday = new \DateTime($date);
        $sunday = new \DateTime($date);
        $monday->modify('-' . ($nbDay - 1) . ' days');
        $sunday->modify('+' . (7 - $nbDay) . ' days');
        $week_start_date = $monday->format('Y-m-d');
        $week_end_date = $sunday->format('Y-m-d');
        $model = \bc\models\transaction\BcTransactionMasterWeek::find()->where(['status' => 1])->andFilterWhere(['<=', 'week_end_date', $week_end_date])->orderBy('week_end_date desc')->all();
        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return date("d M Y", strtotime($model->week_start_date)) . ' to ' . date("d M Y", strtotime($model->week_end_date));
                }) : [];
//        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
//                    return 'Week '.$model->week_no. ' ('.date("d M Y", strtotime($model->week_start_date)).' to '.date("d M Y", strtotime($model->week_end_date)).')';
//                }) : [];
    }

    public static function current_week_id() {
        $date = date('Y-m-d');
        $nbDay = date('N', strtotime($date));
        $monday = new \DateTime($date);
        $sunday = new \DateTime($date);
        $monday->modify('-' . ($nbDay - 1) . ' days');
        $sunday->modify('+' . (7 - $nbDay) . ' days');
        $week_start_date = $monday->format('Y-m-d');
        $week_end_date = $sunday->format('Y-m-d');
        $model = \bc\models\transaction\BcTransactionMasterWeek::find()->andFilterWhere(['=', 'week_end_date', $week_end_date])->limit(1)->one();
        return isset($model) ? $model->id : null;
    }

    public static function bctmonthoption() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $model = \bc\models\transaction\BcTransactionMasterMonth::find()->where(['status' => 1])->andFilterWhere(['<=', 'month_end_date', $last_day_month])->orderBy('month_end_date desc')->all();
        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->month_end_date, "php:M-Y");
                }) : [];
    }

    public static function current_month_id() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $model = \bc\models\transaction\BcTransactionMasterMonth::find()->where(['status' => 1])->andFilterWhere(['=', 'month_end_date', $last_day_month])->limit(1)->one();
        return isset($model) ? $model->id : null;
    }

    public static function select_rishta_bc_column() {
        $columns = [
            'srlm_bc_application.id',
            'srlm_bc_application.first_name',
            'srlm_bc_application.middle_name',
            'srlm_bc_application.sur_name',
            'srlm_bc_application.age',
            'srlm_bc_application.guardian_name',
            'srlm_bc_application.mobile_number',
            'srlm_bc_application.district_code',
            'srlm_bc_application.block_code',
            'srlm_bc_application.gram_panchayat_code',
            'srlm_bc_application.village_code',
            'srlm_bc_application.mobile_no',
            'srlm_bc_application.srlm_bc_selection_user_id',
            'srlm_bc_application.training_status',
            'srlm_bc_application.selection_by',
            'srlm_bc_application.rishta_access_page_count',
            'srlm_bc_application.rishta_app_last_access_time',
            'srlm_bc_application.no_of_transaction',
            'srlm_bc_application.urban_shg',
            'srlm_bc_application.blocked',
            'srlm_bc_application.status'
        ];
        return $columns;
    }

    public static function select_preselected_bc_column() {
        $columns = [
            'srlm_bc_application.id',
            'srlm_bc_application.first_name',
            'srlm_bc_application.middle_name',
            'srlm_bc_application.sur_name',
            'srlm_bc_application.age',
            'srlm_bc_application.reading_skills',
            'srlm_bc_application.guardian_name',
            'srlm_bc_application.mobile_number',
            'srlm_bc_application.district_code',
            'srlm_bc_application.block_code',
            'srlm_bc_application.gram_panchayat_code',
            'srlm_bc_application.village_code',
            'srlm_bc_application.district_name',
            'srlm_bc_application.block_name',
            'srlm_bc_application.gram_panchayat_name',
            'srlm_bc_application.village_name',
            'srlm_bc_application.hamlet',
            'srlm_bc_application.mobile_no',
            'srlm_bc_application.srlm_bc_selection_user_id',
            'srlm_bc_application.call1',
            'srlm_bc_application.training_status',
            'srlm_bc_application.selection_by',
            'srlm_bc_application.profile_photo',
            'srlm_bc_application.aadhar_front_photo',
            'srlm_bc_application.aadhar_back_photo',
            'srlm_bc_application.bc_unwilling_rsetis',
            'srlm_bc_application.bc_unwilling_call_center',
            'srlm_bc_application.urban_shg',
            'srlm_bc_application.blocked',
            'srlm_bc_application.status',
            'srlm_bc_application.bc_bank',
            'srlm_bc_application.shg_bank',
            'srlm_bc_application.bc_photo_status'
        ];
        return $columns;
    }

    public static function select_urbun_bc_column() {
        $columns = [
            'srlm_bc_application.id',
            'srlm_bc_application.first_name',
            'srlm_bc_application.middle_name',
            'srlm_bc_application.sur_name',
            'srlm_bc_application.age',
            'srlm_bc_application.reading_skills',
            'srlm_bc_application.guardian_name',
            'srlm_bc_application.mobile_number',
            'srlm_bc_application.district_code',
            'srlm_bc_application.block_code',
            'srlm_bc_application.gram_panchayat_code',
            'srlm_bc_application.village_code',
            'srlm_bc_application.district_name',
            'srlm_bc_application.block_name',
            'srlm_bc_application.gram_panchayat_name',
            'srlm_bc_application.village_name',
            'srlm_bc_application.hamlet',
            'srlm_bc_application.mobile_no',
            'srlm_bc_application.srlm_bc_selection_user_id',
            'srlm_bc_application.call1',
            'srlm_bc_application.training_status',
            'srlm_bc_application.selection_by',
            'srlm_bc_application.profile_photo',
            'srlm_bc_application.aadhar_front_photo',
            'srlm_bc_application.aadhar_back_photo',
            'srlm_bc_application.bc_unwilling_rsetis',
            'srlm_bc_application.bc_unwilling_call_center',
            'srlm_bc_application.urban_shg',
            'srlm_bc_application.blocked',
            'srlm_bc_application.status',
            'srlm_bc_application.bc_bank',
            'srlm_bc_application.shg_bank',
            'srlm_bc_application.bank_account_no_of_the_bc',
            'srlm_bc_application.bank_account_no_of_the_shg',
            'srlm_bc_application.cbo_shg_id',
            'srlm_bc_application.onboarding',
            'srlm_bc_application.pfms_maped_status',
            'srlm_bc_application.bc_shg_funds_status',
            'srlm_bc_application.bc_shg_funds_refund_status',
            'srlm_bc_application.bc_support_funds_received',
            'srlm_bc_application.pan_card_status',
            'srlm_bc_application.handheld_machine_status',
            'srlm_bc_application.bc_handheld_machine_recived',
            'srlm_bc_application.no_of_transaction',
            'srlm_bc_application.master_partner_bank_id',
            'srlm_bc_application.bc_unwilling_bank',
            'srlm_bc_application.bc_unwilling_bank_call_center',
            'srlm_bc_application.pvr_status',
            'srlm_bc_application.bc_payment_count'
        ];
        return $columns;
    }

    public static function select_certified_bc_column() {
        $columns = [
            'srlm_bc_application.bc_bank',
            'srlm_bc_application.shg_bank',
            'srlm_bc_application.bank_account_no_of_the_bc',
            'srlm_bc_application.bank_account_no_of_the_shg',
            'srlm_bc_application.cbo_shg_id',
            'srlm_bc_application.onboarding',
            'srlm_bc_application.pfms_maped_status',
            'srlm_bc_application.bc_shg_funds_status',
            'srlm_bc_application.bc_shg_funds_refund_status',
            'srlm_bc_application.bc_support_funds_received',
            'srlm_bc_application.pan_card_status',
            'srlm_bc_application.handheld_machine_status',
            'srlm_bc_application.bc_handheld_machine_recived',
            'srlm_bc_application.no_of_transaction',
            'srlm_bc_application.bc_operational',
            'srlm_bc_application.master_partner_bank_id',
            'srlm_bc_application.bc_unwilling_bank',
            'srlm_bc_application.bc_unwilling_bank_call_center',
            'srlm_bc_application.pvr_status',
            'srlm_bc_application.bc_payment_count'
        ];
        return $columns;
    }

    public static function select_selection_dashboard_column() {
        $columns = [
            'srlm_bc_application.id',
            'srlm_bc_application.first_name',
            'srlm_bc_application.middle_name',
            'srlm_bc_application.sur_name',
            'srlm_bc_application.age',
            'srlm_bc_application.gender',
            'srlm_bc_application.cast',
            'srlm_bc_application.guardian_name',
            'srlm_bc_application.mobile_number',
            'srlm_bc_application.district_code',
            'srlm_bc_application.block_code',
            'srlm_bc_application.gram_panchayat_code',
            'srlm_bc_application.village_code',
            'srlm_bc_application.hamlet',
            'srlm_bc_application.mobile_no',
            'srlm_bc_application.srlm_bc_selection_user_id',
            'srlm_bc_application.already_group_member',
            'srlm_bc_application.training_status',
            'srlm_bc_application.selection_by',
            'srlm_bc_application.profile_photo',
            'srlm_bc_application.reg_date_time',
            'srlm_bc_application.form_start_date',
            'srlm_bc_application.form6_date_time',
            'srlm_bc_application.form_number',
            'srlm_bc_application.over_all',
            'srlm_bc_application.urban_shg',
            'srlm_bc_application.blocked',
            'srlm_bc_application.status'
        ];
        return $columns;
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
            'master_gram_panchayat.district_name',
            'master_gram_panchayat.district_code',
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

    public static function bc_bank_option($md = null) {
        $query = \cbo\models\master\CboMasterBank::find()->where(['new_status' => 1]);
        $model = $query->orderBy('display_order asc')->all();

        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return $model['bank_name'];
                }) : [];
    }

    public static function bc_bank_name_option($md = null) {
        $query = \cbo\models\master\CboMasterBank::find()->where(['new_status' => 1]);
        $model = $query->orderBy('display_order asc')->all();

        return isset($model) ? ArrayHelper::map($model, 'bank_name', function ($model) {
                    return $model['bank_name'];
                }) : [];
    }

    public static function shg_bank_option($md = null) {
        $query = \cbo\models\master\CboMasterBank::find();
        $model = $query->orderBy('bank_name asc')->all();

        return isset($model) ? ArrayHelper::map($model, 'id', function ($model) {
                    return $model['bank_name'];
                }) : [];
    }

    public static function rbi_user_bank($user_id) {
        $user_bank = [
            327504 => 'State Bank of India',
            327505 => 'Bank of Baroda',
            327506 => 'Bank of India',
            327507 => 'Bank of Maharashtra',
            327508 => 'Canara Bank',
            327509 => 'Central Bank of India',
            327510 => 'Union Bank of India',
            327511 => 'Punjab National Bank',
            327512 => 'Punjab and Sind Bank',
            327513 => 'UCO Bank',
            327514 => 'Indian Bank',
            327515 => 'Indian Overseas Bank',
            327516 => 'HDFC Bank',
            327517 => 'IDBI Bank',
            327518 => 'ICICI Bank Limited',
            327519 => 'Axis Bank',
            327520 => 'Paytm Payments Bank Limited',
            327521 => 'Airtel Payments Bank Limited',
            327522 => 'FINO Payments Bank',
            327523 => 'Yes Bank Limited',
            327524 => 'Uttar Pradesh Cooperative Bank Limited',
            327525 => 'Aryavart Bank',
            327526 => 'Prathama UP Gramin Bank',
            327527 => 'Baroda UP Bank',
            327528 => 'Purvanchal Bank',
            327529 => 'Kashi Gomti Gramin Bank'
        ];
        return isset($user_bank[$user_id]) ? $user_bank[$user_id] : '';
    }

    public static function rbi_user_id() {
        $user_bank = [
            327504,
            327505,
            327506,
            327507,
            327508,
            327509,
            327510,
            327511,
            327512,
            327513,
            327514,
            327515,
            327516,
            327517,
            327518,
            327519,
            327520,
            327521,
            327522,
            327523,
            327524,
            327525,
            327526,
            327527,
            327528,
            327529
        ];
        return $user_bank;
    }

    public static function bc_tracking_feedback_bc_sakhi_option() {
        $arr = [
            1 => 'घर परिवार की ज़िम्मेदारी है, (जैसे छोटे बच्चे का होना, बड़ा परिवार का होना, खेतीबाड़ी तथा अन्य पारिवारिक व्यवसाय में व्यस्तता इत्यादि)',
            2 => 'घर से निकलने में दिक़्क़त है – जो कस्टमर घर पर आ जाते हैं, उनके साथ ही बैंकिंग ट्रांजेक्शन संभव है; बाहर निकल कर बीसी का कार्य नहीं कर पाते हैं;',
            3 => 'घर से अपेक्षित सहयोग नहीं मिल पाता है – बैंकिंग कार्य करने के लिए स्वयं का स्मार्ट फ़ोन भी उपलब्ध ना होता है;'
        ];
        return $arr;
    }

    public static function bc_tracking_feedback_partner_bank_option() {
        $arr = [
            4 => 'स्वयं सहायता समूह से 75,000/- रुपये का ऋण मिलने के बाद भी महीनों मशीन नहीं मिला, इसलिए बीसी के तौर पर कार्य नहीं शुरू कर पाना । इस से हमारे ऋण वापसी तथा उनपर बढ़ती ब्याज का दवाब बढ़ता जाता है;',
            5 => 'मशीन चलाना नहीं आता है; लंबे समय तक मशीन ख़राब पड़ा रहता है – सुनवाई नहीं होती है; कोई स्थायी व्यवस्था नहीं है कि मशीनें फंक्शनल रहें;',
            6 => 'पार्टनर बैंकों से ऑपरेशनल जुड़ाव नहीं है, उनसे अपेक्षित मदद का अभाव; उनका हमारे काम पर कोई रुचि नहीं है;',
            7 => 'ट्रांजैक्शंस किए जाने पर कमीशन का दर बहुत ही कम है। अलग अलग बैंकों के कमीशन के दरों में काफ़ी असमानता है;'
        ];
        return $arr;
    }

    public static function bc_tracking_feedback_bank_option() {
        $arr = [
            8 => 'सेटलमेंट बैंक का उदासीन व्यवहार – वे हमसे आम कस्टमर की तरह पेश आतें है, लाइन लगाना पड़ता है। ब्रांच में काफ़ी समय लगता है; कभी कभी पूरा दिन का समय लग जाता है;',
            9 => 'बैंक काफ़ी ज़्यादा कस्टमर चार्ज लगाता है जो कभी हमारे बीसी कमीशन के आय से भी ज़्यादा होता है;',
            10 => 'गाँव में ही बैंक या जन सुविधा केंद्र का ब्रांच है; पार्टनर बैंक ने दूसरे एजेंट डिप्लॉय किया हुआ है । इसलिए लोग वहीं से बैंकिंग करना उचित समझते हैं;',
            11 => 'कुछ बैंकों द्वारा अन्य बैंकों के साथ ट्रांजेक्शन करना अलाउ ना करना (Offus) _ उदाहरण बैंक ऑफ़ बड़ौदा, सेंट्रल तथा canara बैंक इत्यादि;'
        ];
        return $arr;
    }

    public static function bc_tracking_feedback_awareness_gap_option() {
        $arr = [
            12 => 'ग्रामीण कस्टमर्स में हमारे बारे में जागरूकता की कमी। उन्हें बीसी सखियों के माध्यम से बैंकिंग ट्रांजेक्शन करने पर जागरूकता नहीं की गई है।',
            13 => 'ग्राम प्रधान भी हमारे पक्ष में आम लॉग में जागरूकता नहीं बढ़ाते हैं; पंचायत सचिवालय में बैठने तक नहीं देते;',
            14 => 'बीसी सखी के कार्य-स्थल पर इंटरनेट नेटवर्क की कमी – ट्रांजेक्शन में अक्सर दिक़्क़त आना;',
            15 => 'मनी-लाउंड्रिंग, फ्रॉड ट्रांजेक्शन व कमाई पर लगनेवाले टैक्स का डर; इस बारे में हमें कोई ख़ास जानकारी भी नहीं दी जाती है; '
        ];
        return $arr;
    }

    public static function bc_tracking_feedback_operational_issues_option() {
        $arr = [
            16 => 'वर्किंग/ वित्तीय पूँजी की कमी; बैंकिंग का कार्य करने के लिए हाथ में काफ़ी कैश रक़म की ज़रूरत पड़ती है; जिसका अभाव है;',
            17 => 'हमें हमारे संभावित कस्टमर के बारे कोई जानकारी नहीं है; कौन हमारा कस्टमर हो सकते है या कौन नहीं; इसके बारे में स्पष्ट समझ नहीं है;',
            18 => 'कॉल सेंटर पर शिकायत करने पर भी कोई निवारण नहीं होता; ब्लॉक या मिशन मैनेजर/ बीएमएम के पास भी कोई सुनवाई नहीं होती;',
            19 => 'मानदेय का भुगतान नियमित नहीं है। कभी कभी एक एक साल तक मानदेय नहीं मिल पाता है – इस से कार्य की शुरुआती समय में काफ़ी दिक़्क़त होती है;',
            20 => 'अक्सर कई लोगों द्वारा भ्रष्टाचार/ कमीशन के लिए दवाब बनाया जाता है। ग्राम प्रधान का सहयोग नहीं मिल पाता है । '
        ];
        return $arr;
    }
}

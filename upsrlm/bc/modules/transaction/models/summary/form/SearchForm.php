<?php

namespace bc\modules\transaction\models\summary\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\User;
use common\models\master\MasterRole;
use bc\modules\selection\models\base\GenralModel;

/**
 * SearchForm for report
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class SearchForm extends Model {

    public $division_code;
    public $district_code;
    public $sub_district_code;
    public $block_code;
    public $village_code;
    public $gram_panchayat_code;
    public $master_partner_bank_id;
    public $change_type = "";
    public $from_date_time;
    public $to_date_time;
    public $month;
    public $month_id;
    public $from_month_id;
    public $to_month_id;
    public $saheli;
    public $wada;
    public $role;
    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $shg_option = [];
    public $village_option = [];
    public $bank_option = [];
    public $role_option = [];
    public $from_month_option = [];
    public $to_month_option = [];

    public function __construct($params) {

        $this->load($params);
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $model = \bc\modules\transaction\models\summary\BcTransactionMasterMonth::find()->where(['status' => 1])->andFilterWhere(['<=', 'month_end_date', $last_day_month])->orderBy('month_end_date desc')->all();
        $this->from_month_option = ArrayHelper::map($model, 'id', function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->month_end_date, "php:M-Y");
                });
        $this->to_month_option = ArrayHelper::map($model, 'id', function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->month_end_date, "php:M-Y");
                });
        $curent_month_model = \bc\modules\transaction\models\summary\BcTransactionMasterMonth::find()->where(['status' => 1])->andFilterWhere(['=', 'month_end_date', $last_day_month])->limit(1)->one();
        $date->modify('last day of -12 month');
        $last_day_12month = $date->format('Y-m-d');
        $before_12_month_model = \bc\modules\transaction\models\summary\BcTransactionMasterMonth::find()->where(['status' => 1])->andFilterWhere(['=', 'month_end_date', $last_day_12month])->limit(1)->one();
//        if ($this->from_month_id == '') {
//            $this->from_month_id = isset($before_12_month_model) ? $before_12_month_model->id : null;
//        }
//        if ($this->to_month_id == '') {
//            $this->to_month_id = isset($curent_month_model) ? $curent_month_model->id : null;
//        }

        if (Yii::$app->request->isConsoleRequest) {
            
        } else {
            $user_model = \Yii::$app->user->identity;
            if ($user_model != null) {
                if (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                    $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                    $this->master_partner_bank_id = $user_model->master_partner_bank_id;
                } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                    $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                    $this->master_partner_bank_id = $user_model->master_partner_bank_id;
                }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                    $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                    $this->master_partner_bank_id = $user_model->master_partner_bank_id;
                }
            }
            $this->bank_option = GenralModel::partner_bank_option();
            $this->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($this);
            if (Yii::$app->request->isAjax) {
                if (isset($params["SearchForm"]["change_type"]))
                    $this->change_type = $params["SearchForm"]["change_type"];
            }
            $this->division_option = GenralModel::divisionoption();
            $this->district_option = GenralModel::districtoption($this);
            if ($this->district_code) {
                $this->block_option = GenralModel::blockoption($this);
            }
            if ($this->block_code) {
                $this->gp_option = GenralModel::gpoption($this);
            }
        }
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['district_code', 'block_code', 'village_code', 'gram_panchayat_code'], 'safe'],
            [['division_code'], 'safe'],
            [['saheli'], 'safe'],
            [['wada'], 'safe'],
            [['from_date_time'], 'safe'],
            [['to_date_time'], 'safe'],
            [['month'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
            [['month_id'], 'safe'],
            [['from_month_id'], 'safe'],
            [['to_month_id'], 'safe'],
            [['role'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'division_code' => 'Division',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'from_date_time' => 'From date',
            'to_date_time' => 'To date',
            'master_partner_bank_id' => 'Partner Agency',
            'month_id' => 'Month',
            'from_month_id' => 'From Month',
            'to_month_id' => 'To month',
            'month' => 'Month'
        ];
    }
}

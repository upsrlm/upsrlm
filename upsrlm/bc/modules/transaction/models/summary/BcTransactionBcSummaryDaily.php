<?php

namespace bc\modules\transaction\models\summary;

use Yii;
use common\models\master\MasterRole;
/**
 * This is the model class for table "bc_transaction_bc_summary_daily".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property string|null $bankidbc
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $master_partner_bank_id
 * @property string|null $date
 * @property string|null $transaction_start_date
 * @property int|null $no_of_transaction
 * @property int $no_of_actual_transaction
 * @property int|null $zero_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 * @property int $is_new
 * @property int $status
 * @property int $change_day
 * @property int $change_transaction
 * @property float $change_transaction_amount
 * @property float $change_commission_amount
 * @property int $change_calculate
 */
class BcTransactionBcSummaryDaily extends SummaryActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_transaction_bc_summary_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'date'], 'required'],
            [['bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'is_new', 'status'], 'integer'],
            [['date', 'transaction_start_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['bankidbc'], 'string', 'max' => 20],
            [['bc_application_id', 'date'], 'unique', 'targetAttribute' => ['bc_application_id', 'date']],
            [['change_day'], 'default', 'value' => 0],
            [['change_transaction'], 'default', 'value' => 0],
            [['change_transaction_amount'], 'default', 'value' => 0],
            [['change_commission_amount'], 'default', 'value' => 0],
            [['change_calculate'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Name',
            'bankidbc' => 'Bankidbc',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'GP',
            'master_partner_bank_id' => 'Partner Agency',
            'date' => 'Date',
            'transaction_start_date' => 'Start Date',
            'no_of_transaction' => 'No Of Transaction',
            'no_of_actual_transaction' => 'No Of Actual Transaction',
            'zero_transaction' => 'Zero Transaction',
            'transaction_amount' => 'Txn Amount',
            'commission_amount' => 'Commission Amount',
            'is_new' => 'Is New',
            'status' => 'Status',
        ];
    }

    public function getBc() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getPbank() {
        return $this->hasOne(MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getTransaction($model, $search) {
        $user_model = Yii::$app->user->identity;
        $query = $this->find()
                ->select(['id'])
                ->andFilterWhere(['=', 'date', $model->date]);
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
        }
        if ($search->master_partner_bank_id) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
        }
        if ($search->district_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if ($search->block_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $search->block_code]);
        }
        if ($search->gram_panchayat_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
        }
        $query->asArray();
        return $query->sum('no_of_transaction');
    }

    public function getNobc($model, $search) {
        $user_model = Yii::$app->user->identity;
        $query = $this->find()
                ->select(['bc_application_id'])
                ->andFilterWhere(['=', 'date', $model->date]);
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
        }
        if ($search->master_partner_bank_id) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
        }
        if ($search->district_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if ($search->block_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $search->block_code]);
        }
        if ($search->gram_panchayat_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
        }
        $query->asArray();
        return $query->distinct()->count();
    }

    public function getTotaltxnamount($model, $search) {
        $user_model = Yii::$app->user->identity;
        $query = $this->find()
                ->select(['transaction_amount'])
                ->andFilterWhere(['=', 'date', $model->date]);
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
        }
        if ($search->master_partner_bank_id) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
        }
        if ($search->district_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if ($search->block_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $search->block_code]);
        }
        if ($search->gram_panchayat_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
        }
        $query->asArray();
        return $query->sum('transaction_amount');
    }

    public function getTotalbccom($model, $search) {
        $user_model = Yii::$app->user->identity;
        $query = $this->find()
                ->select(['commission_amount'])
                ->andFilterWhere(['=', 'date', $model->date]);
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
        }
        if ($search->master_partner_bank_id) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
        }
        if ($search->district_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if ($search->block_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $search->block_code]);
        }
        if ($search->gram_panchayat_code) {
            $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
        }
        $query->asArray();
        return $query->sum('commission_amount');
    }

    public static function getTotal($provider, $columnName, $search) {
        $user_model = Yii::$app->user->identity;
        $total = 0;
        if ($search->month) {
            $from_date_time = $search->month;
            $to_date_time = \DateTime::createFromFormat("Y-m-d", $search->month)->format("Y-m-t");
        } else {
            $date = new \DateTime('now');
            $date->modify('first day of this month');
            $from_date_time = $date->format('Y-m-d');
            $to_date_time = \DateTime::createFromFormat("Y-m-d", $from_date_time)->format("Y-m-t");
        }
        if ($columnName == 'no_of_transaction') {
            $query = BcTransactionBcSummaryDaily::find()
                    ->select('bc_application_id')
                    ->andFilterWhere(['>=', 'date', $from_date_time])
                    ->andFilterWhere(['<=', 'date', $to_date_time]);
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            }
            if ($search->master_partner_bank_id) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
            }
            if ($search->district_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $search->district_code]);
            }
            if ($search->block_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $search->block_code]);
            }
            if ($search->gram_panchayat_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
            }
            $query->asArray();
            return $query->sum('no_of_transaction');
        }
        if ($columnName == 'no_of_bc') {
            $query = BcTransactionBcSummaryDaily::find()
                    ->select('bc_application_id')
                    ->andFilterWhere(['>=', 'date', $from_date_time])
                    ->andFilterWhere(['<=', 'date', $to_date_time]);
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            }
            if ($search->master_partner_bank_id) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
            }
            if ($search->district_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $search->district_code]);
            }
            if ($search->block_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $search->block_code]);
            }
            if ($search->gram_panchayat_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
            }
            $query->asArray();
            return $query->distinct('bc_application_id')->count();
        }
        if ($columnName == 'total_txn_amount') {
            $query = BcTransactionBcSummaryDaily::find()
                    ->select('transaction_amount')
                    ->andFilterWhere(['>=', 'date', $from_date_time])
                    ->andFilterWhere(['<=', 'date', $to_date_time]);
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            }
            if ($search->master_partner_bank_id) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
            }
            if ($search->district_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $search->district_code]);
            }
            if ($search->block_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $search->block_code]);
            }
            if ($search->gram_panchayat_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
            }
            $query->asArray();
            return $query->sum('transaction_amount');
        }
        if ($columnName == 'total_bc_commition') {
            $query = BcTransactionBcSummaryDaily::find()
                    ->select('commission_amount')
                    ->andFilterWhere(['>=', 'date', $from_date_time])
                    ->andFilterWhere(['<=', 'date', $to_date_time]);
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            }
            if ($search->master_partner_bank_id) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
            }
            if ($search->district_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $search->district_code]);
            }
            if ($search->block_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $search->block_code]);
            }
            if ($search->gram_panchayat_code) {
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
            }
            $query->asArray();
            return $query->sum('commission_amount');
        }
        if ($columnName == 'download') {
            $download_url = '/transaction/bc/dailydownload?BcTransactionBcSummaryDailySearch[from_date_time]=' . $from_date_time;
            $download_url .= "&BcTransactionBcSummaryDailySearch[to_date_time]=" . $to_date_time;
//            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
//                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
//                $download_url .= "&BcTransactionBcSummaryDailySearch[master_partner_bank_id]=" . $user_model->master_partner_bank_id;
//            }
            if ($search->master_partner_bank_id) {
                $download_url .= "&BcTransactionBcSummaryDailySearch[master_partner_bank_id]=" . $search->master_partner_bank_id;
            }
            if ($search->district_code) {
                $download_url .= "&BcTransactionBcSummaryDailySearch[district_code]=" . $search->district_code;
            }
            if ($search->block_code) {
                $download_url .= "&BcTransactionBcSummaryDailySearch[block_code]=" . $search->block_code;
            }
            if ($search->gram_panchayat_code) {
                $download_url .= "&BcTransactionBcSummaryDailySearch[gram_panchayat_code]=" . $search->gram_panchayat_code;
            }
            
            return \yii\helpers\Html::a('<i class="fal fa-download"> Download</i>', [$download_url], [
                        'title' => 'Download',
                        'data-pjax' => "0",
                        'class' => 'btn  btn-info',
            ]);
        }
        return $total;
    }
     public function getDownloadurl($model, $search) {
        $user_model = Yii::$app->user->identity;
        $download_url = '/transaction/bc/dailydownload?BcTransactionBcSummaryDailySearch[date]=' . $model->date;
     
//        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
//            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
//            $download_url .= "&BcTransactionBcSummaryDailySearch[master_partner_bank_id]=" . $user_model->master_partner_bank_id;
//        }
        if ($search->master_partner_bank_id) {
            $download_url .= "&BcTransactionBcSummaryDailySearch[master_partner_bank_id]=" . $search->master_partner_bank_id;
        }
        if ($search->district_code) {
            $download_url .= "&BcTransactionBcSummaryDailySearch[district_code]=" . $search->district_code;
        }
        if ($search->block_code) {
            $download_url .= "&BcTransactionBcSummaryDailySearch[block_code]=" . $search->block_code;
        }
        if ($search->gram_panchayat_code) {
            $download_url .= "&BcTransactionBcSummaryDailySearch[gram_panchayat_code]=" . $search->gram_panchayat_code;
        }
        
        return $download_url;
    }
     public function getIconday() {
        $icon = '';
       
        if ($this->change_day == 0) {
            $icon = ' <i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_day > 0) {
             $icon = ' <i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_day < 0) {
             $icon = ' <i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function getIcontran() {
        $icon = '';
     
        if ($this->change_transaction == 0) {
            $icon = ' <i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_transaction > 0) {
             $icon = ' <i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_transaction < 0) {
             $icon = ' <i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }
    
    public function getIcontxnamount() {
        $icon = '';
       
        if ($this->change_transaction_amount == 0) {
            $icon = ' <i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_transaction_amount > 0) {
             $icon = ' <i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_transaction_amount < 0) {
             $icon = ' <i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function getIconcomamount() {
        $icon = '';
     
        if ($this->change_commission_amount == 0) {
            $icon = ' <i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_commission_amount > 0) {
             $icon = ' <i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_commission_amount < 0) {
             $icon = ' <i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }
}

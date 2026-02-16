<?php

namespace bc\models\transaction;

use Yii;
use common\models\master\MasterRole;
/**
 * This is the model class for table "bc_transaction".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property int|null $user_id
 * @property string|null $bankidbc
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $master_partner_bank_id
 * @property int|null $file_id
 * @property int|null $dtable_id
 * @property string|null $fileupload_datetime
 * @property string|null $banktransactionid
 * @property string|null $transaction_datetime
 * @property string|null $transaction_date
 * @property string|null $transaction_time
 * @property float|null $transaction_amount
 * @property string|null $transaction_type
 * @property int|null $ticket
 * @property float|null $commission_amount
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int $status
 */
class BcTransaction extends \bc\models\transaction\BctransactionactiveRecord {

    const BIG_SMALL_TICKET = 2000;
    const SMALL_TICKET = 1;
    const BIG_TICKET = 2;
    public $no_of_transaction;
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'file_id', 'created_by', 'created_at', 'status', 'dtable_id'], 'integer'],
            [['fileupload_datetime', 'transaction_date', 'transaction_time', 'transaction_datetime'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['bankidbc'], 'string', 'max' => 20],
            [['banktransactionid'], 'string', 'max' => 40],
            [['transaction_type'], 'string', 'max' => 255],
//            [['bc_application_id'], 'required'],
//            [['district_code', 'block_code'], 'required'],
            [['master_partner_bank_id'], 'required'],
            [['transaction_type'], 'required'],
            [['banktransactionid', 'transaction_datetime'], 'required'],
            [['banktransactionid'], 'unique'],
            ['transaction_datetime', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            ['transaction_datetime', \common\validators\TransactionDateValidator::className()],
            [['transaction_amount'], 'required'],
            ['commission_amount', 'default', 'value' => 0],
            ['ticket', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'BC Name ',
            'user_id' => 'UPSRLM User',
            'bankidbc' => 'Bank ID',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'GP',
            'master_partner_bank_id' => 'Partner agencies',
            'file_id' => 'File ID',
            'fileupload_datetime' => 'Upload Datetime',
            'banktransactionid' => 'Transaction Id',
            'transaction_datetime' => 'Time stamp',
            'transaction_date' => 'Transaction Date',
            'transaction_time' => 'Transaction Time',
            'transaction_amount' => 'Txn amount',
            'transaction_type' => 'Txn type',
            'commission_amount' => 'BC Commission (INR)',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {


        if ($this->transaction_amount < self::BIG_SMALL_TICKET) {
            $this->ticket = self::SMALL_TICKET;
        }
        if ($this->transaction_amount >= self::BIG_SMALL_TICKET) {
            $this->ticket = self::BIG_TICKET;
        }
        if ($this->isNewRecord) {
            if ($this->created_at == null) {
                $this->created_at = time();
            }
            if ($this->updated_at == null) {
                $this->updated_at = time();
            }
        } else {
            if ($this->updated_at == null) {
                $this->updated_at = time();
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        try {
            list($date, $time) = explode(' ', $this->transaction_datetime);
            $condition = ['and',
                ['=', 'id', $this->id],
            ];
            BcTransaction::updateAll([
                'transaction_date' => $date,
                'transaction_time' => $time
                    ], $condition);
        } catch (\Exception $ex) {
            
        }
        return true;
    }

    public function getBc() {
        return $this->hasOne(SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getPbank() {
        return $this->hasOne(master\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getTransaction($model, $search) {
        $user_model = Yii::$app->user->identity;
        $query = $this->find()
                ->select(['id'])
                ->andFilterWhere(['=', 'transaction_date', $model->transaction_date]);
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
        }
        if ($search->master_partner_bank_id) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
        }
        if ($search->district_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if ($search->block_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.block_code' => $search->block_code]);
        }
        if ($search->gram_panchayat_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
        }
        $query->asArray();
        return $query->count();
    }

    public function getNobc($model, $search) {
        $user_model = Yii::$app->user->identity;
        $query = $this->find()
                ->select('bc_application_id')
                ->andFilterWhere(['=', 'transaction_date', $model->transaction_date]);
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
        }
        if ($search->master_partner_bank_id) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
        }
        if ($search->district_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if ($search->block_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.block_code' => $search->block_code]);
        }
        if ($search->gram_panchayat_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
        }
        $query->asArray();
        return $query->distinct('bc_application_id')->count();
    }

    public function getTotaltxnamount($model, $search) {
        $user_model = Yii::$app->user->identity;
        $query = $this->find()
               ->select(['transaction_amount'])
                ->andFilterWhere(['=', 'transaction_date', $model->transaction_date]);
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
        }
        if ($search->master_partner_bank_id) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
        }
        if ($search->district_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if ($search->block_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.block_code' => $search->block_code]);
        }
        if ($search->gram_panchayat_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
        }
        $query->asArray();
        return $query->sum('transaction_amount');
    }

    public function getTotalbccom($model, $search) {
        $user_model = Yii::$app->user->identity;
        $query = $this->find()
                ->select(['commission_amount'])
                ->andFilterWhere(['=', 'transaction_date', $model->transaction_date]);
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
        }
        if ($search->master_partner_bank_id) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
        }
        if ($search->district_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if ($search->block_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.block_code' => $search->block_code]);
        }
        if ($search->gram_panchayat_code) {
            $query->andWhere([BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
        }
        $query->asArray();
        return $query->sum('commission_amount');
    }

    public function getDownloadurl($model, $search) {
        $user_model = Yii::$app->user->identity;
        $download_url = '/partneragencies/transaction/dailydownload?BcTransactionSearch[transaction_date]=' . $model->transaction_date;
        $query = $this->find()
                ->andFilterWhere(['=', 'transaction_date', $model->transaction_date]);
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $download_url .= "&BcTransactionSearch[master_partner_bank_id]=" . isset($profile) ? $profile->master_partner_bank_id : 0;
        }
        if ($search->master_partner_bank_id) {
            $download_url .= "&BcTransactionSearch[master_partner_bank_id]=" . $search->master_partner_bank_id;
        }
        if ($search->district_code) {
            $download_url .= "&BcTransactionSearch[district_code]=" . $search->district_code;
        }
        if ($search->block_code) {
            $download_url .= "&BcTransactionSearch[block_code]=" . $search->block_code;
        }
        if ($search->gram_panchayat_code) {
            $download_url .= "&BcTransactionSearch[gram_panchayat_code]=" . $search->gram_panchayat_code;
        }
        
        return $download_url;
    }

    public function getDetailurl($model, $search) {
        $user_model = Yii::$app->user->identity;
        $download_url = '/partneragencies/transaction/index?BcTransactionSearch[transaction_date]=' . $model->transaction_date;

        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $download_url .= "&BcTransactionSearch[master_partner_bank_id]=" . isset($profile) ? $profile->master_partner_bank_id : 0;
        }
        if ($search->master_partner_bank_id) {
            $download_url .= "&BcTransactionSearch[master_partner_bank_id]=" . $search->master_partner_bank_id;
        }
        if ($search->district_code) {
            $download_url .= "&BcTransactionSearch[district_code]=" . $search->district_code;
        }
        if ($search->block_code) {
            $download_url .= "&BcTransactionSearch[block_code]=" . $search->block_code;
        }
        if ($search->gram_panchayat_code) {
            $download_url .= "&BcTransactionSearch[gram_panchayat_code]=" . $search->gram_panchayat_code;
        }
        return $download_url;
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
            $query = BcTransaction::find()
                    ->select('bc_application_id')
                    ->andFilterWhere(['>=', 'transaction_date', $from_date_time])
                    ->andFilterWhere(['<=', 'transaction_date', $to_date_time]);
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            }
            if ($search->master_partner_bank_id) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
            }
            if ($search->district_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => $search->district_code]);
            }
            if ($search->block_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.block_code' => $search->block_code]);
            }
            if ($search->gram_panchayat_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
            }
            $query->asArray();
            return $query->count();
        }
        if ($columnName == 'no_of_bc') {
            $query = BcTransaction::find()
                    ->select('bc_application_id')
                    ->andFilterWhere(['>=', 'transaction_date', $from_date_time])
                    ->andFilterWhere(['<=', 'transaction_date', $to_date_time]);
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            }
            if ($search->master_partner_bank_id) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
            }
            if ($search->district_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => $search->district_code]);
            }
            if ($search->block_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.block_code' => $search->block_code]);
            }
            if ($search->gram_panchayat_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
            }
            $query->asArray();
            return $query->distinct('bc_application_id')->count();
        }
        if ($columnName == 'total_txn_amount') {
            $query = BcTransaction::find()
                    ->select('transaction_amount')
                    ->andFilterWhere(['>=', 'transaction_date', $from_date_time])
                    ->andFilterWhere(['<=', 'transaction_date', $to_date_time]);
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            }
            if ($search->master_partner_bank_id) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
            }
            if ($search->district_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => $search->district_code]);
            }
            if ($search->block_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.block_code' => $search->block_code]);
            }
            if ($search->gram_panchayat_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
            }
            $query->asArray();
            return $query->sum('transaction_amount');
        }
        if ($columnName == 'total_bc_commition') {
            $query = BcTransaction::find()
                    ->select('commission_amount')
                    ->andFilterWhere(['>=', 'transaction_date', $from_date_time])
                    ->andFilterWhere(['<=', 'transaction_date', $to_date_time]);
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            }
            if ($search->master_partner_bank_id) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
            }
            if ($search->district_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => $search->district_code]);
            }
            if ($search->block_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.block_code' => $search->block_code]);
            }
            if ($search->gram_panchayat_code) {
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
            }
            $query->asArray();
            return $query->sum('commission_amount');
        }
        if ($columnName == 'download') {
            $download_url = '/partneragencies/transaction/dailydownload?BcTransactionSearch[from_date_time]=' . $from_date_time;
            $download_url .= "&BcTransactionSearch[to_date_time]=" . $to_date_time;
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $download_url .= "&BcTransactionSearch[master_partner_bank_id]=" . isset($profile) ? $profile->master_partner_bank_id : 0;
            }
            if ($search->master_partner_bank_id) {
                $download_url .= "&BcTransactionSearch[master_partner_bank_id]=" . $search->master_partner_bank_id;
            }
            if ($search->district_code) {
                $download_url .= "&BcTransactionSearch[district_code]=" . $search->district_code;
            }
            if ($search->block_code) {
                $download_url .= "&BcTransactionSearch[block_code]=" . $search->block_code;
            }
            if ($search->gram_panchayat_code) {
                $download_url .= "&BcTransactionSearch[gram_panchayat_code]=" . $search->gram_panchayat_code;
            }
            return \yii\helpers\Html::a('<i class="fal fa-download"> Download</i>', [$download_url], [
                        'title' => 'Download',
                        'data-pjax' => "0",
                        'class' => 'btn  btn-info',
            ]);
        }
        if ($columnName == 'detail') {
            $download_url = '/partneragencies/transaction/index?BcTransactionSearch[from_date_time]=' . $from_date_time;
            $download_url .= "&BcTransactionSearch[to_date_time]=" . $to_date_time;
            if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, \common\models\master\MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $download_url .= "&BcTransactionSearch[master_partner_bank_id]=" . isset($profile) ? $profile->master_partner_bank_id : 0;
            }
            if ($search->master_partner_bank_id) {
                $download_url .= "&BcTransactionSearch[master_partner_bank_id]=" . $search->master_partner_bank_id;
            }
            if ($search->district_code) {
                $download_url .= "&BcTransactionSearch[district_code]=" . $search->district_code;
            }
            if ($search->block_code) {
                $download_url .= "&BcTransactionSearch[block_code]=" . $search->block_code;
            }
            if ($search->gram_panchayat_code) {
                $download_url .= "&BcTransactionSearch[gram_panchayat_code]=" . $search->gram_panchayat_code;
            }
            return \yii\helpers\Html::a('<i class="fal fa-eye"> View </i>', [$download_url], [
                        'title' => 'Detail View',
                        'data-pjax' => "0",
                        'class' => 'btn  btn-info',
            ]);
        }
        return $total;
    }

}

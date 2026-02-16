<?php

namespace cbo\models\sakhi;

use Yii;

/**
 * This is the model class for table "rishta_shg_bank_details".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property string|null $bank_account_no_of_the_shg
 * @property int|null $bank_id
 * @property string|null $name_of_bank
 * @property string|null $branch
 * @property string|null $branch_code_or_ifsc
 * @property string|null $date_of_opening_the_bank_account
 * @property int|null $balance_as_on_date
 * @property string|null $passbook_photo
 * @property string|null $bank_balance_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class DeleteRishtaShgBankDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rishta_shg_bank_detail';
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cbo_shg_id', 'bank_id', 'balance_as_on_date', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['date_of_opening_the_bank_account', 'bank_balance_date'], 'safe'],
            [['bank_account_no_of_the_shg', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['name_of_bank', 'branch'], 'string', 'max' => 150],
            [['passbook_photo'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'bank_account_no_of_the_shg' => 'Bank Account No Of The Shg',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'balance_as_on_date' => 'Balance As On Date',
            'passbook_photo' => 'Passbook Photo',
            'bank_balance_date' => 'Bank Detail Date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * This Function Return SHG Details
     *
     * @return void
     */
    public function getShg() {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }

    public function getBank() {
        return $this->hasOne(\cbo\models\master\CboMasterBank::className(), ['id' => 'bank_id']);
    }
}

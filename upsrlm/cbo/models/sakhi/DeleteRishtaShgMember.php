<?php

namespace cbo\models\sakhi;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rishta_shg_member".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property string $name
 * @property string|null $mobile
 * @property int|null $marital_status
 * @property int|null $age
 * @property int|null $caste_category
 * @property int|null $duration_of_membership
 * @property int|null $total_saving
 * @property int|null $loan
 * @property int|null $loan_count
 * @property string|null $loan_amount
 * @property string|null $loan_date
 * @property int|null $mcp_status
 * @property int|null $office_bearer
 * @property int|null $role
 * @property int|null $bank_account
 * @property int|null $relative_in_shg
 * @property int|null $no_of_relative
 * @property int|null $current_member
 * @property int|null $user_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class DeleteRishtaShgMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rishta_shg_member';
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
            [['cbo_shg_id', 'marital_status', 'age', 'caste_category', 'duration_of_membership', 'total_saving', 'loan', 'loan_count', 'mcp_status', 'office_bearer', 'role', 'bank_account', 'relative_in_shg', 'no_of_relative', 'current_member', 'user_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'required'],
            [['loan_date'], 'safe'],
            [['name', 'loan_amount'], 'string', 'max' => 150],
            [['mobile'], 'string', 'max' => 15],
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
            'name' => 'Name',
            'mobile' => 'Mobile',
            'marital_status' => 'Marital Status',
            'age' => 'Age',
            'caste_category' => 'Caste Category',
            'duration_of_membership' => 'Duration Of Membership',
            'total_saving' => 'Total Saving',
            'loan' => 'Loan',
            'loan_count' => 'Loan Count',
            'loan_amount' => 'Loan Amount',
            'loan_date' => 'Loan Date',
            'mcp_status' => 'Mcp Status',
            'office_bearer' => 'Office Bearer',
            'role' => 'Role',
            'bank_account' => 'Bank Account',
            'relative_in_shg' => 'Relative In Shg',
            'no_of_relative' => 'No Of Relative',
            'current_member' => 'Current Member',
            'user_id' => 'User ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getShgrole() {
        return $this->hasOne(\cbo\models\MasterMemberDesignation::className(), ['id' => 'role']);
    }
    public function getShg() {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }
    public static function shgrolelist()
    {
        return ArrayHelper::map(\cbo\models\MasterMemberDesignation::find()->where(['status' => 1,'entity_type'=>1])->orderBy('role_hindi')->all(), 'id', 'role_hindi');
    }
}

<?php

namespace cbo\models\sakhi\form;

use Yii;
use cbo\models\sakhi\RishtaShgMember;

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
 * @property int|null $role
 */
/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */

class DeleteRishtaShgMemberForm extends \yii\base\Model {

    public $id;
    public $cbo_shg_id;
    public $shg_member_id;
    public $name;
    public $mobile;
    public $marital_status;
    public $age;
    public $caste_category;
    public $duration_of_membership;
    public $total_saving;
    public $loan;
    public $loan_count;
    public $mcp_status;
    public $loan_date;
    public $loan_amount;
    public $shg_member_model;

    public function __construct($shg_member_model = null) {
        $this->shg_member_model = Yii::createObject([
                    'class' => RishtaShgMember::className()
        ]);
        if ($shg_member_model != null) {
            $this->shg_member_model = $shg_member_model;
            $this->cbo_shg_id = $this->shg_member_model->cbo_shg_id;
            $this->name = $this->shg_member_model->name;
            $this->mobile = $this->shg_member_model->mobile;
            $this->marital_status = $this->shg_member_model->marital_status;
            $this->age = $this->shg_member_model->age;
            $this->caste_category = $this->shg_member_model->caste_category;
            $this->duration_of_membership = $this->shg_member_model->duration_of_membership;
            $this->total_saving = $this->shg_member_model->total_saving;
            $this->loan = $this->shg_member_model->loan;
            $this->loan_count = $this->shg_member_model->loan_count;
            $this->mcp_status = $this->shg_member_model->mcp_status;
            $this->loan_date = $this->shg_member_model->loan_date;
            $this->loan_amount = $this->shg_member_model->loan_amount;
        }
    }

    public function rules() {
        return [
            [['name','marital_status', 'age', 'caste_category', 'duration_of_membership', 'total_saving', 'loan','mobile'], 'required', 'message' =>"{attribute} खाली नहीं हो सकता."],
            [['cbo_shg_id', 'shg_member_id', 'marital_status', 'age', 'caste_category', 'duration_of_membership', 'total_saving', 'loan', 'loan_count', 'mcp_status','loan_amount'], 'integer'],
            [['loan_date'], 'safe'],
            [['mobile'], \common\validators\MobileNoValidator::class],
            [['mobile'], 'string', 'max' => 10],
            [['name'], 'trim'],
            [['name'], 'string', 'min'=>2 ,'max' => 150],
            [['mcp_status'], 'required', 'when' => function($model) { if($model->loan==0){ $cond =true; } else{ $cond = false; } return $cond; }],
            [['loan_count','loan_amount','loan_date'], 'required', 'when' => function($model) { if($model->loan==1){ $cond =true; } else{ $cond = false; } return $cond; }],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'name' => 'सदस्यों के नाम',
            'mobile'=>'मोबाइल न0',
            'marital_status' => 'वैवाहिक स्थिति',
            'age' => 'आयु',
            'caste_category' => 'जाति श्रेणी',
            'duration_of_membership' => 'कितने समय से समूह के सदस्य हैं',
            'total_saving' => 'अबतक समूह में कुल बचत',
            'loan' => 'ऋण',
            'loan_count' => 'अगर हाँ, तो कितनी बार',
            'loan_amount' => 'ऋण के रकम',
            'loan_date' => 'ऋण के तिथि',
            'mcp_status' => 'अगर ना, तो MCP की स्थिति',
            'role' => 'Role',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }


}

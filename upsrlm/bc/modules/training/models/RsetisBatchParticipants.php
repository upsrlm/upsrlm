<?php

namespace bc\modules\training\models;

use Yii;

/**
 * This is the model class for table "rsetis_batch_participants".
 *
 * @property int $id
 * @property int|null $rsetis_center_id
 * @property int|null $rsetis_batch_id
 * @property int|null $rsetis_center_training_id
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $sur_name
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property string|null $mobile_number
 * @property string|null $otp_mobile_no
 * @property int|null $bc_application_id
 * @property int|null $bc_selection_user_id
 * @property float|null $exam_score
 * @property string|null $certificate_code
 * @property int $training_status
 * @property int $pvr_status
 * @property int|null $pvr_upload_by
 * @property string|null $pvr_upload_date
 * @property string|null $pvr_upload_file_name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class RsetisBatchParticipants extends \bc\models\BcactiveRecord {

    const TRAINING_STATUS_UNWILLING = -2;
    const TRAINING_STATUS_ASIGNT_TO_BATCH = 2; //Registered 
    const TRAINING_STATUS_PASS = 3; //Certified
    const TRAINING_STATUS_CERTIFIED_UNWILLING = 32;
    const TRAINING_STATUS_FAIL = 4; //Not Certified 
    const TRAINING_STATUS_INELIIGIBLE = 5; //ineligible 
    const TRAINING_STATUS_ABSENT = 6; //Absent

    //const TRAINING_STATUS_ONBOARDING = 7; //Onboarding

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
    public static function tableName() {
        return 'rsetis_batch_participants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['rsetis_center_id', 'rsetis_batch_id', 'bc_application_id', 'rsetis_center_training_id', 'bc_application_id', 'bc_selection_user_id'], 'required'],
            [['rsetis_center_id', 'rsetis_batch_id', 'rsetis_center_training_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'bc_application_id', 'bc_selection_user_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['first_name', 'middle_name', 'sur_name', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name'], 'string', 'max' => 100],
            [['mobile_number', 'otp_mobile_no'], 'string', 'max' => 15],
            [['status'], 'default', 'value' => 1],
            [['exam_score'], 'number'],
            [['certificate_code'], 'string', 'max' => 100],
            [['training_status'], 'integer'],
            [['training_status'], 'default', 'value' => 2],
            [['exam_score'], 'trim'],
            [['certificate_code'], 'trim'],
            [['pvr_status', 'pvr_upload_by'], 'integer'],
            [['pvr_upload_date'], 'safe'],
            [['pvr_upload_file_name'], 'string', 'max' => 500],
            [['pvr_status'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'rsetis_center_id' => 'Venue',
            'rsetis_batch_id' => 'Batch',
            'rsetis_center_training_id' => 'Training',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'sur_name' => 'Sur Name',
            'division_code' => 'Division',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'GP',
            'gram_panchayat_name' => 'GP',
            'mobile_number' => 'Mobile Number',
            'otp_mobile_no' => 'Otp Mobile No',
            'bc_application_id' => 'Bc Application ID',
            'bc_selection_user_id' => 'Bc Selection User ID',
            'exam_score' => 'Exam Score',
            'certificate_code' => 'IIBF membership No.',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        if ($this->bc_application_id) {
            $app_model = \bc\modules\selection\models\SrlmBcApplication::findOne(['id' => $this->bc_application_id]);
            if ($app_model != null) {
                $this->first_name = $app_model->first_name;
                $this->middle_name = $app_model->middle_name;
                $this->sur_name = $app_model->sur_name;
                $this->division_code = $app_model->division_code;
                $this->division_name = $app_model->division_name;
                $this->district_code = $app_model->district_code;
                $this->district_name = $app_model->district_name;
                $this->block_code = $app_model->block_code;
                $this->block_name = $app_model->block_name;
                $this->gram_panchayat_code = $app_model->gram_panchayat_code;
                $this->gram_panchayat_name = $app_model->gram_panchayat_name;
                $this->mobile_number = $app_model->mobile_number;
                $this->otp_mobile_no = isset($app_model->user) ? $app_model->user->mobile_no : null;
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        try {
            if ($this->center != null) {
                $this->center->update();
            }
            if ($this->training != null) {
                $this->training->update();
            }
            if ($this->batch != null) {
                $this->batch->update();
            }
        } catch (Exception $ex) {
            
        }
        return true;
    }

    public function getName() {
        $html = '';
        if ($this->first_name)
            $html .= $this->first_name . ' ';
        if ($this->middle_name)
            $html .= $this->middle_name . ' ';
        if ($this->sur_name)
            $html .= $this->sur_name;
        return trim($html);
    }

    public function getCenter() {
        return $this->hasOne(RsetisCenter::className(), ['id' => 'rsetis_center_id']);
    }

    public function getBatch() {
        return $this->hasOne(RsetisBatchTraining::className(), ['id' => 'rsetis_batch_id']);
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }
    public function getBlock() {
        return $this->hasOne(\bc\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }
    public function getTraining() {
        return $this->hasOne(RsetisCenterTraining::className(), ['id' => 'rsetis_center_training_id']);
    }

    public function getParticipant() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getTrainingstatus() {
        $html = '';
        if ($this->training_status == self::TRAINING_STATUS_ASIGNT_TO_BATCH) {
            $html .= '<span class="label label-primary">Registered</span>';
        }
        if ($this->training_status == self::TRAINING_STATUS_PASS and $this->participant->already_certified == 0) {
            $html .= '<span class="label label-success">Certified</span>';
        }
        if ($this->training_status == self::TRAINING_STATUS_CERTIFIED_UNWILLING) {
            $html .= '<span class="label label-success">Certified Unwilling</span>';
        }
        if ($this->training_status == self::TRAINING_STATUS_PASS and $this->participant->already_certified == 1) {
            $html .= '<span class="label label-success">Already Certified</span>';
        }
        if ($this->training_status == self::TRAINING_STATUS_FAIL) {
            $html .= '<span class="label label-info">Not Certified</span>';
        }
        if ($this->training_status == self::TRAINING_STATUS_INELIIGIBLE) {
            $html .= '<span class="label label-warning">Ineligible</span>';
        }
        if ($this->training_status == self::TRAINING_STATUS_ABSENT) {
            $html .= '<span class="label label-danger">Absent</span>';
        }
        if ($this->training_status == self::TRAINING_STATUS_UNWILLING) {
            $html .= '<span class="label label-danger">Unwilling</span>';
        }
        return $html;
    }

    public function getTstatus() {
        return $this->hasOne(RsetisTrainingStatus::className(), ['id' => 'training_status']);
    }

    public function getContacts() {
        return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code'])->joinWith(['user'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT]);
    }

    public function getRsethileadbank() {
        return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code'])->joinWith(['user', 'profile'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'relation_user_district.status' => 1]);
    }

    public function getBcbankpartner() {
        return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code'])->joinWith(['user'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'relation_user_district.status' => 1]);
    }
    public function getTrans() {
        return $this->hasOne(\bc\modules\transaction\models\summary\BcTransactionBcSummary::className(), ['bc_application_id' => 'bc_application_id']);
    }

}

<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "srlm_bc_selection_user".
 *
 * @property int $id
 * @property int $srlm_bc_selection_app_detail_id
 * @property string $mobile_no
 * @property string|null $firebase_token
 * @property string|null $form_uuid
 * @property string|null $form_json
 * @property string|null $profile_photo
 * @property string|null $aadhar_front_photo
 * @property string|null $form_start_date
 * @property string|null $form_end_date
 * @property string|null $aadhar_back_photo
 * @property int|null $form_number
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class DelSrlmBcSelectionUser extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'del_srlm_bc_selection_user';
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['srlm_bc_selection_app_detail_id', 'mobile_no', 'firebase_token', 'form_uuid', 'form_json', 'created_at', 'updated_at'], 'required'],
            [['srlm_bc_selection_app_detail_id', 'created_at', 'updated_at', 'status', 'form_number'], 'integer'],
            [['firebase_token', 'form_json'], 'string'],
            [['mobile_no'], 'string', 'max' => 10],
            [['form_uuid'], 'string', 'max' => 36],
            [['profile_photo', 'aadhar_front_photo', 'aadhar_back_photo'], 'string', 'max' => 255],
            [['mobile_no'], 'unique'],
            [['form_uuid'], 'unique'],
            [['status'], 'default', 'value' => '1'],
            [['form_number'], 'default', 'value' => 0],
            [['form_start_date', 'form_end_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'srlm_bc_selection_app_detail_id' => 'Srlm Bc Selection App Detail ID',
            'mobile_no' => 'Mobile No',
            'firebase_token' => 'Firebase Token',
            'form_uuid' => 'Form Uuid',
            'form_json' => 'Form Json',
            'profile_photo' => 'Profile Photo',
            'aadhar_front_photo' => 'Aadhar Front Photo',
            'aadhar_back_photo' => 'Aadhar Back Photo',
            'form_number' => 'Form Number',
            'form_start_date' => 'Form Start Date',
            'form_end_date' => 'Form End Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getBcsapplication() {
        return $this->hasOne(SrlmBcApplication::className(), ['srlm_bc_selection_user_id' => 'id']);
    }

    public function getBcsapplicationf() {
        return $this->hasOne(SrlmBcApplication::className(), ['srlm_bc_selection_user_id' => 'id'])->where(['!=', 'form_number', 0]);
    }

}

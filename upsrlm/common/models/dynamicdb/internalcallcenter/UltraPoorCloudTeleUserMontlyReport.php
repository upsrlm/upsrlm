<?php

namespace common\models\dynamicdb\internalcallcenter;

use Yii;

/**
 * This is the model class for table "ultra_poor_cloud_tele_user_montly_report".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $mobile_no
 * @property int|null $user_id
 * @property int|null $role
 * @property int|null $month_id
 * @property string|null $month_start_date
 * @property string|null $month_end_date
 * @property int|null $no_of_call
 * @property int|null $no_of_ctc_call
 * @property int|null $no_of_ibd_call
 * @property int|null $total_time
 * @property string|null $total_time_text
 * @property int|null $ctc_time
 * @property string|null $ctc_time_text
 * @property string|null $ibd_time_text
 * @property int|null $ibd_time
 * @property int|null $ivr_time
 * @property string|null $ivr_time_text
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class UltraPoorCloudTeleUserMontlyReport extends CloudTeleUserMontlyReport {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ultra_poor_cloud_tele_user_montly_report';
    }
    public function behaviors() {
        return [
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
    public function rules() {
        return [
            [['user_id', 'role', 'month_id', 'no_of_call', 'no_of_ctc_call', 'no_of_ibd_call', 'total_time', 'ctc_time', 'ibd_time', 'ivr_time', 'created_at', 'updated_at'], 'integer'],
            [['month_start_date', 'month_end_date'], 'safe'],
            [['name', 'ivr_time_text'], 'string', 'max' => 255],
            [['mobile_no'], 'string', 'max' => 12],
            [['total_time_text', 'ctc_time_text', 'ibd_time_text'], 'string', 'max' => 150],
            [['user_id', 'month_id'], 'unique', 'targetAttribute' => ['user_id', 'month_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'mobile_no' => 'Mobile No',
            'user_id' => 'User ID',
            'role' => 'Role',
            'month_id' => 'Month ID',
            'month_start_date' => 'Month Start Date',
            'month_end_date' => 'Month End Date',
            'no_of_call' => 'No Of Call',
            'no_of_ctc_call' => 'No Of Ctc Call',
            'no_of_ibd_call' => 'No Of Ibd Call',
            'total_time' => 'Total Time',
            'total_time_text' => 'Total Time Text',
            'ctc_time' => 'Ctc Time',
            'ctc_time_text' => 'Ctc Time Text',
            'ibd_time_text' => 'Ibd Time Text',
            'ibd_time' => 'Ibd Time',
            'ivr_time' => 'Ivr Time',
            'ivr_time_text' => 'Ivr Time Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

}

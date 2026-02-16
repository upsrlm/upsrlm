<?php

namespace common\models\dynamicdb\internalcallcenter;

use Yii;

/**
 * This is the model class for table "cloud_tele_user_montly_report".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $role
 * @property int|null $month_id
 * @property string|null $month_start_date
 * @property string|null $month_end_date
 * @property int|null $no_of_ctc_call
 * @property int|null $no_of_ibd_call
 * @property int|null $no_of_call
 * @property int|null $total_time
 * @property string|null $total_time_text
 * @property int|null $ctc_time
 * @property string|null $ibd_time_text
 * @property int|null $ibd_time
 * @property string|null $ctc_time_text
 * @property int|null $ivr_time
 * @property string|null $ivr_time_text
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class CloudTeleUserMontlyReport extends InternalCallCenteractiveRecord {

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
    public static function tableName() {
        return 'cloud_tele_user_montly_report';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'role', 'month_id', 'no_of_ctc_call', 'no_of_ibd_call', 'no_of_call', 'total_time', 'ctc_time', 'ibd_time', 'ivr_time', 'created_at', 'updated_at'], 'integer'],
            [['month_start_date', 'month_end_date'], 'safe'],
            [['total_time_text', 'ibd_time_text', 'ctc_time_text', 'ivr_time_text'], 'string', 'max' => 150],
            ['no_of_ctc_call', 'default', 'value' => 0],
            ['no_of_ibd_call', 'default', 'value' => 0],
            ['no_of_call', 'default', 'value' => 0],
            ['total_time', 'default', 'value' => 0],
            ['ibd_time', 'default', 'value' => 0],
            ['ctc_time', 'default', 'value' => 0],
            ['ivr_time', 'default', 'value' => 0],
            [['user_id', 'month_id'], 'unique', 'targetAttribute' => ['user_id', 'month_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'role' => 'Role',
            'month_id' => 'Month ID',
            'month_start_date' => 'Month Start Date',
            'month_end_date' => 'Month End Date',
            'no_of_ctc_call' => 'No Of Ctc Call',
            'no_of_ibd_call' => 'No Of Ibd Call',
            'no_of_call' => 'No Of Call',
            'total_time' => 'Total Time',
            'total_time_text' => 'Total Time Text',
            'ctc_time' => 'Ctc Time',
            'ibd_time_text' => 'Ibd Time Text',
            'ibd_time' => 'Ibd Time',
            'ctc_time_text' => 'Ctc Time Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

}

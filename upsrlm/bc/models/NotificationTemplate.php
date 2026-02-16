<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "notification_template".
 *
 * @property int $id
 * @property string $name
 * @property string $template
 * @property int $acknowledge
 * @property int|null $visible
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 */
class NotificationTemplate extends \bc\modules\selection\models\BcactiveRecord {

    const PRESELECTED_ACKNOLEDGE_TEMPLATE_ID = 1;
    const STANDBY_ACKNOLEDGE_TEMPLATE_ID = 2;
    const APP_UPDATE_ACKNOLEDGE_TEMPLATE_ID = 3;
    const APP_UPDATE_SHORT_ACKNOLEDGE_TEMPLATE_ID = 4;
    const PRESELECTED_ACKNOLEDGE_TELE_INFO_TEMPLATE_ID = 5;
    const SHORTLISTED_BC_FORMING_BATCH_TEMPLATE_ID = 6;
    const CERTIFIED_BC_BANK_ACCOUNT_TEMPLATE_ID = 7;
    const CERTIFIED_TEMPLATE_ID_8 = 8;
    const CERTIFIED_TEMPLATE_ID_9 = 9;
    const CERTIFIED_TEMPLATE_ID_10 = 10;
    const CERTIFIED_TEMPLATE_ID_11 = 11; // pan info
    const CERTIFIED_TEMPLATE_ID_12 = 12; // pan upload
    const CORONA_TEMPLATE_ID_13 = 13; // CORONA 
    const RISHTA_CALL_CENTER_TEMPLATE_ID_14 = 14; // RISHTA Call Center
    const RETURN_BANK_DETAIL_TEMPLATE_ID_15 = 15; // Return Bank detail
    const POLICE_VERIFICATION_TEMPLATE_ID_16 = 16; // POLICE VERIFICATION 
    const ONBOARDING_PROCESS_TEMPLATE_ID_17 = 17; // Onboarding process 
    const PAYMENT_OF_BC_SUPPORT_FUND_TEMPLATE_ID_16 = 18; // Payment of BC Support Fund  
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
        return 'notification_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'template', 'acknowledge', 'visible'], 'required'],
            [['name', 'template'], 'string'],
            [['acknowledge', 'visible', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['status'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'template' => 'Template',
            'acknowledge' => 'Acknowledge',
            'visible' => 'Visible',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

}

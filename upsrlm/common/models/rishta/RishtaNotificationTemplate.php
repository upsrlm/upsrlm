<?php

namespace common\models\rishta;

use Yii;

/**
 * This is the model class for table "rishta_notification_template".
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
class RishtaNotificationTemplate extends \common\models\dynamicdb\rishta_log\RishtalogactiveRecord {

    const APP_DATA_UPDATE_TEMP_ID = 1;
    const REJECT_SAMUH_SAKHI_BANK_DETAIL_TEMP_ID = 2;

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
        return 'rishta_notification_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'template', 'acknowledge', 'visible',], 'required'],
            [['name', 'template'], 'string'],
            [['name', 'template'], 'trim'],
            [['acknowledge', 'visible', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
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

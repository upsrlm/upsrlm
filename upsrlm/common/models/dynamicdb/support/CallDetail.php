<?php

namespace common\models\dynamicdb\support;

use Yii;

/**
 * This is the model class for table "call_detail".
 *
 * @property string $call_date
 * @property string|null $call_type
 * @property string|null $calling_no
 * @property string $call_start
 * @property int|null $call_duration
 * @property string|null $cc_executive_code
 * @property string|null $cc_executive_name
 */
class CallDetail extends SupportDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'technosys_call_detail';
    }

  
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['call_date', 'call_start'], 'required'],
            [['call_duration'], 'integer'],
            [['call_date', 'cc_executive_code'], 'string', 'max' => 10],
            [['call_type'], 'string', 'max' => 4],
            [['calling_no', 'call_start'], 'string', 'max' => 20],
            [['cc_executive_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'call_date' => 'Call Date',
            'call_type' => 'Call Type',
            'calling_no' => 'Calling No',
            'call_start' => 'Call Start',
            'call_duration' => 'Call Duration',
            'cc_executive_code' => 'Cc Executive Code',
            'cc_executive_name' => 'Cc Executive Name',
        ];
    }

}

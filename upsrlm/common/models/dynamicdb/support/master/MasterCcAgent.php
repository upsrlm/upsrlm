<?php

namespace common\models\dynamicdb\support\master;

use Yii;

/**
 * This is the model class for table "master_cc_agent".
 *
 * @property int|null $sr_no
 * @property string|null $cc_executive_code
 * @property string|null $cc_executive_name
 * @property string|null $cc_executive_current_status
 * @property int|null $Is_peramanent
 */
class MasterCcAgent extends \common\models\dynamicdb\support\SupportDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'technosys_master_cc_agent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sr_no', 'Is_peramanent'], 'integer'],
            [['cc_executive_code'], 'string', 'max' => 4],
            [['cc_executive_name'], 'string', 'max' => 150],
            [['cc_executive_current_status'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'sr_no' => 'Sr No',
            'cc_executive_code' => 'Cc Executive Code',
            'cc_executive_name' => 'Cc Executive Name',
            'cc_executive_current_status' => 'Cc Executive Current Status',
            'Is_peramanent' => 'Is Peramanent',
        ];
    }

}

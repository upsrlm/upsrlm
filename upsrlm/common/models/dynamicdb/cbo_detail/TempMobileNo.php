<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "temp_mobile_no".
 *
 * @property int $mobile_id
 * @property string|null $mobile_no
 */
class TempMobileNo extends CboDetailactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temp_mobile_no';
    }

    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobile_no'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mobile_id' => 'Mobile ID',
            'mobile_no' => 'Mobile No',
        ];
    }
}

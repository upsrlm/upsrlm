<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "cbo_user".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $mobile_no
 * @property int|null $gram_panchayat_code
 * @property int|null $role
 * @property int|null $user_id
 * @property int $status
 * @property int $mobile_status
 * @property int $ctc_click_count
 * @property int $ibd
 * @property string|null $ibd_date
 * @property string|null $ibd_datetime
 */
class CboUser extends \common\models\dynamicdb\cbo\CboactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cbo_user';
    }

    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gram_panchayat_code', 'role', 'user_id', 'status', 'mobile_status', 'ctc_click_count', 'ibd'], 'integer'],
            [['ibd_date', 'ibd_datetime'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['mobile_no'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'mobile_no' => 'Mobile No',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'role' => 'Role',
            'user_id' => 'User ID',
            'status' => 'Status',
            'mobile_status' => 'Mobile Status',
            'ctc_click_count' => 'Ctc Click Count',
            'ibd' => 'Ibd',
            'ibd_date' => 'Ibd Date',
            'ibd_datetime' => 'Ibd Datetime',
        ];
    }
}

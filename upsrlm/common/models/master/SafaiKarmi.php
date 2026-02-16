<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "safai_karmi".
 *
 * @property int $id
 * @property string|null $s_no
 * @property string|null $district
 * @property string|null $block
 * @property string|null $gram_panchyat
 * @property string|null $name
 * @property string|null $gender
 * @property string|null $age
 * @property string|null $mobile_no
 * @property string|null $alternative_mobile_no
 * @property int|null $district_code
 * @property int|null $block_code
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
class SafaiKarmi extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'safai_karmi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['mobile_no'], 'required'],
            [['mobile_no'], \common\validators\MobileNoValidator::className(), 'message' => "{attribute} अमान्य ।"],
            [['gram_panchayat_code'], 'required'],
            [['gram_panchayat_code'], 'integer'],
            ['gram_panchayat_code', 'exist', 'targetClass' => MasterGramPanchayat::class, 'targetAttribute' => ['gram_panchayat_code' => 'gram_panchayat_code']],
            [['district_code', 'block_code', 'gram_panchayat_code', 'role', 'user_id', 'status', 'mobile_status', 'ctc_click_count', 'ibd'], 'integer'],
            [['ibd_date', 'ibd_datetime'], 'safe'],
            [['s_no'], 'string', 'max' => 5],
            [['district', 'block', 'gram_panchyat'], 'string', 'max' => 150],
            [['name'], 'string', 'max' => 255],
            [['gender', 'age'], 'string', 'max' => 100],
            [['mobile_no'], 'string', 'max' => 20],
            [['alternative_mobile_no'], 'string', 'max' => 21],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            's_no' => 'S No',
            'district' => 'District',
            'block' => 'Block',
            'gram_panchyat' => 'Gram Panchyat',
            'name' => 'Name',
            'gender' => 'Gender',
            'age' => 'Age',
            'mobile_no' => 'Mobile No',
            'alternative_mobile_no' => 'Alternative Mobile No',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
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

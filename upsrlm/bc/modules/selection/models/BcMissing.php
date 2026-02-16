<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_missing".
 *
 * @property int $id
 * @property string|null $bc_name
 * @property string|null $mobile_number
 * @property string|null $district_name
 * @property string|null $block_name
 * @property string|null $gram_panchayat_name
 * @property string|null $date_of_training
 * @property string|null $certified
 * @property int|null $bc_application_id
 * @property int|null $bc_selection_user_id
 * @property int|null $rseti_bc_age
 * @property int|null $rseti_bc_education
 * @property int|null $rseti_bc_shg_member
 * @property int|null $rseti_bc_application_status
 * @property int|null $rseti_bc_cast
 * @property int|null $listed_bc_training_status
 * @property int|null $listed_bc_application_id
 * @property int|null $listed_bc_selection_user_id
 * @property int|null $listed_bc_age
 * @property int|null $listed_bc_cast
 * @property int|null $listed_bc_education
 * @property int|null $listed_bc_shg_member
 * @property int $listed_bc_onboard
 * @property int $listed_bc_funds_transfer
 * @property int $bc_same
 * @property string|null $comment
 */
class BcMissing extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_missing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id', 'rseti_bc_age', 'rseti_bc_education', 'rseti_bc_shg_member', 'rseti_bc_application_status', 'rseti_bc_cast', 'listed_bc_training_status', 'listed_bc_application_id', 'listed_bc_selection_user_id', 'listed_bc_age', 'listed_bc_cast', 'listed_bc_education', 'listed_bc_shg_member', 'listed_bc_onboard', 'listed_bc_funds_transfer', 'bc_same'], 'integer'],
            [['bc_name', 'district_name', 'block_name', 'gram_panchayat_name', 'date_of_training', 'certified'], 'string', 'max' => 255],
            [['mobile_number'], 'string', 'max' => 20],
            [['comment'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_name' => 'Bc Name',
            'mobile_number' => 'Mobile Number',
            'district_name' => 'District Name',
            'block_name' => 'Block Name',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'date_of_training' => 'Date Of Training',
            'certified' => 'Certified',
            'bc_application_id' => 'Bc Application ID',
            'bc_selection_user_id' => 'Bc Selection User ID',
            'rseti_bc_age' => 'Rseti Bc Age',
            'rseti_bc_education' => 'Rseti Bc Education',
            'rseti_bc_shg_member' => 'Rseti Bc Shg Member',
            'rseti_bc_application_status' => 'Rseti Bc Application Status',
            'rseti_bc_cast' => 'Rseti Bc Cast',
            'listed_bc_training_status' => 'Listed Bc Training Status',
            'listed_bc_application_id' => 'Listed Bc Application ID',
            'listed_bc_selection_user_id' => 'Listed Bc Selection User ID',
            'listed_bc_age' => 'Listed Bc Age',
            'listed_bc_cast' => 'Listed Bc Cast',
            'listed_bc_education' => 'Listed Bc Education',
            'listed_bc_shg_member' => 'Listed Bc Shg Member',
            'listed_bc_onboard' => 'Listed Bc Onboard',
            'listed_bc_funds_transfer' => 'Listed Bc Funds Transfer',
            'bc_same' => 'Bc Same',
            'comment' => 'Comment',
        ];
    }

    public function getBc() {
        return $this->hasOne(SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getListedbc() {
        return $this->hasOne(SrlmBcApplication::className(), ['id' => 'listed_bc_application_id']);
    }

}

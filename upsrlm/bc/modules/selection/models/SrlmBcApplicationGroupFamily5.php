<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "srlm_bc_application_group_family4".
 *
 * @property int $id
 * @property string|null $form_uuid
 * @property string|null $family_uuid
 * @property int|null $srlm_bc_application_id
 * @property string $member_name
 * @property int|null $position
 * @property string|null $mobile_no
 * @property int $status
 */
class SrlmBcApplicationGroupFamily5 extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'srlm_bc_application_group_family5';
    }

   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['srlm_bc_application_id', 'position', 'status'], 'integer'],
            [['member_name'], 'required'],
            [['form_uuid', 'family_uuid'], 'string', 'max' => 36],
            [['member_name'], 'string', 'max' => 255],
            [['mobile_no'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_uuid' => 'Form Uuid',
            'family_uuid' => 'Family Uuid',
            'srlm_bc_application_id' => 'Srlm Bc Application ID',
            'member_name' => 'Member Name',
            'position' => 'Position',
            'mobile_no' => 'Mobile No',
            'status' => 'Status',
        ];
    }
}

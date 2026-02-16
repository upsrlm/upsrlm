<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "FootPrintLocation".
 *
 * @property int $id
 * @property int $group_id
 * @property int $state_code
 * @property string $state_name
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $block_code
 * @property string $bllock_name
 */
class FootPrintLocation extends BcactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'FootPrintLocation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'state_code', 'state_name', 'division_code', 'division_name', 'district_code', 'district_name', 'block_code', 'bllock_name'], 'required'],
            [['group_id', 'state_code', 'division_code', 'district_code', 'block_code'], 'integer'],
            [['state_name', 'division_name', 'district_name', 'bllock_name'], 'string', 'max' => 255],
            [['block_code', 'district_code', 'division_code', 'group_id', 'state_code'], 'unique', 'targetAttribute' => ['block_code', 'district_code', 'division_code', 'group_id', 'state_code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'bllock_name' => 'Bllock Name',
        ];
    }
}

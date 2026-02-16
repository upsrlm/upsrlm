<?php

namespace cbo\models\sakhi;

use Yii;

/**
 * This is the model class for table "rishta_shg_profile".
 *
 * @property int|null $cbo_shg_id
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $village_code
 * @property string|null $village_name
 * @property string|null $hamlet
 * @property string|null $name_of_shg
 * @property string|null $shg_code
 * @property string|null $date_of_formation
 * @property int|null $no_of_members
 * @property int|null $cbo_vo_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $dummy_column
 * @property int $status
 */
class DeleteRishtaShgProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rishta_shg_profile';
    }

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
    public function rules()
    {
        return [
            [['cbo_shg_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'no_of_members', 'cbo_vo_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'dummy_column', 'status'], 'integer'],
            [['date_of_formation'], 'safe'],
            [['division_name', 'hamlet', 'name_of_shg'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name', 'village_name'], 'string', 'max' => 125],
            [['shg_code'], 'string', 'max' => 50],
            [['cbo_shg_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cbo_shg_id' => 'SHG ID',
            'division_code' => 'Division Code',
            'division_name' => 'प्रभाग का नाम',
            'district_code' => 'District Code',
            'district_name' => 'जिला',
            'block_code' => 'Block Code',
            'block_name' => 'ब्लाक',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'ग्राम पंचायत',
            'village_code' => 'Village Code',
            'village_name' => 'ग्राम',
            'hamlet' => 'उपग्राम',
            'name_of_shg' => 'SHG का नाम',
            'shg_code' => 'Shg Code',
            'date_of_formation' => 'गठन की तारीख',
            'no_of_members' => 'सदस्यों की संख्या',
            'cbo_vo_id' => 'Cbo Vo ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'dummy_column' => 'Dummy Column',
            'status' => 'Status',
        ];
    }

    /**
     * After Submit SHG Profile Update Name and Number of Member in CBO_SHG Table
     *
     * @param [type] $insert
     * @param [type] $changedAttributes
     * @return void
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->cbo_shg_id) {
            $shg_model = \cbo\models\Shg::findOne($this->cbo_shg_id);
            $shg_model->name_of_shg = $this->name_of_shg;
            $shg_model->no_of_members = $this->no_of_members;
            $shg_model->save(false);
        }
        return parent::afterSave($insert, $changedAttributes);
    }



}

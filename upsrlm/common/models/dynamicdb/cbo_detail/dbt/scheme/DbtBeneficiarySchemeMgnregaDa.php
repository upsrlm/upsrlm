<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;

/**
 * This is the model class for table "dbt_beneficiary_scheme_mgnrega_da".
 *
 * @property int $id
 * @property int|null $mgnrega_scheme_id
 * @property int|null $dbt_beneficiary_household_id
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
 * @property int|null $no_of_applicant
 * @property string|null $demand_aaplication_photo
 * @property int $work_detail_complete
 * @property string|null $work_detail_date
 * @property int|null $work_detail_day
 * @property string|null $work_detail_uploaddate
 * @property int|null $work_detail_upload_by
 * @property int $master_roll_complete
 * @property string|null $master_roll_photo
 * @property string|null $master_roll_photo_uploaddate
 * @property int|null $master_roll_photo_upload_by
 * @property int $fto_complete
 * @property string|null $fto_date
 * @property string|null $fto_uploaddate
 * @property int|null $fto_upload_by
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class DbtBeneficiarySchemeMgnregaDa extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbt_beneficiary_scheme_mgnrega_da';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mgnrega_scheme_id', 'dbt_beneficiary_household_id', 'cbo_shg_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'no_of_applicant', 'work_detail_complete', 'work_detail_day', 'work_detail_upload_by', 'master_roll_complete', 'master_roll_photo_upload_by', 'fto_complete', 'fto_upload_by', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['work_detail_date', 'work_detail_uploaddate', 'master_roll_photo_uploaddate', 'fto_date', 'fto_uploaddate'], 'safe'],
            [['division_name'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name', 'village_name'], 'string', 'max' => 125],
            [['demand_aaplication_photo', 'master_roll_photo'], 'string', 'max' => 500],
            [['master_roll_id', 'work_detail_id', 'fto_id'], 'string', 'max' => 255],
            [['master_roll_complete', 'work_detail_complete', 'fto_complete'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mgnrega_scheme_id' => 'Mgnrega Scheme ID',
            'dbt_beneficiary_household_id' => 'Dbt Beneficiary Household ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_code' => 'Village Code',
            'village_name' => 'Village Name',
            'no_of_applicant' => 'No Of Applicant',
            'demand_aaplication_photo' => 'Demand Aaplication Photo',
            'work_detail_complete' => 'Work Detail Complete',
            'work_detail_date' => 'Work Detail Date',
            'work_detail_day' => 'Work Detail Day',
            'work_detail_uploaddate' => 'Work Detail Uploaddate',
            'work_detail_upload_by' => 'Work Detail Upload By',
            'master_roll_complete' => 'Master Roll Complete',
            'master_roll_photo' => 'Master Roll Photo',
            'master_roll_photo_uploaddate' => 'Master Roll Photo Uploaddate',
            'master_roll_photo_upload_by' => 'Master Roll Photo Upload By',
            'fto_complete' => 'Fto Complete',
            'fto_date' => 'Fto Date',
            'fto_uploaddate' => 'Fto Uploaddate',
            'fto_upload_by' => 'Fto Upload By',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getMgnregascheme()
    {
        return $this->hasOne(DbtBeneficiarySchemeMgnrega::className(), ['id' => 'mgnrega_scheme_id']);
    }
    public function getCboshg()
    {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }

    public function getDemand_aaplication_photo_url()
    {
        return Yii::$app->params['app_url']['ruraldevelopment'] . "/mgnrega/demandapplication/file?application_id=" . $this->id . '&file=demand_aaplication_photo';
    }

    public function getWorkdaylabel()
    {
        $work_day_option = \common\models\base\GenralModel::dbt_mgnrega_work_day_option();
        if (isset($work_day_option[$this->work_detail_day])) {
            return $work_day_option[$this->work_detail_day];
        }
        return '';
    }

    public function getMaster_roll_photo_url()
    {
        return Yii::$app->params['app_url']['ruraldevelopment'] . "/mgnrega/demandapplication/file?application_id=" . $this->id . '&file=master_roll_photo';
    }

    public function getApplicantlist()
    {
        return $this->hasMany(DbtBeneficiarySchemeMgnregaDaApplicant::className(), ['dbt_beneficiary_scheme_mgnrega_da_id' => 'id'])->andWhere(['status' => 1]);
    }
}

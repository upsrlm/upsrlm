<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\training\models\RsetisBatchParticipants;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use common\models\CboMemberProfile;
use yii\base\Model;
use yii\web\UploadedFile;

class AddRsethiCertifiedBCForm extends \yii\base\Model {

    public $id;
    public $first_name;
    public $middle_name;
    public $sur_name;
    public $orig_first_name;
    public $orig_middle_name;
    public $orig_sur_name;
    public $gender = 2;
    public $age;
    public $cast;
    public $application_id;
    public $division_code;
    public $division_name;
    public $district_code;
    public $block_code;
    public $block_name;
    public $gram_panchayat_code;
    public $gram_panchayat_name;
    public $village_code;
    public $village_name;
    public $hamlet;
    public $aadhar_number;
    public $guardian_name;
    public $reading_skills;
    public $mobile_number;
    public $mobile_no;
    public $certificate_code;
    public $orig_otp_mobile_no;
    public $bc_model;
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $cast_option = [];
    public $reading_skills_option = [];

    public function __construct($model = null) {
        if ($model == null) {
            $this->bc_model = new SrlmBcApplication();
        } else {
            $this->bc_model = $model;
            $this->first_name = $this->bc_model->first_name;
            $this->middle_name = $this->bc_model->middle_name;
            $this->sur_name = $this->bc_model->sur_name;
            $this->age = $this->bc_model->age;

            $this->division_code = $this->bc_model->division_code;
            $this->division_name = $this->bc_model->division_name;
            $this->district_code = $this->bc_model->district_code;
            $this->block_code = $this->bc_model->block_code;
            $this->gram_panchayat_code = $this->bc_model->gram_panchayat_code;
            $this->village_code = $this->bc_model->village_code;
            $this->hamlet = $this->bc_model->hamlet;
            $this->cast = $this->bc_model->cast;
            $this->mobile_number = $this->bc_model->mobile_number;
            $this->reading_skills = $this->bc_model->reading_skills;
            $this->guardian_name = $this->bc_model->guardian_name;
        }
        $this->load(\Yii::$app->request->post());
        $this->cast_option = GenralModel::bccostoption();
        $this->reading_skills_option = GenralModel::bcreadingskillsoption();
        $this->district_option = GenralModel::districtoption();

        $this->block_option = GenralModel::blockoption($this);
        if ($this->block_code) {
            $this->gp_option = GenralModel::gpoption($this);
        }
        if ($this->gram_panchayat_code) {
            $this->village_option = GenralModel::villageoption($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['first_name'], 'required'],
            [['first_name'], 'string', 'min' => 3],
            [['first_name', 'middle_name', 'sur_name'], 'trim'],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 100],
            [['age'], 'required'],
            [['age'], 'integer'],
            [['cast'], 'required'],
            [['cast'], 'integer'],
//            [['guardian_name'], 'required'],
            [['guardian_name'], 'trim'],
            [['guardian_name'], 'string', 'max' => 100],
            [['guardian_name'], 'string', 'min' => 3],
            [['mobile_number'], 'required'],
            [['mobile_number'], \common\validators\MobileNoValidator::className()],
            [['mobile_number'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->bc_model->$attribute != $model->$attribute;
                }, 'targetClass' => SrlmBcApplication::className(), 'message' => 'This Mobile Number BC has already been taken', 'targetAttribute' => 'mobile_number'],
            [['mobile_number'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->bc_model->mobile_no != $model->$attribute;
                }, 'targetClass' => SrlmBcApplication::className(), 'message' => 'This Mobile Number BC has already been taken', 'targetAttribute' => 'mobile_no'],
            [['district_code'], 'required'],
            [['district_code'], 'integer'],
            [['block_code'], 'required'],
            [['block_code'], 'integer'],
            [['gram_panchayat_code'], 'required'],
            [['gram_panchayat_code'], 'integer'],
            [['village_code'], 'required'],
            [['village_code'], 'integer'],
            [['hamlet'], 'safe'],
            [['hamlet'], 'trim'],
            [['hamlet'], 'string', 'max' => 100],
            ['certificate_code', 'required'],
            [['certificate_code'], 'trim'],
            [['certificate_code'], 'string', 'max' => 100],
            [['certificate_code'], 'string', 'min' => 8, 'message' => '{attribute} mimimum 8 digit number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'sur_name' => 'Sur Name',
            'gender' => 'Gender',
            'age' => 'Age',
            'cast' => 'Social Category',
            'aadhar_number' => 'Aadhar Number',
            'guardian_name' => 'Guardian Name',
            'reading_skills' => 'Education',
            'mobile_number' => 'Mobile Number',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'village_code' => 'Village',
            'hamlet' => 'Hamlet',
            'certificate_code' => 'IIBF membership No.',
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        $village_model = \bc\models\master\MasterVillage::findOne(['village_code' => $this->village_code]);
        if ($village_model != null) {
            $this->bc_model->first_name = ucfirst(strtolower($this->first_name));
            $this->bc_model->middle_name = ucfirst(strtolower($this->middle_name));
            $this->bc_model->sur_name = ucfirst(strtolower($this->sur_name));
            $this->bc_model->orig_first_name = ucfirst(strtolower($this->first_name));
            $this->bc_model->orig_middle_name = ucfirst(strtolower($this->middle_name));
            $this->bc_model->orig_sur_name = ucfirst(strtolower($this->sur_name));
            $this->bc_model->guardian_name = ucfirst(strtolower($this->guardian_name));
            $this->bc_model->age = $this->age;
            $this->bc_model->gender = $this->gender;
            $this->bc_model->cast = $this->cast;
            $this->bc_model->mobile_number = $this->mobile_number;
            $this->bc_model->district_code = $this->district_code;
            $this->bc_model->block_code = $this->block_code;
            $this->bc_model->gram_panchayat_code = $this->gram_panchayat_code;
            $this->bc_model->village_code = $this->village_code;
            $this->bc_model->hamlet = $this->hamlet;
            $this->bc_model->certificate_code = $this->certificate_code;
            $this->bc_model->created_by = Yii::$app->user->identity->id;
            $this->bc_model->created_at = time();
            $this->bc_model->updated_at = time();
            $this->bc_model->form_status = SrlmBcApplication::FORM_STATUS_PART_4;
            $this->bc_model->form_number = SrlmBcApplication::FORM_STATUS_PART_4;
            $this->bc_model->status = 1;
            $this->bc_model->division_code = $village_model->division_code;
            $this->bc_model->division_name = $village_model->division_name;
            $this->bc_model->district_name = $village_model->district_name;
            $this->bc_model->block_name = $village_model->block_name;
            $this->bc_model->gram_panchayat_name = $village_model->gram_panchayat_name;
            $this->bc_model->village_name = $village_model->village_name;
            $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_ADD_BC_CERTIFIED_RSETI;
            if ($this->bc_model->save()) {
                $this->bc_model->application_id = 'UPBC' . \common\helpers\Utility::add_leading_zero($this->bc_model->id, 6);
                $this->bc_model->update();
                return $this->bc_model;
            } else {
                
            }
        } else {
            return false;
        }

        return $this->bc_model;
    }

}

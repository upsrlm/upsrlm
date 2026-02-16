<?php

namespace bc\models\form;

use Yii;
use bc\models\PartnerAssociates;
use bc\models\PartnerAssociatesBlock;
use bc\models\master\MasterPartnerBank;
use bc\models\master\MasterPartnerBankDistrict;
use bc\modules\selection\models\base\GenralModel;
use yii\base\Model;
use yii\web\UploadedFile;

class PartnerAssociatesForm extends \yii\base\Model {

    public $id;
    public $master_partner_bank_id;
    public $name_of_the_field_officer;
    public $gender;
    public $date_of_birth;
    public $age;
    public $photo_profile;
    public $designation;
    public $mobile_no;
    public $alternate_mobile_no;
    public $whatsapp_no;
    public $email_id;
    public $photo_aadhaar_front;
    public $photo_aadhaar_back;
    public $company_letter;
    public $name_of_supervisor;
    public $designation_of_supervisor;
    public $mobile_no_of_supervisor;
    public $bank_name;
    public $bank_branch;
    public $bank_ifsc_code;
    public $bank_account_number;
    public $created_by;
    public $created_at;
    public $updated_by;
    public $updated_at;
    public $status;
    public $district_code;
    public $block_code;
    public $block_option = [];
    public $district_option = [];
    public $associates_model;
    public $associates_db_model;

    public function __construct($model = null) {

        $this->associates_model = new PartnerAssociates();

        $this->load(\Yii::$app->request->post());

        if ($model != null) {
            $this->associates_model = $model;
            $this->master_partner_bank_id = $this->associates_model->master_partner_bank_id;
            $this->name_of_the_field_officer = $this->associates_model->name_of_the_field_officer;
            $this->gender = $this->associates_model->gender;
            $this->date_of_birth = $this->associates_model->date_of_birth;
            $this->age = $this->associates_model->age;
            $this->photo_profile = $this->associates_model->photo_profile;
            $this->designation = $this->associates_model->designation;
            $this->mobile_no = $this->associates_model->mobile_no;
            $this->alternate_mobile_no = $this->associates_model->alternate_mobile_no;
            $this->whatsapp_no = $this->associates_model->whatsapp_no;
            $this->email_id = $this->associates_model->email_id;
            $this->photo_aadhaar_front = $this->associates_model->photo_aadhaar_front;
            $this->photo_aadhaar_back = $this->associates_model->photo_aadhaar_back;
            $this->company_letter = $this->associates_model->company_letter;
            $this->name_of_supervisor = $this->associates_model->name_of_supervisor;
            $this->designation_of_supervisor = $this->associates_model->designation_of_supervisor;
            $this->mobile_no_of_supervisor = $this->associates_model->mobile_no_of_supervisor;
            $this->bank_name = $this->associates_model->bank_name;
            $this->bank_branch = $this->associates_model->bank_branch;
            $this->bank_ifsc_code = $this->associates_model->bank_ifsc_code;
            $dis = \yii\helpers\ArrayHelper::getColumn($this->associates_model->disblock, 'district_code');
            $this->district_code = isset($dis) ? $dis : '';
            $this->block_code = \yii\helpers\ArrayHelper::getColumn($this->associates_model->disblock, 'block_code');
//            print_r($this->block_code);exit;

            $this->bank_account_number = $this->associates_model->bank_account_number;
        }
        $this->district_option = GenralModel::districtoption();

        $this->block_option = GenralModel::blockoption($this);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name_of_the_field_officer', 'age', 'designation', 'mobile_no', 'alternate_mobile_no', 'whatsapp_no'], 'required'],
            [['name_of_the_field_officer', 'age', 'designation', 'mobile_no', 'alternate_mobile_no', 'whatsapp_no'], 'required'],
            [['name_of_supervisor', 'designation_of_supervisor', 'mobile_no_of_supervisor', 'bank_account_number', 'district_code', 'block_code'], 'required'],
            [['photo_profile', 'photo_aadhaar_front', 'photo_aadhaar_back', 'company_letter'], 'required', 'on' => ['create']],
            [['photo_profile', 'photo_aadhaar_front'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'wrongExtension' => 'Only jpg,jpeg,png,gif files are allowed'],
            [['photo_profile', 'photo_aadhaar_front'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
            [['photo_aadhaar_back'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'wrongExtension' => 'Only jpg,jpeg,png,gif files are allowed'],
            [['photo_aadhaar_back'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
            [['company_letter'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'wrongExtension' => 'Only jpg,jpeg,png,gif files are allowed'],
            [['company_letter'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
            [['email_id', 'name_of_supervisor', 'designation_of_supervisor', 'mobile_no_of_supervisor', 'bank_account_number', 'whatsapp_no'], 'required'],
            [['master_partner_bank_id', 'gender', 'age', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['mobile_no'], \common\validators\MobileNoValidator::className(), 'message' => 'Invalid Mobile No'],
            [['alternate_mobile_no'], \common\validators\MobileNoValidator::className(), 'message' => 'Invalid Mobile No'],
            [['whatsapp_no'], \common\validators\MobileNoValidator::className(), 'message' => 'Invalid Whatsapp No'],
            [['mobile_no_of_supervisor'], \common\validators\MobileNoValidator::className(), 'message' => 'Invalid Mobile No'],
            [['name_of_the_field_officer', 'photo_profile', 'email_id', 'photo_aadhaar_front', 'photo_aadhaar_back', 'company_letter', 'name_of_supervisor', 'bank_branch'], 'string', 'max' => 255],
            [['designation', 'designation_of_supervisor', 'bank_name'], 'string', 'max' => 100],
            [['mobile_no', 'alternate_mobile_no'], 'string', 'max' => 12],
            [['whatsapp_no'], 'string', 'max' => 10],
            [['mobile_no_of_supervisor'], 'string', 'max' => 15],
            [['bank_ifsc_code'], 'string', 'max' => 11],
            [['bank_account_number'], 'string', 'max' => 20],
            ['block_code', 'each', 'rule' => ['integer', 'skipOnEmpty' => false]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_partner_bank_id' => 'Master Bank ID',
            'name_of_the_field_officer' => 'Name Of The Field Officer',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'age' => 'Age',
            'photo_profile' => 'Photo Profile',
            'designation' => 'Designation',
            'mobile_no' => 'Mobile No',
            'alternate_mobile_no' => 'Alternate Mobile No',
            'whatsapp_no' => 'Whatsapp No',
            'email_id' => 'Email ID',
            'photo_aadhaar_front' => 'Photo Aadhaar Front',
            'photo_aadhaar_back' => 'Photo Aadhaar Back',
            'company_letter' => 'Company Letter',
            'name_of_supervisor' => 'Name Of Supervisor',
            'designation_of_supervisor' => 'Designation Of Supervisor',
            'mobile_no_of_supervisor' => 'Mobile No Of Supervisor',
            'bank_name' => 'Bank Name',
            'bank_branch' => 'Bank Branch',
            'bank_ifsc_code' => 'Bank Ifsc Code',
            'bank_account_number' => 'Bank Account Number',
            'district_code' => 'District code',
            'block_code' => 'Block',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        $user_model=\Yii::$app->user->identity;
        try {
            $this->photo_profile = UploadedFile::getInstance($this, 'photo_profile');
            $this->photo_aadhaar_front = UploadedFile::getInstance($this, 'photo_aadhaar_front');
            $this->photo_aadhaar_back = UploadedFile::getInstance($this, 'photo_aadhaar_back');
            $this->company_letter = UploadedFile::getInstance($this, 'company_letter');
            $this->associates_model->name_of_the_field_officer = $this->name_of_the_field_officer;
            $this->associates_model->gender = $this->gender;
            $this->associates_model->age = $this->age;
            $this->associates_model->designation = $this->designation;
            $this->associates_model->mobile_no = $this->mobile_no;
            $this->associates_model->alternate_mobile_no = $this->alternate_mobile_no;
            $this->associates_model->whatsapp_no = $this->whatsapp_no;
            $this->associates_model->email_id = $this->email_id;
            $this->associates_model->name_of_supervisor = $this->name_of_supervisor;
            $this->associates_model->designation_of_supervisor = $this->designation_of_supervisor;
            $this->associates_model->mobile_no_of_supervisor = $this->mobile_no_of_supervisor;
            $this->associates_model->bank_name = $this->bank_name;
            $this->associates_model->bank_branch = $this->bank_branch;
            $this->associates_model->bank_ifsc_code = $this->bank_ifsc_code;
            $this->associates_model->bank_account_number = $this->bank_account_number;
            $this->associates_model->master_partner_bank_id = $user_model->master_partner_bank_id;
//            if ($this->district_code) {
//                $bank_model = MasterPartnerBankDistrict::find()->where(['district_code' => $this->district_code])->one();
//                $this->associates_model->master_partner_bank_id = $user_model->master_partner_bank_id;
//            }

            if ($this->associates_model->save()) {
                $FOLDER = Yii::$app->params['datapath'] . 'partneragencies/';
                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
                $FOLDER = $FOLDER . 'associates' . '/';
                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
                $FOLDER = $FOLDER . $this->associates_model->id . '/';
                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
                if ($this->photo_profile != null) {
                    $tmp1_file_name = 'photo_profile_' . time() . "_" . $this->photo_profile->name;

                    $this->photo_profile->saveAs($FOLDER . '/' . $tmp1_file_name);
                    chmod($FOLDER . '/' . $tmp1_file_name, 0777);
                    $this->associates_model->photo_profile = $tmp1_file_name;
                    $this->associates_model->update();
                }
                if ($this->photo_aadhaar_front != null) {
                    $tmp2_file_name = 'photo_aadhaar_front_' . time() . "_" . $this->photo_aadhaar_front->name;
                    $this->photo_aadhaar_front->saveAs($FOLDER . '/' . $tmp2_file_name);
                    chmod($FOLDER . '/' . $tmp2_file_name, 0777);
                    $this->associates_model->photo_aadhaar_front = $tmp2_file_name;
                    $this->associates_model->update();
                }
                if ($this->photo_aadhaar_back != null) {
                    $tmp3_file_name = 'photo_aadhaar_back_' . time() . "_" . $this->photo_aadhaar_back->name;
                    $this->photo_aadhaar_back->saveAs($FOLDER . '/' . $tmp3_file_name);
                    chmod($FOLDER . '/' . $tmp3_file_name, 0777);
                    $this->associates_model->photo_aadhaar_back = $tmp3_file_name;
                    $this->associates_model->update();
                }
                if ($this->company_letter != null) {
                    $tmp4_file_name = 'company_letter_' . time() . "_" . $this->company_letter->name;

                    $this->company_letter->saveAs($FOLDER . '/' . $tmp4_file_name);
                    chmod($FOLDER . '/' . $tmp4_file_name, 0777);
                    $this->associates_model->company_letter = $tmp4_file_name;
                    $this->associates_model->update();
                }
                $condition = ['and',
                    ['=', 'partner_associates_id', $this->associates_model->id,],
                    ['!=', 'status', -1],
                ];
                PartnerAssociatesBlock::updateAll([
                    'status' => 0,
                        ], $condition);
                foreach ($this->block_code as $blockcode) {
                    if ($blockcode) {
                        $assblock = PartnerAssociatesBlock::find()->where(['partner_associates_id' => $this->associates_model->id, 'block_code' => $blockcode])->one();
                        if ($assblock == null) {
                            $assblock = new PartnerAssociatesBlock();
                        }
                        $assblock->partner_associates_id = $this->associates_model->id;
                        $assblock->block_code = $blockcode;
                        $dismodel = \bc\models\master\MasterBlock::findOne(['block_code' => $blockcode]);
                        $assblock->district_code = isset($dismodel) ? $dismodel->district_code : 0;

                        $assblock->status = 1;
                        $assblock->save();
                    }
                }
            }

            return $this;
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }
    }

}

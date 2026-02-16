<?php

namespace app\modules\shg\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\UserModel;
use common\models\master\MasterRole;
use cbo\models\Shg;
use common\models\base\GenralModel;
use yii\web\UploadedFile;

/**
 * ShgForm is the model behind the Shg
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ShgForm extends \yii\base\Model {

    public $id;
    public $division_code;
    public $division_name;
    public $district_code;
    public $district_name;
    public $block_code;
    public $block_name;
    public $gram_panchayat_code;
    public $gram_panchayat_name;
    public $village_code;
    public $village_name;
    public $hamlet;
    public $name_of_shg;
    public $shg_code;
    public $no_of_members;
    public $chaire_person_name;
    public $chaire_person_mobile_no;
    public $secretary_name;
    public $secretary_mobile_no;
    public $treasurer_name;
    public $treasurer_mobile_no;
    public $bank_account_no_of_the_shg;
    public $bank_id;
    public $name_of_bank;
    public $branch;
    public $branch_code_or_ifsc;
    public $date_of_opening_the_bank_account;
    public $passbook_photo;
    public $return;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $bank_option = [];
    public $shg_model;

    public function __construct($shg_model = null) {
        $this->block_option = GenralModel::blockopption($this);
        $this->district_option = GenralModel::nfsaoptiondistrict($this);
        $this->gp_option = GenralModel::nfsaoptiongp($this);
        $this->bank_option = \common\models\base\GenralModel::cbo_bank_option($this);
        $this->return = 0;
        $this->village_option = GenralModel::optionvillage($this);
        $this->shg_model = Yii::createObject([
                    'class' => Shg::className()
        ]);
        if ($shg_model != null) {
            $this->shg_model = $shg_model;
            $this->division_code = $this->shg_model->division_code;
            $this->division_name = $this->shg_model->division_name;
            $this->district_code = $this->shg_model->district_code;
            $this->district_name = $this->shg_model->district_name;
            $this->block_code = $this->shg_model->block_code;
            $this->gram_panchayat_code = $this->shg_model->gram_panchayat_code;
            $this->gram_panchayat_name = $this->shg_model->gram_panchayat_name;
            $this->village_code = $this->shg_model->village_code;
            $this->village_name = $this->shg_model->village_name;
            $this->hamlet = $this->shg_model->hamlet;
            $this->name_of_shg = $this->shg_model->name_of_shg;
            $this->shg_code = $this->shg_model->shg_code;
            $this->no_of_members = $this->shg_model->no_of_members;
            $this->chaire_person_name = $this->shg_model->chaire_person_name;
            $this->chaire_person_mobile_no = $this->shg_model->chaire_person_mobile_no;
            $this->secretary_name = $this->shg_model->secretary_name;
            $this->secretary_mobile_no = $this->shg_model->secretary_mobile_no;
            $this->treasurer_name = $this->shg_model->treasurer_name;
            $this->treasurer_mobile_no = $this->shg_model->treasurer_mobile_no;

            $this->bank_account_no_of_the_shg = $this->shg_model->bank_account_no_of_the_shg;
            $this->bank_id = $this->shg_model->bank_id;
            $this->name_of_bank = $this->shg_model->name_of_bank;
            $this->branch = $this->shg_model->branch;
            $this->branch_code_or_ifsc = $this->shg_model->branch_code_or_ifsc;
            $this->date_of_opening_the_bank_account = $this->shg_model->date_of_opening_the_bank_account != null ? \Yii::$app->formatter->asDatetime($this->shg_model->date_of_opening_the_bank_account, "php:d-m-Y") : "";

            $this->passbook_photo = $this->shg_model->passbook_photo;
        }
    }

    public function rules() {
        return [
            [['gram_panchayat_code', 'village_code'], 'required'],
            [['gram_panchayat_code'], \common\validators\SHGBCValidator::className()],
            [['hamlet', 'name_of_shg', 'no_of_members', 'chaire_person_mobile_no', 'chaire_person_name', 'secretary_name', 'treasurer_name', 'treasurer_mobile_no', 'secretary_mobile_no'], 'required'],
            [['name_of_shg'], 'trim'],
//            [['shg_code'], 'required'],
            [['shg_code'], 'string', 'max' => 50],
            [['shg_code'], 'trim'],
            [['shg_code'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->shg_model->$attribute != $model->$attribute;
                }, 'targetClass' => Shg::className(), 'message' => 'This SHG code has already been taken'],
            [['chaire_person_mobile_no', 'treasurer_mobile_no', 'secretary_mobile_no'], \app\modules\shg\components\validators\MobleNoValidator::class],
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'no_of_members', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['division_name', 'hamlet', 'name_of_shg'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name', 'village_name'], 'string', 'max' => 125],
            [['chaire_person_name', 'secretary_name', 'treasurer_name'], 'string', 'max' => 60],
            [['chaire_person_mobile_no', 'treasurer_mobile_no', 'secretary_mobile_no'], 'string', 'max' => 10],
            [['chaire_person_mobile_no', 'treasurer_mobile_no', 'secretary_mobile_no'], 'checkMobileNumber'],
            ['no_of_members', 'integer', 'min' => 0, 'max' => 99],
            [['bank_account_no_of_the_shg', 'bank_id', 'branch', 'branch_code_or_ifsc', 'date_of_opening_the_bank_account'], 'required', 'on' => ['admincreate']],
            [['bank_account_no_of_the_shg', 'bank_id', 'branch', 'branch_code_or_ifsc', 'date_of_opening_the_bank_account'], 'required', 'on' => ['adminupdate']],
            [['bank_account_no_of_the_shg', 'bank_id', 'branch', 'branch_code_or_ifsc', 'date_of_opening_the_bank_account'], 'trim'],
            [['bank_id', 'return'], 'integer'],
            [['date_of_opening_the_bank_account'], 'safe'],
            [['bank_account_no_of_the_shg', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['name_of_bank', 'branch'], 'string', 'max' => 150],
            ['return', 'default', 'value' => 0],
            [['passbook_photo'], 'required', 'on' => ['admincreate']],
            [['passbook_photo', 'passbook_photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'wrongExtension' => 'Only jpg,jpeg,png,gif files are allowed'],
            [['passbook_photo', 'passbook_photo'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'division_code' => 'Division',
            'division_name' => 'Division Name',
            'district_code' => 'District',
            'district_name' => 'District Name',
            'block_code' => 'Block',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_code' => 'Village',
            'village_name' => 'Village Name',
            'hamlet' => 'Hamlet',
            'name_of_shg' => 'Name of SHG',
            'shg_code' => 'SHG Code',
            'no_of_members' => 'No. of members',
            'chaire_person_name' => 'Chairperson Name',
            'chaire_person_mobile_no' => 'Chairperson Mobile No',
            'secretary_name' => 'Secretary Name',
            'secretary_mobile_no' => 'Secretary Mobile No',
            'treasurer_name' => 'Treasurer Name',
            'treasurer_mobile_no' => 'Treasurer Mobile No',
            'bank_account_no_of_the_shg' => 'Bank Account No Of The Shg',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'passbook_photo' => 'Passbook Photo',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        $this->passbook_photo = UploadedFile::getInstance($this, 'passbook_photo');
        $this->shg_model->gram_panchayat_code = $this->gram_panchayat_code;
        $this->shg_model->village_code = $this->village_code;
        $this->shg_model->hamlet = $this->hamlet;
        $this->shg_model->name_of_shg = $this->name_of_shg;
        $this->shg_model->shg_code = $this->shg_code;
        $this->shg_model->no_of_members = $this->no_of_members;
        $this->shg_model->chaire_person_name = $this->chaire_person_name;
        $this->shg_model->chaire_person_mobile_no = $this->chaire_person_mobile_no;
        $this->shg_model->secretary_name = $this->secretary_name;
        $this->shg_model->secretary_mobile_no = $this->secretary_mobile_no;
        $this->shg_model->treasurer_name = $this->treasurer_name;
        $this->shg_model->treasurer_mobile_no = $this->treasurer_mobile_no;
        $this->shg_model->dummy_column = \Yii::$app->user->identity->dummy_column;

        $this->shg_model->bank_account_no_of_the_shg = $this->bank_account_no_of_the_shg;
        $this->shg_model->bank_id = $this->bank_id;
        $this->shg_model->branch = $this->branch;
        $this->shg_model->branch_code_or_ifsc = $this->branch_code_or_ifsc;
        $this->shg_model->date_of_opening_the_bank_account = $this->date_of_opening_the_bank_account;
        $this->shg_model->return = $this->return;
        $this->shg_model->last_updated_by = \Yii::$app->user->identity->id;
        $this->shg_model->last_updated_at = time();
        if ($this->shg_model->save()) {
            $FOLDER = Yii::$app->params['datapath'] . 'cbo/';
            if (!file_exists($FOLDER)) {
                mkdir($FOLDER);
                chmod($FOLDER, 0777);
            }
            $FOLDER = $FOLDER . 'shg' . '/';
            if (!file_exists($FOLDER)) {
                mkdir($FOLDER);
                chmod($FOLDER, 0777);
            }
            if ($this->passbook_photo != null) {
                $tmp_file_name = $this->passbook_photo->name . date("Y_m_d_H-m-s") . "." . $this->passbook_photo->extension;
                $FOLDER = $FOLDER . $this->shg_model->id . '/';
                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
                $this->passbook_photo->saveAs($FOLDER . '/' . $tmp_file_name);
                chmod($FOLDER . '/' . $tmp_file_name, 0777);
                $this->shg_model->passbook_photo = $tmp_file_name;
                $this->shg_model->update();
            }
        } else {
            print_r($this->shg_model->errors);
        }
    }

    public function checkMobileNumber($attribute, $params) {

        if ($attribute == "chaire_person_mobile_no") {
            if (strcmp($this->chaire_person_mobile_no, $this->secretary_mobile_no) && strcmp($this->chaire_person_mobile_no, $this->treasurer_mobile_no)) {
                
            } else {
                $this->addError($attribute, "Mobile Number repeat");
            }
        } else if ($attribute == "secretary_mobile_no") {
            if (strcmp($this->secretary_mobile_no, $this->chaire_person_mobile_no) && strcmp($this->secretary_mobile_no, $this->treasurer_mobile_no)) {
                
            } else {
                $this->addError($attribute, "Mobile Number repeat");
            }
        } else if ($attribute == "treasurer_mobile_no") {
            if (strcmp($this->treasurer_mobile_no, $this->chaire_person_mobile_no) && strcmp($this->treasurer_mobile_no, $this->secretary_mobile_no)) {
                
            } else {
                $this->addError($attribute, "Mobile Number repeat");
            }
        }
    }

}

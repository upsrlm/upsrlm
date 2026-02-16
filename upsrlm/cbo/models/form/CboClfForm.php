<?php

namespace cbo\models\form;

use Yii;
use cbo\models\CboClf;
use cbo\models\CboClfFunds;
use cbo\models\CboClfMembers;
use cbo\models\form\CboClfMembersForm;
use cbo\models\form\CboClfFundsForm;
use yii\base\Model;
use yii\web\UploadedFile;
use common\helpers\FileHelpers;

/**
 * CboClfForm is the model behind the CboClf
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CboClfForm extends \yii\base\Model {

    public $id;
    public $block_code;
    public $name_of_clf;
    public $nrlm_clf_code;
    public $date_of_formation;
    public $no_of_vo_connected;
    public $no_of_shg_connected;
    public $no_of_gps_covered;
    public $funds_received_so_far;
    public $bank_account_no_of_the_clf;
    public $name_of_bank;
    public $bank_id;
    public $branch;
    public $branch_code_or_ifsc;
    public $date_of_opening_the_bank_account;
    public $passbook_photo;
    public $updated_balance_in_bank_date;
    public $updated_balance_in_bank;
    public $bank_account_no_of_the_clf2;
    public $name_of_bank2;
    public $bank_id2;
    public $branch2;
    public $branch_code_or_ifsc2;
    public $date_of_opening_the_bank_account2;
    public $passbook_photo2;
    public $updated_balance_in_bank_date2;
    public $updated_balance_in_bank2;
    public $accountant_name;
    public $accountant_number;
    public $more_bank;
    public $is_registered_under;
    public $reg_no;
    public $pan_no;
    public $pan_photo;
    public $registration_document_photo;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $clf_model;
    public $members_model;
    public $funds_model;
    public $member_role_option = [];
    public $bank_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $funds_type_option = [];
    public $remove_file;

    const MEMBER_ROW_INIT = 15;

    public function __construct($clf_model = null) {
        $this->clf_model = new CboClf();
        $this->load(\Yii::$app->request->post());
        if ($clf_model != null) {
            $this->clf_model = $clf_model;
            $this->block_code = $this->clf_model->block_code;
            $this->name_of_clf = $this->clf_model->name_of_clf;
            $this->nrlm_clf_code = $this->clf_model->nrlm_clf_code;
            $this->date_of_formation = $this->clf_model->date_of_formation != null ? \Yii::$app->formatter->asDatetime($this->clf_model->date_of_formation, "php:d-m-Y") : "";
            $this->no_of_vo_connected = $this->clf_model->no_of_vo_connected;
            $this->no_of_shg_connected = $this->clf_model->no_of_shg_connected;
            $this->no_of_gps_covered = $this->clf_model->no_of_gps_covered;
            $this->funds_received_so_far = $this->clf_model->funds_received_so_far;
            $this->bank_account_no_of_the_clf = $this->clf_model->bank_account_no_of_the_clf;
            $this->name_of_bank = $this->clf_model->name_of_bank;
            $this->bank_id = $this->clf_model->bank_id;
            $this->branch = $this->clf_model->branch;
            $this->branch_code_or_ifsc = $this->clf_model->branch_code_or_ifsc;
            $this->date_of_opening_the_bank_account = $this->clf_model->date_of_opening_the_bank_account != null ? \Yii::$app->formatter->asDatetime($this->clf_model->date_of_opening_the_bank_account, "php:d-m-Y") : "";
            $this->updated_balance_in_bank = $this->clf_model->updated_balance_in_bank;
            $this->updated_balance_in_bank_date = $this->clf_model->updated_balance_in_bank_date != null ? \Yii::$app->formatter->asDatetime($this->clf_model->updated_balance_in_bank_date, "php:d-m-Y") : "";
            $this->passbook_photo = $this->clf_model->passbook_photo;
            $this->bank_account_no_of_the_clf2 = $this->clf_model->bank_account_no_of_the_clf2;
            $this->name_of_bank2 = $this->clf_model->name_of_bank2;
            $this->bank_id2 = $this->clf_model->bank_id2;
            $this->branch2 = $this->clf_model->branch2;
            $this->branch_code_or_ifsc2 = $this->clf_model->branch_code_or_ifsc2;
            $this->date_of_opening_the_bank_account2 = $this->clf_model->date_of_opening_the_bank_account2 != null ? \Yii::$app->formatter->asDatetime($this->clf_model->date_of_opening_the_bank_account2, "php:d-m-Y") : "";
            $this->updated_balance_in_bank2 = $this->clf_model->updated_balance_in_bank2;
            $this->updated_balance_in_bank_date2 = $this->clf_model->updated_balance_in_bank_date2 != null ? \Yii::$app->formatter->asDatetime($this->clf_model->updated_balance_in_bank_date2, "php:d-m-Y") : "";
            $this->passbook_photo2 = $this->clf_model->passbook_photo2;
            $this->accountant_name = $this->clf_model->accountant_name;
            $this->accountant_number = $this->clf_model->accountant_number;
            $this->is_registered_under = $this->clf_model->is_registered_under;
            $this->registration_document_photo = $this->clf_model->registration_document_photo;
        }
        $this->bank_option = \common\models\base\GenralModel::cbo_bank_option($this);
        $this->member_role_option = \common\models\base\GenralModel::cbo_member_role_option($this);
        $this->block_option = \common\models\base\GenralModel::srlmblockopption($this);
        $this->funds_type_option = \common\models\base\GenralModel::cbo_funds_type_option('clf');
        $this->members_model[] = new CboClfMembersForm();
        for ($x = 0; $x <= self::MEMBER_ROW_INIT; $x++) {
            $this->members_model[$x] = new CboClfMembersForm();
        }
        if (isset($this->clf_model->members)) {
            foreach ($this->clf_model->members as $key => $member) {
                $this->members_model[$key] = new CboClfMembersForm();
                $this->members_model[$key]->id = $member->id;
                $this->members_model[$key]->cbo_clf_id = $member->cbo_clf_id;
                $this->members_model[$key]->name = $member->name;
                $this->members_model[$key]->mobile_no = $member->mobile_no;
                $this->members_model[$key]->role = $member->role;
                $this->members_model[$key]->bank_operator = $member->bank_operator;
            }
        }
        $this->funds_model[] = new CboClfFundsForm();
        foreach ($this->funds_type_option as $key => $value) {

            $this->funds_model[$key - 1] = new CboClfFundsForm();
            if (isset($this->clf_model->funds)) {
                $funds = CboClfFunds::find()->where(['cbo_clf_id' => $this->clf_model->id, 'fund_type' => $key])->one();
                if ($funds != null) {
                    $this->funds_model[$key - 1]->id = $funds->id;
                    $this->funds_model[$key - 1]->get_funds = $funds->get_funds;
                    $this->funds_model[$key - 1]->cbo_clf_id = $funds->cbo_clf_id;
                    $this->funds_model[$key - 1]->date_of_receipt = $funds->date_of_receipt != null ? \Yii::$app->formatter->asDatetime($funds->date_of_receipt, "php:d-m-Y") : "";
                    $this->funds_model[$key - 1]->instalment_if_any = $funds->instalment_if_any;
                    $this->funds_model[$key - 1]->total_amount_received = $funds->total_amount_received;
                    $this->funds_model[$key - 1]->balance_as_on_date = $funds->balance_as_on_date;
                }
            }
            $this->funds_model[$key - 1]->fund_type = $key;
            $this->funds_model[$key - 1]->type_name = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['no_of_vo_connected', 'no_of_shg_connected', 'no_of_gps_covered', 'bank_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['block_code'], 'required'],
            [['nrlm_clf_code'], 'required'],
            [['is_registered_under'], 'required'],
            [['name_of_clf', 'date_of_formation', 'no_of_vo_connected', 'no_of_shg_connected', 'no_of_gps_covered'], 'required'],
            [['bank_account_no_of_the_clf', 'bank_id', 'branch', 'branch_code_or_ifsc', 'branch_code_or_ifsc', 'date_of_opening_the_bank_account'], 'required'],
            [['date_of_formation', 'date_of_opening_the_bank_account', 'date_of_opening_the_bank_account2'], 'safe'],
            [['name_of_clf', 'name_of_bank', 'branch', 'name_of_bank2', 'branch2'], 'string', 'max' => 150],
            [['bank_account_no_of_the_clf', 'branch_code_or_ifsc', 'bank_account_no_of_the_clf2', 'branch_code_or_ifsc2'], 'string', 'max' => 25],
            [['name_of_clf'], 'trim'],
            [['no_of_vo_connected'], 'trim'],
            [['no_of_shg_connected'], 'trim'],
            [['no_of_gps_covered'], 'trim'],
            [['date_of_formation'], 'trim'],
            [['date_of_opening_the_bank_account', 'date_of_opening_the_bank_account2'], 'trim'],
            [['bank_account_no_of_the_clf', 'bank_account_no_of_the_clf2'], 'trim'],
            [['branch_code_or_ifsc', 'branch_code_or_ifsc2'], 'trim'],
            [['branch', 'branch2'], 'trim'],
            [['nrlm_clf_code'], 'trim'],
            [['passbook_photo'], 'safe', 'on' => ['create']],
            [['passbook_photo2'], 'safe'],
            [['registration_document_photo'], 'safe'],
            [['remove_file'], 'safe'],
            [['bank_account_no_of_the_clf2', 'bank_id2', 'updated_balance_in_bank_date', 'updated_balance_in_bank_date2', 'updated_balance_in_bank2'], 'safe'],
            [['updated_balance_in_bank'], 'number'],
            [['updated_balance_in_bank_date'], 'required'],
            [['updated_balance_in_bank'], 'required'],
            ['passbook_photo', 'required', 'when' => function ($model) {
                    return $model->remove_file == 1;
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#remove_file').val() == '1';
            }"],
            [['passbook_photo', 'passbook_photo2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'wrongExtension' => 'Only jpg,jpeg,png,gif files are allowed'],
            [['passbook_photo', 'passbook_photo2'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
            [['registration_document_photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'wrongExtension' => 'Only jpg,jpeg,png,gif files are allowed'],
            [['registration_document_photo'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
            [['funds_received_so_far'], 'safe'],
            [['accountant_name', 'accountant_number'], 'safe', 'on' => ['create']],
            [['accountant_name'], 'string', 'max' => 150],
            [['accountant_number'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'block_code' => 'Block',
            'name_of_clf' => 'Name Of CLF',
            'nrlm_clf_code' => 'NRLM CLF Code',
            'date_of_formation' => 'Date Of Formation',
            'no_of_vo_connected' => 'No. of VO Connected',
            'no_of_shg_connected' => 'No Of Shg Connected',
            'no_of_gps_covered' => "No. Of GP's Covered",
            'bank_account_no_of_the_clf' => 'Bank Account No Of The CLF',
            'name_of_bank' => 'Name Of Bank',
            'bank_id' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'updated_balance_in_bank' => "Current CLF bank balance",
            'updated_balance_in_bank_date' => "CLF bank balance date",
            'registration_document_photo' => 'पंजीकरण के दस्तावेज की स्कैन कॉपी',
            'is_registered_under' => 'क्या संकुल/ CLF पंजीकृत है?',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {

        try {
            $this->passbook_photo = UploadedFile::getInstance($this, 'passbook_photo');
            $this->passbook_photo2 = UploadedFile::getInstance($this, 'passbook_photo2');
            $this->registration_document_photo = UploadedFile::getInstance($this, 'registration_document_photo');
            $this->clf_model->block_code = $this->block_code;
            $this->clf_model->name_of_clf = $this->name_of_clf;
            $this->clf_model->nrlm_clf_code = $this->nrlm_clf_code;
            $this->clf_model->date_of_formation = $this->date_of_formation;
            $this->clf_model->no_of_vo_connected = $this->no_of_vo_connected;
            $this->clf_model->no_of_shg_connected = $this->no_of_shg_connected;
            $this->clf_model->no_of_gps_covered = $this->no_of_gps_covered;
            //$this->clf_model->funds_received_so_far = $this->funds_received_so_far;
            $this->clf_model->bank_account_no_of_the_clf = $this->bank_account_no_of_the_clf;
            $this->clf_model->bank_id = $this->bank_id;
            $this->clf_model->branch = $this->branch;
            $this->clf_model->branch_code_or_ifsc = $this->branch_code_or_ifsc;
            $this->clf_model->date_of_opening_the_bank_account = $this->date_of_opening_the_bank_account;
            $this->clf_model->updated_balance_in_bank = $this->updated_balance_in_bank;
            $this->clf_model->updated_balance_in_bank_date = $this->updated_balance_in_bank_date;
            $this->clf_model->bank_account_no_of_the_clf2 = $this->bank_account_no_of_the_clf2;
            $this->clf_model->bank_id2 = $this->bank_id2;
            $this->clf_model->branch2 = $this->branch2;
            $this->clf_model->branch_code_or_ifsc2 = $this->branch_code_or_ifsc2;
            $this->clf_model->date_of_opening_the_bank_account2 = $this->date_of_opening_the_bank_account2;
            $this->clf_model->updated_balance_in_bank2 = $this->updated_balance_in_bank2;
            $this->clf_model->updated_balance_in_bank_date2 = $this->updated_balance_in_bank_date2;
            $this->clf_model->accountant_name = $this->accountant_name;
            $this->clf_model->accountant_number = $this->accountant_number;
            $this->clf_model->dummy_column = \Yii::$app->user->identity->dummy_column;
            $this->clf_model->is_registered_under = $this->is_registered_under;
            if (isset($_POST['save_b'])) {
                $this->clf_model->status = CboClf::STATUS_SAVE;
            }
            if (isset($_POST['submit_b'])) {
                $this->clf_model->status = CboClf::STATUS_SUBMIT;
            }
            if (!$this->clf_model->validate()) {
                return false;
            }
            if ($this->clf_model->save()) {
                $FOLDER = Yii::$app->params['datapath'] . 'cbo/';
                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
                $FOLDER = $FOLDER . 'clf' . '/';
                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
                $FOLDER = $FOLDER . $this->clf_model->id;
                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
                if ($this->passbook_photo != null) {
                    $tmp1_file_name = 'passbook_photo1_' . time() . "." . $this->passbook_photo->name;

                    $this->passbook_photo->saveAs($FOLDER . '/' . $tmp1_file_name);
                    chmod($FOLDER . '/' . $tmp1_file_name, 0777);
                    $this->clf_model->passbook_photo = $tmp1_file_name;
                    $this->clf_model->update();
                    $file = new FileHelpers();
                    $file->file_path = $FOLDER;
                    $file->file_name = $tmp1_file_name;
                    $file->upload();
                }
                if ($this->passbook_photo2 != null) {
                    $tmp2_file_name = 'passbook_photo2_' . time() . "."  . $this->passbook_photo2->name;

                    $this->passbook_photo2->saveAs($FOLDER . '/' . $tmp2_file_name);
                    chmod($FOLDER . '/' . $tmp2_file_name, 0777);
                    $this->clf_model->passbook_photo2 = $tmp2_file_name;
                    $this->clf_model->update();
                    $file = new FileHelpers();
                    $file->file_path = $FOLDER;
                    $file->file_name = $tmp2_file_name;
                    $file->upload();
                }
                if ($this->registration_document_photo != null) {
                    $tmp3_file_name = 'registration_document_' . time() . "." . $this->registration_document_photo->name;

                    $this->registration_document_photo->saveAs($FOLDER . '/' . $tmp3_file_name);
                    chmod($FOLDER . '/' . $tmp3_file_name, 0777);
                    $this->clf_model->registration_document_photo = $tmp3_file_name;
                    $this->clf_model->update();
                    $file = new FileHelpers();
                    $file->file_path = $FOLDER;
                    $file->file_name = $tmp3_file_name;
                    $file->upload();
                }
                $condition = ['and',
                    ['=', 'cbo_clf_id', $this->clf_model->id,],
                    ['!=', 'status', -1],
                ];
                CboClfFunds::updateAll([
                    'status' => 0,
                        ], $condition);
                foreach ($this->funds_model as $key => $fund) {
                    $cbovofunds = CboClfFunds::find()->where(['cbo_clf_id' => $this->clf_model->id, 'fund_type' => $fund->fund_type])->one();
                    if ($cbovofunds == null) {
                        $cbovofunds = new CboClfFunds();
                    }
                    $cbovofunds->cbo_clf_id = $this->clf_model->id;
                    $cbovofunds->get_funds = $fund->get_funds;
                    $cbovofunds->fund_type = $fund->fund_type;
                    $cbovofunds->date_of_receipt = $fund->date_of_receipt;
                    $cbovofunds->instalment_if_any = $fund->instalment_if_any;
                    $cbovofunds->total_amount_received = $fund->total_amount_received;
                    $cbovofunds->balance_as_on_date = $fund->balance_as_on_date;
                    $cbovofunds->status = 1;
                    if ($fund->get_funds) {
                        $cbovofunds->save();
                    }
                }
                foreach ($this->members_model as $key => $member) {
                    $cboclfmember = CboClfMembers::find()->where(['id' => $member->id])->one();
                    if ($cboclfmember == null) {
                        $cboclfmember = new CboClfMembers();
                    }
                    $cboclfmember->cbo_clf_id = $this->clf_model->id;
                    $cboclfmember->name = $member->name;
                    $cboclfmember->mobile_no = $member->mobile_no;
                    $cboclfmember->role = $member->role;
                    $cboclfmember->bank_operator = $member->bank_operator;
                    $cboclfmember->status = 1;
                    if ($cboclfmember->name) {
                        $cboclfmember->save();
                    }
                }
                $this->clf_model->save();
            }

            return $this;
        } catch (\Exception $ex) {
            print_r($ex->getMessage());exit;
        }
    }

}

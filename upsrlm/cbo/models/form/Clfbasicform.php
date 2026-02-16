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
class Clfbasicform extends \yii\base\Model {

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
    public $bank_account_no_of_the_clf3;
    public $name_of_bank3;
    public $bank_id3;
    public $branch3;
    public $branch_code_or_ifsc3;
    public $date_of_opening_the_bank_account3;
    public $passbook_photo3;
    public $updated_balance_in_bank_date3;
    public $updated_balance_in_bank3;
    public $more_bank;
    public $is_registered_under;
    public $reg_no;
    public $pan_no;
    public $pan_photo;
    public $accountant_name;
    public $accountant_number;
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
            $this->block_option = \yii\helpers\ArrayHelper::map(\common\models\master\MasterBlock::find()->where(['block_code' => $this->clf_model->block_code])->all(), 'block_code', 'block_name');
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

            $this->bank_account_no_of_the_clf3 = $this->clf_model->bank_account_no_of_the_clf3;
            $this->name_of_bank3 = $this->clf_model->name_of_bank3;
            $this->bank_id3 = $this->clf_model->bank_id3;
            $this->branch3 = $this->clf_model->branch3;
            $this->branch_code_or_ifsc3 = $this->clf_model->branch_code_or_ifsc3;
            $this->date_of_opening_the_bank_account3 = $this->clf_model->date_of_opening_the_bank_account3 != null ? \Yii::$app->formatter->asDatetime($this->clf_model->date_of_opening_the_bank_account3, "php:d-m-Y") : "";
            $this->updated_balance_in_bank3 = $this->clf_model->updated_balance_in_bank3;
            $this->updated_balance_in_bank_date3 = $this->clf_model->updated_balance_in_bank_date3 != null ? \Yii::$app->formatter->asDatetime($this->clf_model->updated_balance_in_bank_date3, "php:d-m-Y") : "";
            $this->passbook_photo3 = $this->clf_model->passbook_photo3;
            $this->more_bank = $this->clf_model->more_bank;
            $this->is_registered_under = $this->clf_model->is_registered_under;
            $this->reg_no = $this->clf_model->reg_no;
            $this->pan_no = $this->clf_model->pan_no;
            $this->pan_photo = $this->clf_model->pan_photo;

            $this->accountant_name = $this->clf_model->accountant_name;
            $this->accountant_number = $this->clf_model->accountant_number;
        }
        $this->bank_option = \common\models\base\GenralModel::cbo_bank_option($this);
        $this->member_role_option = \common\models\base\GenralModel::cbo_member_role_option($this);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['no_of_vo_connected', 'no_of_shg_connected', 'no_of_gps_covered', 'bank_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['block_code'], 'required'],
            [['nrlm_clf_code'], 'required'],
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
            [['passbook_photo3'], 'safe'],
            [['pan_photo'], 'safe'],
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
            [['passbook_photo', 'passbook_photo2', 'passbook_photo3', 'pan_photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'wrongExtension' => 'Only jpg,jpeg,png,gif files are allowed'],
            [['passbook_photo', 'passbook_photo2', 'passbook_photo3', 'pan_photo'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
            [['funds_received_so_far'], 'safe'],
            [['accountant_name', 'accountant_number'], 'safe', 'on' => ['create']],
            [['accountant_name'], 'string', 'max' => 150],
            [['accountant_number'], 'string', 'max' => 15],
            [['bank_account_no_of_the_clf3'], 'string', 'max' => 20],
            [['branch_code_or_ifsc3', 'pan_no'], 'string', 'max' => 25],
            [['name_of_bank3', 'branch3'], 'string', 'max' => 150],
            [['reg_no'], 'string', 'max' => 100],
            [['updated_balance_in_bank3'], 'number'],
            [['date_of_opening_the_bank_account3', 'updated_balance_in_bank_date3'], 'safe'],
            [['bank_id3', 'more_bank', 'is_registered_under'], 'integer'],
            [['bank_id2', 'branch2', 'branch_code_or_ifsc2', 'date_of_opening_the_bank_account2', 'updated_balance_in_bank2', 'updated_balance_in_bank_date2'], 'required', 'when' => function ($model) {
                    return $model->bank_account_no_of_the_clf2 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#bank_account_no_of_the_clf2').val() !== '';
            }"],
            [['bank_account_no_of_the_clf2', 'branch2', 'branch_code_or_ifsc2', 'date_of_opening_the_bank_account2', 'updated_balance_in_bank2', 'updated_balance_in_bank_date2'], 'required', 'when' => function ($model) {
                    return $model->bank_id2 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#bank_id2').val() !== '';
            }"],
            [['bank_account_no_of_the_clf2', 'bank_id2', 'branch_code_or_ifsc2', 'date_of_opening_the_bank_account2', 'updated_balance_in_bank2', 'updated_balance_in_bank_date2'], 'required', 'when' => function ($model) {
                    return $model->branch2 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#branch2').val() !== '';
            }"],
            [['bank_account_no_of_the_clf2', 'bank_id2', 'branch2', 'date_of_opening_the_bank_account2', 'updated_balance_in_bank2', 'updated_balance_in_bank_date2'], 'required', 'when' => function ($model) {
                    return $model->branch_code_or_ifsc2 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#branch_code_or_ifsc2').val() !== '';
            }"],
            [['bank_account_no_of_the_clf2', 'bank_id2', 'branch2', 'branch_code_or_ifsc2', 'updated_balance_in_bank2', 'updated_balance_in_bank_date2'], 'required', 'when' => function ($model) {
                    return $model->date_of_opening_the_bank_account2 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#date_of_opening_the_bank_account2').val() !== '';
            }"],
            [['bank_account_no_of_the_clf2', 'bank_id2', 'branch2', 'branch_code_or_ifsc2', 'date_of_opening_the_bank_account2', 'updated_balance_in_bank_date2'], 'required', 'when' => function ($model) {
                    return $model->updated_balance_in_bank2 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#updated_balance_in_bank2').val() !== '';
            }"],
            [['bank_account_no_of_the_clf2', 'bank_id2', 'branch2', 'branch_code_or_ifsc2', 'date_of_opening_the_bank_account2', 'updated_balance_in_bank2'], 'required', 'when' => function ($model) {
                    return $model->updated_balance_in_bank_date2 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#updated_balance_in_bank_date2').val() !== '';
            }"],
            [['bank_id3', 'branch3', 'branch_code_or_ifsc3', 'date_of_opening_the_bank_account3', 'updated_balance_in_bank3', 'updated_balance_in_bank_date3'], 'required', 'when' => function ($model) {
                    return $model->bank_account_no_of_the_clf3 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#bank_account_no_of_the_clf3').val() !== '';
            }"],
            [['bank_account_no_of_the_clf3', 'branch3', 'branch_code_or_ifsc3', 'date_of_opening_the_bank_account3', 'updated_balance_in_bank3', 'updated_balance_in_bank_date3'], 'required', 'when' => function ($model) {
                    return $model->bank_id3 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#bank_id3').val() !== '';
            }"],
            [['bank_account_no_of_the_clf3', 'bank_id3', 'branch_code_or_ifsc3', 'date_of_opening_the_bank_account3', 'updated_balance_in_bank3', 'updated_balance_in_bank_date3'], 'required', 'when' => function ($model) {
                    return $model->branch3 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#branch3').val() !== '';
            }"],
            [['bank_account_no_of_the_clf3', 'bank_id3', 'branch3', 'date_of_opening_the_bank_account3', 'updated_balance_in_bank3', 'updated_balance_in_bank_date3'], 'required', 'when' => function ($model) {
                    return $model->branch_code_or_ifsc3 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#branch_code_or_ifsc3').val() !== '';
            }"],
            [['bank_account_no_of_the_clf3', 'bank_id3', 'branch3', 'branch_code_or_ifsc3', 'updated_balance_in_bank3', 'updated_balance_in_bank_date3'], 'required', 'when' => function ($model) {
                    return $model->date_of_opening_the_bank_account3 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#date_of_opening_the_bank_account3').val() !== '';
            }"],
            [['bank_account_no_of_the_clf3', 'bank_id3', 'branch3', 'branch_code_or_ifsc3', 'date_of_opening_the_bank_account3', 'updated_balance_in_bank_date3'], 'required', 'when' => function ($model) {
                    return $model->updated_balance_in_bank3 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#updated_balance_in_bank3').val() !== '';
            }"],
            [['bank_account_no_of_the_clf3', 'bank_id3', 'branch3', 'branch_code_or_ifsc3', 'date_of_opening_the_bank_account3', 'updated_balance_in_bank3'], 'required', 'when' => function ($model) {
                    return $model->updated_balance_in_bank_date3 != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#updated_balance_in_bank_date3').val() !== '';
            }"],
            [['reg_no', 'pan_no'], 'required', 'when' => function ($model) {
                    return $model->is_registered_under == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#is_registered_under').val() == '1';
            }"],
            [['bank_account_no_of_the_clf3', 'branch3', 'branch_code_or_ifsc3', 'date_of_opening_the_bank_account3', 'updated_balance_in_bank3', 'updated_balance_in_bank_date3', 'reg_no', 'pan_no'], 'trim'],
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
            'bank_account_no_of_the_clf2' => 'Bank Account No Of The Clf2',
            'bank_id2' => 'Bank Id2',
            'name_of_bank2' => 'Name Of Bank2',
            'branch2' => 'Branch2',
            'branch_code_or_ifsc2' => 'Branch Code Or Ifsc2',
            'date_of_opening_the_bank_account2' => 'Date Of Opening The Bank Account2',
            'passbook_photo2' => 'Passbook Photo2',
            'updated_balance_in_bank2' => 'Updated Balance In Bank2',
            'updated_balance_in_bank_date2' => 'Updated Balance In Bank Date2',
            'bank_account_no_of_the_clf3' => 'Bank Account No Of The Clf3',
            'bank_id3' => 'Bank Id3',
            'name_of_bank3' => 'Name Of Bank3',
            'branch3' => 'Branch3',
            'branch_code_or_ifsc3' => 'Branch Code Or Ifsc3',
            'date_of_opening_the_bank_account3' => 'Date Of Opening The Bank Account3',
            'passbook_photo3' => 'Passbook Photo3',
            'updated_balance_in_bank3' => 'Updated Balance In Bank3',
            'updated_balance_in_bank_date3' => 'Updated Balance In Bank Date3',
            'more_bank' => 'More Bank',
            'accountant_name' => 'Accountant Name',
            'accountant_number' => 'Accountant Number',
            'is_registered_under' => 'Is Registered Under society',
            'reg_no' => 'Reg No',
            'pan_no' => 'Pan No',
            'pan_photo' => 'Pan Photo',
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
            $this->passbook_photo3 = UploadedFile::getInstance($this, 'passbook_photo3');
            $this->pan_photo = UploadedFile::getInstance($this, 'pan_photo');
            $this->clf_model->block_code = $this->block_code;
            $this->clf_model->name_of_clf = $this->name_of_clf;
            $this->clf_model->nrlm_clf_code = $this->nrlm_clf_code;
            $this->clf_model->date_of_formation = $this->date_of_formation;
            $this->clf_model->no_of_vo_connected = $this->no_of_vo_connected;
            $this->clf_model->no_of_shg_connected = $this->no_of_shg_connected;
            $this->clf_model->no_of_gps_covered = $this->no_of_gps_covered;
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
            $this->clf_model->bank_account_no_of_the_clf3 = $this->bank_account_no_of_the_clf3;
            $this->clf_model->bank_id3 = $this->bank_id3;
            $this->clf_model->branch3 = $this->branch3;
            $this->clf_model->branch_code_or_ifsc3 = $this->branch_code_or_ifsc3;
            $this->clf_model->date_of_opening_the_bank_account3 = $this->date_of_opening_the_bank_account3;
            $this->clf_model->updated_balance_in_bank3 = $this->updated_balance_in_bank3;
            $this->clf_model->updated_balance_in_bank_date3 = $this->updated_balance_in_bank_date3;
            $this->clf_model->accountant_name = $this->accountant_name;
            $this->clf_model->accountant_number = $this->accountant_number;

            $this->clf_model->is_registered_under = $this->is_registered_under;
            if ($this->clf_model->is_registered_under) {
                $this->clf_model->reg_no = $this->reg_no;
                $this->clf_model->pan_no = $this->pan_no;
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
                    $tmp2_file_name = 'passbook_photo2_' . time() . "." . $this->passbook_photo2->name;

                    $this->passbook_photo2->saveAs($FOLDER . '/' . $tmp2_file_name);
                    chmod($FOLDER . '/' . $tmp2_file_name, 0777);
                    $this->clf_model->passbook_photo2 = $tmp2_file_name;
                    $this->clf_model->update();
                    $file = new FileHelpers();
                    $file->file_path = $FOLDER;
                    $file->file_name = $tmp2_file_name;
                    $file->upload();
                }
                if ($this->passbook_photo3 != null) {
                    $tmp3_file_name = 'passbook_photo3_' . time() . "." . $this->passbook_photo3->name;

                    $this->passbook_photo3->saveAs($FOLDER . '/' . $tmp3_file_name);
                    chmod($FOLDER . '/' . $tmp3_file_name, 0777);
                    $this->clf_model->passbook_photo3 = $tmp3_file_name;
                    $this->clf_model->update();
                    $file = new FileHelpers();
                    $file->file_path = $FOLDER;
                    $file->file_name = $tmp3_file_name;
                    $file->upload();
                }
                if ($this->pan_photo != null) {
                    $tmp4_file_name = 'pan_photo_' . time() . "." . $this->pan_photo->name;
                    $this->pan_photo->saveAs($FOLDER . '/' . $tmp4_file_name);
                    chmod($FOLDER . '/' . $tmp4_file_name, 0777);
                    $this->clf_model->pan_photo = $tmp4_file_name;
                    $this->clf_model->update();
                    $file = new FileHelpers();
                    $file->file_path = $FOLDER;
                    $file->file_name = $tmp4_file_name;
                    $file->upload();
                }
                $this->clf_model->save();
            }

            return $this;
        } catch (\Exception $ex) {
            
        }
    }

}

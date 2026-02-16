<?php

namespace cbo\models\form;

use Yii;
use cbo\models\CboVo;
use cbo\models\CboVoFunds;
use cbo\models\CboVoMembers;
use cbo\models\CboVoShg;
use cbo\models\form\CboVoFundsForm;
use cbo\models\form\CboVoMembersForm;
use yii\base\Model;

/**
 * This is the model class for table "cbo_vo".
 *
 * @property int $id
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property string $name_of_vo
 * @property string|null $date_of_formation
 * @property int $no_of_shg_connected
 * @property string|null $bank_account_no_of_the_vo
 * @property string|null $name_of_bank
 * @property string|null $branch
 * @property string|null $branch_code_or_ifsc
 * @property string|null $date_of_opening_the_bank_account
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */

/**
 * CboVoForm is the model behind the CboVo
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CboVoForm extends \yii\base\Model {

    public $id;
    public $state_code;
    public $state_name;
    public $division_code;
    public $division_name;
    public $district_code;
    public $district_name;
    public $block_code;
    public $block_name;
    public $gram_panchayat_code;
    public $gram_panchayat_name;
    public $name_of_vo;
    public $nrlm_vo_code;
    public $date_of_formation;
    public $no_of_shg_connected;
    public $bank_account_no_of_the_vo;
    public $bank_id;
    public $name_of_bank;
    public $branch;
    public $branch_code_or_ifsc;
    public $date_of_opening_the_bank_account;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $vo_model;
    public $members_model;
    public $funds_model;
    public $shgs_id;
    public $state_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $funds_type_option = [];
    public $member_role_option = [];
    public $bank_option = [];
    public $shgs_option = [];

    const MEMBER_ROW_INIT = 15;

    public function __construct($vo_model = null) {
        $this->vo_model = new CboVo();
        $this->load(\Yii::$app->request->post());
        if ($vo_model != null) {
            $this->vo_model = $vo_model;
            $this->gram_panchayat_code = $this->vo_model->gram_panchayat_code;
            $this->name_of_vo = $this->vo_model->name_of_vo;
            $this->nrlm_vo_code=$this->vo_model->nrlm_vo_code;
            $this->date_of_formation = $this->vo_model->date_of_formation != null ? \Yii::$app->formatter->asDatetime($this->vo_model->date_of_formation, "php:d-m-Y") : "";
            $this->no_of_shg_connected = $this->vo_model->no_of_shg_connected;
            $this->bank_account_no_of_the_vo = $this->vo_model->bank_account_no_of_the_vo;
            $this->name_of_bank = $this->vo_model->name_of_bank;
            $this->bank_id=$this->vo_model->bank_id;
            $this->branch = $this->vo_model->branch;
            $this->branch_code_or_ifsc = $this->vo_model->branch_code_or_ifsc;
            $this->date_of_opening_the_bank_account = $this->vo_model->date_of_opening_the_bank_account != null ? \Yii::$app->formatter->asDatetime($this->vo_model->date_of_opening_the_bank_account, "php:d-m-Y") : "";
            $this->shgs_id = \yii\helpers\ArrayHelper::getColumn($this->vo_model->shg, 'cbo_shg_id');
        }
        $this->block_option = \common\models\base\GenralModel::blockopption($this);
        $this->district_option = \common\models\base\GenralModel::nfsaoptiondistrict($this);
        $this->gp_option = \common\models\base\GenralModel::nfsaoptiongp($this);
        $this->funds_type_option = \common\models\base\GenralModel::cbo_funds_type_option('vo');
        $this->bank_option = \common\models\base\GenralModel::cbo_bank_option($this);
        $this->member_role_option = \common\models\base\GenralModel::cbo_member_role_option($this);
        if($this->gram_panchayat_code)
        $this->shgs_option = \common\models\base\GenralModel::cbo_shgs_option($this);

        $this->members_model[] = new CboVoMembersForm();
        for ($x = 0; $x <= self::MEMBER_ROW_INIT; $x++) {
            $this->members_model[$x] = new CboVoMembersForm();
        }
        if (isset($this->vo_model->members)) {
            foreach ($this->vo_model->members as $key => $member) {
                $this->members_model[$key] = new CboVoMembersForm();
                $this->members_model[$key]->id = $member->id;
                $this->members_model[$key]->cbo_vo_id = $member->cbo_vo_id;
                $this->members_model[$key]->name = $member->name;
                $this->members_model[$key]->mobile_no = $member->mobile_no;
                $this->members_model[$key]->role = $member->role;
                $this->members_model[$key]->bank_operator = $member->bank_operator;
            }
        }
        
        $this->funds_model[] = new CboVoFundsForm();
        foreach ($this->funds_type_option as $key => $value) {

            $this->funds_model[$key - 1] = new CboVoFundsForm();
            if (isset($this->vo_model->funds)) {
                $funds = CboVoFunds::find()->where(['cbo_vo_id' => $this->vo_model->id, 'fund_type' => $key])->one();
                if ($funds != null) {
                    $this->funds_model[$key - 1]->id = $funds->id;
                    $this->funds_model[$key - 1]->get_funds = $funds->get_funds;
                    $this->funds_model[$key - 1]->cbo_vo_id = $funds->cbo_vo_id;
                    $this->funds_model[$key - 1]->date_of_receipt = $funds->date_of_receipt != null ? \Yii::$app->formatter->asDatetime($funds->date_of_receipt, "php:d-m-Y") : "";
                    $this->funds_model[$key - 1]->instalment_if_any = $funds->instalment_if_any;
                    $this->funds_model[$key - 1]->total_amount_received = $funds->total_amount_received;
                    $this->funds_model[$key - 1]->balance_as_on_date = $funds->balance_as_on_date;
                }
            }
            $this->funds_model[$key - 1]->fund_type = $key;
            $this->funds_model[$key - 1]->type_name = $value;
        }

        Model::loadMultiple($this->funds_model, \Yii::$app->request->post());
        Model::loadMultiple($this->members_model, \Yii::$app->request->post());
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'no_of_shg_connected', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status','bank_id'], 'integer'],
            [['name_of_vo', 'no_of_shg_connected', 'gram_panchayat_code', 'date_of_formation'], 'required'],
            [['nrlm_vo_code'],'required'],
            [['bank_account_no_of_the_vo', 'bank_id', 'branch', 'branch_code_or_ifsc', 'branch_code_or_ifsc','date_of_opening_the_bank_account'], 'required'],
            [['date_of_formation', 'date_of_opening_the_bank_account'], 'safe'],
            [['division_name', 'name_of_vo', 'name_of_bank', 'branch'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name'], 'string', 'max' => 125],
            [['bank_account_no_of_the_vo', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['shgs_id'], 'safe'],
            [['name_of_vo'], 'trim'],
            [['nrlm_vo_code'],'trim'],
            [['no_of_shg_connected'], 'trim'],
            [['date_of_formation'], 'trim'],
            [['date_of_opening_the_bank_account'], 'trim'],
            [['bank_account_no_of_the_vo'], 'trim'],
            [['branch_code_or_ifsc'], 'trim'],
            [['branch'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'name_of_vo' => 'Name Of Vo',
            'nrlm_vo_code'=>'NRLM VO Code',
            'date_of_formation' => 'Date Of Formation',
            'no_of_shg_connected' => 'No Of Shg Connected',
            'bank_account_no_of_the_vo' => 'Bank Account No Of The Vo',
            'name_of_bank' => 'Name Of Bank',
            'bank_id' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {

        $this->vo_model->gram_panchayat_code = $this->gram_panchayat_code;
        $this->vo_model->name_of_vo = $this->name_of_vo;
        $this->vo_model->nrlm_vo_code=$this->nrlm_vo_code;
        $this->vo_model->date_of_formation = $this->date_of_formation;
        $this->vo_model->no_of_shg_connected = $this->no_of_shg_connected;
        $this->vo_model->bank_account_no_of_the_vo = $this->bank_account_no_of_the_vo;
        $this->vo_model->bank_id = $this->bank_id;
        $this->vo_model->branch = $this->branch;
        $this->vo_model->branch_code_or_ifsc = $this->branch_code_or_ifsc;
        $this->vo_model->date_of_opening_the_bank_account = $this->date_of_opening_the_bank_account;
        $this->vo_model->dummy_column = \Yii::$app->user->identity->dummy_column;
        if (isset($_POST['save_b'])) {
            $this->vo_model->status = CboVo::STATUS_SAVE;
        }
        if (isset($_POST['submit_b'])) {
            $this->vo_model->status = CboVo::STATUS_SUBMIT;
        }
        if (!$this->vo_model->validate()) {
            return false;
        }
        if ($this->vo_model->save()) {
            if (isset($this->shgs_id) and is_array($this->shgs_id)) {
                foreach ($this->shgs_id as $cbo_shg_id) {
                    if($cbo_shg_id){
                    $vo_shg = \cbo\models\Shg::find()->where(['id' => $cbo_shg_id])->one();
                    $vo_shg->cbo_vo_id = $this->vo_model->id;
                    $vo_shg->save();
                    }
                }
            }
            $condition = ['and',
                ['=', 'cbo_vo_id', $this->vo_model->id,],
                ['!=', 'status', -1],
            ];
            CboVoFunds::updateAll([
                'status' => 0,
                    ], $condition);
            foreach ($this->funds_model as $key => $fund) {
                $cbovofunds = CboVoFunds::find()->where(['cbo_vo_id' => $this->vo_model->id, 'fund_type' => $fund->fund_type])->one();
                if ($cbovofunds == null) {
                    $cbovofunds = new CboVoFunds();
                }
                $cbovofunds->cbo_vo_id = $this->vo_model->id;
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
                $cbovomember = CboVoMembers::find()->where(['id' => $member->id])->one();
                if ($cbovomember == null) {
                    $cbovomember = new CboVoMembers();
                }
                $cbovomember->cbo_vo_id = $this->vo_model->id;
                $cbovomember->name = $member->name;
                $cbovomember->mobile_no = $member->mobile_no;
                $cbovomember->role = $member->role;
                $cbovomember->bank_operator = $member->bank_operator;
                $cbovomember->status = 1;
                if ($cbovomember->name) {
                    $cbovomember->save();
                }
            }
        }

        return $this;
    }

}

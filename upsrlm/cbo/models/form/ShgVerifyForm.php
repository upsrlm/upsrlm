<?php

namespace cbo\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\master\MasterRole;
use cbo\models\Shg;

/**
 * This is the model class for table "shg".
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
 * @property int|null $village_code
 * @property string|null $village_name
 * @property string $hamlet
 * @property string $name_of_shg
 * @property int $no_of_members
 * @property string|null $chaire_person_name
 * @property string|null $chaire_person_mobile_no
 * @property string|null $secretary_name
 * @property string|null $secretary_mobile_no
 * @property string|null $treasurer_name
 * @property string|null $treasurer_mobile_no
 * @property int|null $verify_shg_location
 * @property int|null $verify_shg_name
 * @property int|null $verify_shg_members
 * @property int|null $verify_chaire_person_mobile_no
 * @property int|null $verify_secretary_mobile_no
 * @property int|null $verify_treasurer_mobile_no
 * @property int|null $verify_mobile_no
 * @property int|null $verify_by
 * @property int $verification_status
 * @property string|null $verify_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */

/**
 * ShgVerifyForm is the model behind the Shg
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ShgVerifyForm extends \yii\base\Model {

    public $id;
    public $verify_shg_location;
    public $verify_shg_name;
    public $verify_shg_members;
    public $verify_chaire_person_mobile_no;
    public $verify_secretary_mobile_no;
    public $verify_treasurer_mobile_no;
    public $verify_mobile_no;
    public $verify_shg_code;
    public $verify_by;
    public $verification_status;
    public $verify_datetime;
    public $status;
    public $yes_no_option;
    public $yes_no_skip_option;
    public $shg_model;

    public function __construct($shg_model) {
        $this->shg_model = $shg_model;
        $this->yes_no_option = ['1' => 'Yes', '2' => 'No'];
        $this->yes_no_skip_option = ['1' => 'Yes', '2' => 'No', '-1' => 'skip'];
        if ($this->shg_model->verify_shg_location != 0) {
            $this->verify_shg_location = $this->shg_model->verify_shg_location;
        }
        if ($this->shg_model->verify_shg_name != 0) {
            $this->verify_shg_name = $this->shg_model->verify_shg_name;
        }
        if ($this->shg_model->verify_shg_code != 0) {
            $this->verify_shg_code = $this->shg_model->verify_shg_code;
        }
        if ($this->shg_model->verify_shg_members != 0) {
            $this->verify_shg_members = $this->shg_model->verify_shg_members;
        }
        if ($this->shg_model->verify_chaire_person_mobile_no != 0) {
            $this->verify_chaire_person_mobile_no = $this->shg_model->verify_chaire_person_mobile_no;
        }
        if ($this->shg_model->verify_secretary_mobile_no != 0) {
            $this->verify_secretary_mobile_no = $this->shg_model->verify_secretary_mobile_no;
        }
        if ($this->shg_model->verify_secretary_mobile_no != 0) {
            $this->verify_treasurer_mobile_no = $this->shg_model->verify_treasurer_mobile_no;
        }
    }

    public function rules() {
        return [
            [['verify_chaire_person_mobile_no', 'verify_secretary_mobile_no', 'verify_treasurer_mobile_no', 'verify_shg_location', 'verify_shg_name', 'verify_shg_members', 'verify_shg_code'], 'required'],
//            ['verify_chaire_person_mobile_no', 'default', 'value' => 0],
//            ['verify_secretary_mobile_no', 'default', 'value' => 0],
//            ['verify_treasurer_mobile_no', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'verify_chaire_person_mobile_no' => 'Chairperson mobile no. verfied',
            'verify_secretary_mobile_no' => 'Secretary mobile no. verfied',
            'verify_treasurer_mobile_no' => 'Treasurer mobile no. verfied',
            'status' => 'Status',
        ];
    }

}

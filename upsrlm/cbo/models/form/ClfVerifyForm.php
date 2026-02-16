<?php

namespace cbo\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\UserModel;
use app\models\master\MasterRole;
use app\modules\shg\models\Shg;

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
 * @property int $return
 */

/**
 * ShgVerifyForm is the model behind the Shg
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ClfVerifyForm extends \yii\base\Model {

    public $id;
   
    public $status;
    public $yes_no_option;
    public $clf_model;
    public $return;

    public function __construct($clf_model) {
        $this->clf_model = $clf_model;
        $this->yes_no_option = ['1' => 'Yes', '0' => 'No'];
//        $this->verify_shg_location = $this->shg_model->verify_shg_location;
//        $this->verify_shg_name = $this->shg_model->verify_shg_name;
//        $this->verify_shg_members = $this->shg_model->verify_shg_members;
//        $this->verify_chaire_person_mobile_no = $this->shg_model->verify_chaire_person_mobile_no;
//        $this->verify_secretary_mobile_no = $this->shg_model->verify_secretary_mobile_no;
//        $this->verify_treasurer_mobile_no = $this->shg_model->verify_treasurer_mobile_no;
//        $this->verify_shg_code=$this->shg_model->verify_shg_code;
    }

    public function rules() {
        return [
            [['return'], 'required'],
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
            'verify_shg_code' => 'SHD Code verfied',
            'status' => 'Status',
        ];
    }

}

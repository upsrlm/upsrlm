<?php

namespace common\models\dynamicdb\cbo_detail\dbt\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\validators\MobileNoValidator;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryHousehold;


/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class DbtBeneficaryHouseholdbocwForm extends \yii\base\Model {

    public $household_model;
    public $dbt_beneficiary_household_id;
    public $cbo_shg_id;
    public $rishta_shg_member_id;
    public $bocw;
    public $bocw_by;
    public $bocw_reg_no;
    public $bocw_date;

    public function __construct($household_model = null) {
        $this->household_model = $household_model;

        if ($this->household_model) {
            $this->bocw_reg_no = $this->household_model->bocw_reg_no;
            $this->dbt_beneficiary_household_id = $this->household_model->id;
            $this->cbo_shg_id = $this->household_model->cbo_shg_id;
            $this->rishta_shg_member_id = $this->household_model->rishta_shg_member_id;
        }
    }

    public function rules() {
        return [
            [['bocw_reg_no'], 'required', 'message' => "{attribute} खाली नहीं हो सकता."],
            [['bocw_reg_no'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->household_model->$attribute != $model->$attribute;
                }, 'targetClass' => DbtBeneficiaryHousehold::className(), 'message' => 'यह बीओसीडब्ल्यू रजिस्ट्रेशन नंबर पहले ही लिया जा चुका है', 'targetAttribute' => 'bocw_reg_no'],
            [['bocw', 'bocw_by'], 'integer'],
            [['bocw_date'], 'safe'],
            [['bocw_reg_no'], 'string', 'min' => 5],
            [['bocw_reg_no'], 'string', 'max' => 100],
            [['bocw'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bocw_reg_no' => 'बीओसीडब्ल्यू पंजीकरण संख्या',
        ];
    }

}

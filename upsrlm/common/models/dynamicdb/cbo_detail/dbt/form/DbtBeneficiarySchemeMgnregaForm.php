<?php

namespace common\models\dynamicdb\cbo_detail\dbt\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\validators\MobileNoValidator;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnrega;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaYesno;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaApplicant;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaMasterCast;

/**
 * This is the model class for table "dbt_beneficiary_scheme_mgnrega".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property string $name
 * @property string|null $mobile
 * @property int|null $marital_status
 * @property int|null $age
 * @property int|null $caste_category
 * @property int|null $duration_of_membership
 * @property int|null $total_saving
 * @property int|null $loan
 * @property int|null $loan_count
 * @property string|null $loan_amount
 * @property string|null $loan_date
 * @property int|null $mcp_status
 * @property int|null $role
 */

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */
class DbtBeneficiarySchemeMgnregaForm extends \yii\base\Model
{

    public $scheme_model;
    public $dbt_beneficiary_scheme_mgnrega_id;
    public $dbt_beneficiary_household_id;
    public $cbo_shg_id;
    public $rishta_shg_member_id;
    public $house_no;
    public $caste_category;
    public $family_head_name;
    public $minority_family;
    public $bpl_family;
    public $bpl_secc_id;
    public $mobile_number;
    public $iay_beneficiary;
    public $st_or_tribal;
    public $land_reforms;
    public $small_marginal_farmers;
    public $rsbyi_beneficiary;
    public $aaby_beneficiary;
    public $status;
    public $applicants_ids;
    public $applicants_list;
    public $applicants_list_head;
    public $family_head_member_id;
    public $yesnooption;
    public $casteoption;
    public $form_complete;
    public $current_mgnrega_beneficiary;
    public $current_job_card_number;
    public $current_mgnrega_beneficiary_interested_work;
    public $current_mgnrega_beneficiary_day = 0;
    public $current_job_card_photo;
    public $work_day_option = [];
    public $demand_application;

    public function __construct($scheme_model = null)
    {
        $this->scheme_model = Yii::createObject([
            'class' => DbtBeneficiarySchemeMgnrega::className()
        ]);

        if ($scheme_model) {
            $this->scheme_model = $scheme_model;
            $this->demand_application= \common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaDa::find()->where(['mgnrega_scheme_id'=>$scheme_model->id])->limit(1)->orderBy('created_at desc')->one();
            $this->dbt_beneficiary_household_id = $this->scheme_model->dbt_beneficiary_household_id;
            $this->cbo_shg_id = $this->scheme_model->cbo_shg_id;
            $this->rishta_shg_member_id = $this->scheme_model->rishta_shg_member_id;
            $this->mobile_number = $this->scheme_model->mobile_number;
            $this->house_no = $this->scheme_model->house_no;
            $this->caste_category = $this->scheme_model->caste_category;
            $this->family_head_name = $this->scheme_model->family_head_name;
            $this->family_head_member_id = $this->scheme_model->family_head_member_id;
            $this->minority_family = $this->scheme_model->minority_family;
            $this->bpl_family = $this->scheme_model->bpl_family;
            $this->bpl_secc_id = $this->scheme_model->bpl_secc_id;
            $this->iay_beneficiary = $this->scheme_model->iay_beneficiary;
            $this->st_or_tribal = $this->scheme_model->st_or_tribal;
            $this->land_reforms = $this->scheme_model->land_reforms;
            $this->small_marginal_farmers = $this->scheme_model->small_marginal_farmers;
            $this->rsbyi_beneficiary = $this->scheme_model->rsbyi_beneficiary;
            $this->aaby_beneficiary = $this->scheme_model->aaby_beneficiary;
            $this->status = $this->scheme_model->status;
        }

        $this->applicants_ids = DbtBeneficiarySchemeMgnregaApplicant::find()->select(['dbt_beneficiary_member_id'])->where(['mgnrega_form_id' => $this->scheme_model->id, 'status' => 1])->column();
        $this->applicants_list_head = ArrayHelper::map(DbtBeneficiaryMember::find()->where(['cbo_shg_id' => $this->cbo_shg_id, 'dbt_beneficiary_household_id' => $this->dbt_beneficiary_household_id])->all(), 'id', 'name');
        $this->applicants_list = DbtBeneficiaryMember::find()->where(['cbo_shg_id' => $this->cbo_shg_id, 'dbt_beneficiary_household_id' => $this->dbt_beneficiary_household_id])->all();
        $this->yesnooption = ArrayHelper::map(DbtBeneficiarySchemeMgnregaYesno::find()->where(['status' => 1])->all(), 'id', 'name_hi');
        $this->casteoption = ArrayHelper::map(DbtBeneficiarySchemeMgnregaMasterCast::find()->where(['status' => 1])->all(), 'id', 'name_hi');
        $this->work_day_option = \common\models\base\GenralModel::dbt_mgnrega_work_day_option();
    }

    public function rules()
    {
        return [
            [['house_no', 'caste_category', 'family_head_member_id', 'minority_family', 'bpl_family', 'iay_beneficiary', 'st_or_tribal', 'land_reforms', 'small_marginal_farmers', 'rsbyi_beneficiary', 'aaby_beneficiary', 'applicants_ids'], 'safe', 'message' => "{attribute} खाली नहीं हो सकता.", 'on' => 'setp_form'],
            [['cbo_shg_id', 'dbt_beneficiary_household_id', 'rishta_shg_member_id', 'dbt_beneficiary_scheme_mgnrega_id', 'minority_family', 'bpl_family', 'bpl_secc_id', 'iay_beneficiary', 'st_or_tribal', 'land_reforms', 'small_marginal_farmers', 'rsbyi_beneficiary', 'aaby_beneficiary', 'family_head_member_id', 'form_complete'], 'integer'],
            [['mobile_number'], \common\validators\MobileNoValidator::class],
            [['mobile_number'], 'string', 'max' => 10],
            [['family_head_name'], 'string', 'min' => 2, 'max' => 150],
            [['house_no'], 'string', 'min' => 2, 'max' => 100],
            ['applicants_ids', 'safe'],
            [['bpl_secc_id'],'safe'],
            // ['form_complete', 'required', 'on' => 'formcomplete'],
            [['form_complete'], 'required', 'requiredValue' => 1, 'message' => 'आगे बढ़ने से पहले यहां क्लिक करें', 'on' => 'formcomplete'],
            [['current_mgnrega_beneficiary'], 'required', 'message' => "{attribute} खाली नहीं हो सकता.", 'on' => 'setp_current'],
            [['current_mgnrega_beneficiary', 'current_mgnrega_beneficiary_interested_work', 'current_mgnrega_beneficiary_day'], 'integer'],
            [['current_job_card_photo'], 'string', 'max' => 1000000000000000],
            [['current_job_card_number'], 'string', 'max' => 50],
            ['current_mgnrega_beneficiary_interested_work', 'required', 'on' => ['setp_current'], 'when' => function ($model) {
                return ($model->current_mgnrega_beneficiary == 2);
            }, 'message' => 'क्या आप MGNREGA में काम करने को इच्छुक है तो चुने', 'whenClient' => "function (attribute, value) {
                  return ($('#current_mgnrega_beneficiary').val() == '2');
            }"],
            ['current_mgnrega_beneficiary_day', 'required', 'on' => ['setp_current'], 'when' => function ($model) {
                return $model->current_mgnrega_beneficiary_interested_work == 1;
            }, 'message' => 'अगर इच्छुक हैं तो कितने दिन के लिए काम चाहिए है तो चुने', 'whenClient' => "function (attribute, value) {
                  return $('#current_mgnrega_beneficiary_interested_work').val() == '1';
            }"],
            ['current_job_card_photo', 'required', 'on' => ['setp_current'], 'when' => function ($model) {
                return $model->current_mgnrega_beneficiary == 1;
            }, 'message' => 'कृपया अपने जॉब कार्ड का सीधा और स्पष्ट फोटो अपलोड करें', 'whenClient' => "function (attribute, value) {
                  return $('#current_mgnrega_beneficiary').val() == '1';
            }"],
            [['current_mgnrega_beneficiary', 'current_mgnrega_beneficiary_interested_work', 'current_mgnrega_beneficiary_day'], 'integer'],
            [['current_mgnrega_beneficiary', 'current_mgnrega_beneficiary_interested_work', 'current_mgnrega_beneficiary_day'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'applicants_ids' => '1). आवेदकों का ब्योरा ',
            'house_no' => '2). मकान नम्बर',
            'mobile_number' => 'मोबाइल न0',
            'family_head_name' => '6). परिवार के मुखिया का नाम',
            'family_head_member_id' => '6). परिवार के मुखिया का नाम',
            'caste_category' => '7). श्रेणी (अनु. जाति/ अनु. जनजाति/ अपि. वर्ग/ अन्य)',
            'minority_family' => '8). क्या परिवार अल्पसंख्यक है',
            'iay_beneficiary' => '9). क्या आई ए वाई (इंदिरा आवास योजना) लाभार्थी हैं',
            'land_reforms' => '10). क्या भूमि सुधार लाभार्थी हैं',
            'small_marginal_farmers' => '11). क्या लघु कृषक या सीमांत कृषक हैं ',
            'st_or_tribal' => '12). क्या लाभार्थी अनुसूचित जनजाति या अन्य परम्परागत बनवासी हैं',
            'bpl_family' => '13). क्या बीपीएल (below poverty line) परिवार हैं ',
            'rsbyi_beneficiary' => '14). क्या आर एस बी वाई/ आई लाभार्थी हैं ',
            'aaby_beneficiary' => '15). क्या आम आदमी बीमा योजना (एएबीवाई) के लाभार्थी हैं ',
            'bpl_secc_id' => '16). बीपीएल परिवार सर्वेक्षण/ सामाजिक आर्थिक जाति जन गणना (एसईसीसी) के अनुसार परिवार आईडी ',
            'form_complete' => 'मैं/ हम/ प्रमाणित करता हूँ/ करते हैं/, कि उपरोक्त दी गई जानकारी सही है',
            'current_mgnrega_beneficiary' => '1). क्या आप मनरेगा योजना का लाभ प्राप्त कर रहे हैं?',
            'current_job_card_number' => '2). मनरेगा जॉब कार्ड नंबर',
            'current_mgnrega_beneficiary_interested_work' => '2. क्या आप MGNREGA में काम करने को इच्छुक है?',
            'current_mgnrega_beneficiary_day' => '3. अगर इच्छुक हैं तो कितने दिन के लिए काम चाहिए?',
            'current_job_card_photo' => '4. कृपया अपने जॉब कार्ड का सीधा और स्पष्ट फोटो अपलोड करें:',
        ];
    }
}

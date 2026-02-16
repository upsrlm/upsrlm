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
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaDaFtoAcknowledge;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class DbtMgnregaFtoAcknolegeForm extends \yii\base\Model {

    public $da_member_fto_ack_id;
    public $name;
    public $shg_name;
    public $work_day;
    public $work_day_duration;
    public $work_start_date;
    public $work_end_date;
    public $laborer_wages_were_paid;
    public $total_wage_liability;
    public $wages_received_by_the_worker;
    public $date_of_receipt_of_wages;
    public $feedback;
    public $feed_did_you_get_your_wages_ontime;
    public $feed_whether_wages_were_cut_in_any_way;
    public $feed_bank_bc_delayed_discouraged_withdrawal_wages;
    public $feed_someone_wrongly_ask_money_commission;
    public $feed_misbehaved_gp_nrega_official_employee;
    public $feed_satisfied_behavior_officers_associated_nrega;
    public $fto_ack_model;
    public $status;
    public $yesnooption=[];

    public function __construct($model) {
        $this->fto_ack_model = $model;
        if ($this->fto_ack_model != null) {
            $this->name = $this->fto_ack_model->bmember->name;
            $this->shg_name = $this->fto_ack_model->cboshg->name_of_shg;
            $this->work_day = $this->fto_ack_model->workdaylabel;
            $this->work_start_date = $this->fto_ack_model->work_start_date;
            $this->work_end_date = $this->fto_ack_model->work_end_date;
            if ($this->fto_ack_model->laborer_wages_were_paid) {
                $this->laborer_wages_were_paid = $this->fto_ack_model->laborer_wages_were_paid;
            }
            if ($this->fto_ack_model->total_wage_liability) {
                $this->total_wage_liability = $this->fto_ack_model->total_wage_liability;
            }
            if ($this->fto_ack_model->wages_received_by_the_worker) {
                $this->wages_received_by_the_worker = $this->fto_ack_model->wages_received_by_the_worker;
            }
            $this->date_of_receipt_of_wages = $this->fto_ack_model->date_of_receipt_of_wages;
            if ($this->fto_ack_model->feed_did_you_get_your_wages_ontime) {
                $this->feed_did_you_get_your_wages_ontime = $this->fto_ack_model->feed_did_you_get_your_wages_ontime;
            }
            if ($this->fto_ack_model->feed_whether_wages_were_cut_in_any_way) {
                $this->feed_whether_wages_were_cut_in_any_way = $this->fto_ack_model->feed_whether_wages_were_cut_in_any_way;
            }
            if ($this->fto_ack_model->feed_bank_bc_delayed_discouraged_withdrawal_wages) {
                $this->feed_bank_bc_delayed_discouraged_withdrawal_wages = $this->fto_ack_model->feed_bank_bc_delayed_discouraged_withdrawal_wages;
            }
            
            
            if ($this->fto_ack_model->feed_someone_wrongly_ask_money_commission) {
                $this->feed_someone_wrongly_ask_money_commission = $this->fto_ack_model->feed_someone_wrongly_ask_money_commission;
            }
            if ($this->fto_ack_model->feed_misbehaved_gp_nrega_official_employee) {
                $this->feed_misbehaved_gp_nrega_official_employee = $this->fto_ack_model->feed_misbehaved_gp_nrega_official_employee;
            }
            if ($this->fto_ack_model->feed_satisfied_behavior_officers_associated_nrega) {
                $this->feed_satisfied_behavior_officers_associated_nrega = $this->fto_ack_model->feed_satisfied_behavior_officers_associated_nrega;
            }
        }
        $this->da_member_fto_ack_id = $model->id;
        $this->yesnooption = ArrayHelper::map(DbtBeneficiarySchemeMgnregaYesno::find()->where(['status' => 1])->all(), 'id', 'name_hi');
    }

    public function rules() {
        return [
            [['da_member_fto_ack_id'], 'required', 'message' => "{attribute} भरे."],
            [['work_start_date'], 'required', 'message' => "{attribute} भरे."],
            [['work_end_date'], 'required', 'message' => "{attribute} भरे."],
            [['work_end_date'], 'required', 'message' => "{attribute} भरे."],
            [['work_end_date'], \common\validators\StartDateAndEndDateValidator::className()],
            [['laborer_wages_were_paid'], 'required', 'message' => "{attribute} चुने."],
            [['total_wage_liability'], 'required', 'message' => "{attribute} भरे."],
            [['wages_received_by_the_worker'], 'safe'],
            ['wages_received_by_the_worker', 'required','when' => function ($model) {
                    return $model->laborer_wages_were_paid == 1;
                }, 'message' => "{attribute} भरे.", 'whenClient' => "function (attribute, value) {
                  return $('#laborer_wages_were_paid').val() == '1';
            }"],
            [['date_of_receipt_of_wages'], 'safe'],            
            ['date_of_receipt_of_wages', 'required','when' => function ($model) {
                    return $model->laborer_wages_were_paid == 1;
                }, 'message' => "{attribute} भरे.", 'whenClient' => "function (attribute, value) {
                  return $('#laborer_wages_were_paid').val() == '1';
            }"],            
            
            [['feed_did_you_get_your_wages_ontime'], 'required', 'message' => "{attribute} चुने."],
            [['feed_whether_wages_were_cut_in_any_way'], 'required', 'message' => "{attribute} चुने."],
            [['feed_bank_bc_delayed_discouraged_withdrawal_wages'], 'required', 'message' => "{attribute} चुने."],
            [['feed_someone_wrongly_ask_money_commission'], 'required', 'message' => "{attribute} चुने."],
            [['feed_misbehaved_gp_nrega_official_employee'], 'required', 'message' => "{attribute} चुने."],
            [['feed_satisfied_behavior_officers_associated_nrega'], 'required', 'message' => "{attribute} चुने."],
            [['total_wage_liability', 'wages_received_by_the_worker'], 'number'],            
            [['name'], 'safe'],
            [['shg_name'], 'safe'],
            [['work_day'], 'safe'],
            [['work_day_duration'], 'safe'],
            [['total_wage_liability'], 'default', 'value' => 0],
            [['wages_received_by_the_worker'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'name' => '1). श्रमिक का नाम',
            'shg_name' => '2). SHG का नाम',
            'work_day' => '3) श्रमिक द्वारा कार्य किये गए दिनों की संख्या',
            'work_day_duration' => '4).श्रमिक द्वारा किए कार्य की समयावधि',
            'work_start_date' => 'तिथि से',
            'work_end_date' => 'तिथि तक',
            'laborer_wages_were_paid' => '5). क्या श्रमिक के मजदूरी का भुगतान हुआ',
            'total_wage_liability' => '6). कुल मज़दूरी की देयता',
            'wages_received_by_the_worker' => '7). अगर हाँ, तो श्रमिक द्वारा प्राप्त की गई मजदूरी',
            'date_of_receipt_of_wages' => '8). मजदूरी प्राप्त होने की तिथि',
            'feedback' => '9). श्रमिक के मज़दूरी भुगतान संबंधी फीडबैक',
            'feed_did_you_get_your_wages_ontime' => 'क्या आपको मज़दूरी समय से मिला (8 से 10 दिन में)',
            'feed_whether_wages_were_cut_in_any_way' => 'क्या मज़दूरी में किसी प्रकार कटौती हुई?',
            'feed_bank_bc_delayed_discouraged_withdrawal_wages' => 'क्या बैंक/ बीसी सखी ने मज़दूरी के निकासी/ आहरण में आनाकानी की/ हतोत्साहित किया',
            'feed_someone_wrongly_ask_money_commission' => 'क्या आपसे किसी ने ग़लत रूप से पैसा/ कमीशन माँगा?',
            'feed_misbehaved_gp_nrega_official_employee' => 'क्या ग्राम पंचायत/ नरेगा से जुड़े अधिकारी, कर्मचारी या प्रतिनिधि ने कभी आपके साथ दुर्व्यवहार किया? उनकी कोई बात आपको बुरी लगती है?',
            'feed_satisfied_behavior_officers_associated_nrega' => 'क्या आप नरेगा से जुड़े अधिकारियों/ कर्मचारिओं के व्यवहार से संतुष्ट हैं?',
        ];
    }

}

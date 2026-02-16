<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\master\MasterRole;
use kartik\icons\FontAwesomeAsset;
use kartik\editable\Editable;
use kartik\checkbox\CheckboxX;
use yii\widgets\ListView;
use yii\widgets\Pjax;

FontAwesomeAsset::register($this);
$app = new \sakhi\components\App();
$this->title = 'बीसी सखी से रू0 75000/- सपोर्ट फण्ड वापसी का रिश्ता मोबाइल ऐप पर रिपोर्ट';
$url_class = 'disabled';
if($model->bc_amount_repay){
  $url_class = '';  
}
?>
<div class="row margin-set">
    <div class="col-xl-12 p-0">
        <div id="panel-1" class="panel">
            <div class="card-title mb-0 p-2 border-bottom">
                <h2 class="mb-0 px-1"><?= $this->title ?></h2>   
            </div>
            <div class="panel-container show px-1">
                <div class="panel-content h4">
                    <p>
                        प्रिय बीसी सखी <?= $model->name ?>, आप इस बात से अवगत हैं कि उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन व उत्तर प्रदेश शासन ने बीसी सखी कार्यक्रम के माध्यम से आम ग्रामीण व गरीब परिवारों में वित्तीय समावेशन के लक्ष्य को प्राप्त करने के दिशा में महत्व पूर्ण कदम लिए हैं। उत्तर प्रदेश बीसी सखी कार्यक्रम पूरे देश में सबसे सफल कार्यक्रम बन कर उभरा है। आपको ये भी अवगत है, बीसी सखी बनने के माध्यम से शासन ने 58,000 आम घरेलू व ज़्यादातर गरीब महिलाओं के लिए स्थायी रोज़गार के अवसर नियोजित किया है, जिनमे से कुछ तो प्रति माह 25,000 रुपये से ज़्यादा कमीशन कमा रहीं हैं। बीसी सखी कार्यक्रम के तहत अबतक 12,500 करोड़ रुपये से ज़्यादा का बैंकिंग ट्रांजेक्शन किया गया है, और बीसी सखियों ने लगभग 33 करोड़ रुपये का कमीशन कमाया है।    
                    </p>
                    <p>
                        आप ये जानती होंगी कि बीसी सपोर्ट फण्ड स्वयं सहायता समूहों को दी जाने वाली कम्युनिटी इन्वेस्टमेंट फण्ड (CIF) का एक भाग है जो मुलतः समूहों के सदस्यों के लिए उद्द्येशित है। बीसी को दे जाने वाली फण्ड के वापसी से समूह के कई सदस्यों को आजीविका के लिए ऋण दिये जा सकेंगे। एक तरह से, समूह व उनके सदस्य बीसी सखी के सफलता के लिए अपना त्याग कर रहें हैं और ये आवश्यक है कि उनके सम्मुख जो आजीविका के अवसर हैं, उन्हें प्राप्त करने के लिए बीसी सपोर्ट फण्ड का समय से त्वरित वापसी तथा पुनरुपयोग हो। <b> बीसी सपोर्ट फण्ड की वापसी बिना किसी समूह के बैठक, या किसी नये नियमावली के आपके साथ समूह के बीच निर्धारित शर्तों के अन्तर्गत सहज तरीक़े से मिशन या शासन के किसी हस्तक्षेप के संपादित हो जाना चाहिए ।   </b>
                    </p>
                    <p>
                        कृपया नीचे फॉर्म के माध्यम से आप अपना ऋण वापसी का भुगतान योजना सबमिट करें । आपके ऋण पर लग रहें ब्याज दर विवरण नीचे दिए गये हैं एवं आपके के सबसे आसान व उचित पद्धति का भी सुझाव दिया गया है।  
                    </p>
                    <ul class="pl-3">
                        <li>बीसी सपोर्ट फण्ड प्राप्त करने के दिन से ही उसपर 4% सालाना के दर से ब्याज  लागू है।</li> 
                        <li>बकाया बीसी सपोर्ट फण्ड पर हर तीन माह पर ब्याज दर का गणना होती है।</li> 
                        <li>
                            बेसिक लेवल पर देखा जाये तो बीसी सपोर्ट फण्ड पर लागू होने वाले <b>मासिक</b> ब्याज का गणना इस तरह होगी –
                        </li> 
                    </ul>

                    <div class="table-responsive-xl mb-2">
                        <table class="table sakhi-tablecstm">
                            <thead>
                                <tr class="bg-success-100 text-center">
                                    <th scope="col" class="th-lg">अवधि</th>
                                    <th scope="col" class="th-lg">प्रति माह देयता (EMI)</th>
                                    <th scope="col" class="th-lg">कुल भुगतान की राशि</th>
                                    <th scope="col" class="th-lg">ब्याज जो दिया गया होगा</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>एक साल/ 12 महीना</td>
                                    <td class="bg-success-100">6,386/-</td>
                                    <td>76,634/-</td>
                                    <td>1,634</td>
                                </tr>
                                <tr class="text-center">
                                    <td>दो साल/ 24 महीना </td>
                                    <td class="bg-success-100">3,256/-</td>
                                    <td>78,165/-</td>
                                    <td>3,165</td>
                                </tr>
                                <tr class="text-center">
                                    <td>तीन साल/ 36 महीना </td>
                                    <td class="bg-success-100">2,214/-</td>
                                    <td>79,715/-</td>
                                    <td>4,715</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <ul  class="pl-3">
                        <li>ये समझने वाली बात है, जब बैंक आपके बकाये रक़म पर ब्याज जोड़ती है तो तीन माह में एकबार गणना करती है। पर जब आप कोई बकाया चुकातें है, तो बैंक उस पर प्रति दिन के हिसाब से बकाया तथा ब्याज घटाती है।</li> 
                        <li>इस लिये, किसी भी बकायेदार के लिये भले ही कम कम रक़म वापस करना हो, पर जल्दी जल्दी चुकाना हमेशा फ़ायदेमंद होता है।</li> 
                        <li>
                            इस सिद्धांत के मद्देनज़र, नीचे के टेबल में आप को <b>सप्ताहवार </b>ऋण वापसी का भी गणना  दिखाया गया है –
                        </li> 
                    </ul>

                    <div class="table-responsive-xl mb-2">
                        <table class="table sakhi-tablecstm">
                            <thead>
                                <tr class="bg-success-100 text-center">
                                    <th scope="col" class="th-lg">अवधि</th>
                                    <th scope="col" class="th-lg">प्रति सप्ताह देयता (EWI)</th>
                                    <th scope="col" class="th-lg">कुल भुगतान की राशि</th>
                                    <th scope="col" class="th-lg">ब्याज जो दिया गया होगा</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>एक साल/ 52 सप्ताह</td>
                                    <td class="bg-success-100">1,472/-</td>
                                    <td>76,544/-</td>
                                    <td>1,544/-</td>
                                </tr>
                                <tr class="text-center">
                                    <td>दो साल/ 104 सप्ताह</td>
                                    <td class="bg-success-100">751/-</td>
                                    <td>78,104/-</td>
                                    <td>3,104/-</td>
                                </tr>
                                <tr class="text-center">
                                    <td>तीन साल/ 156 सप्ताह </td>
                                    <td class="bg-success-100">510/-</td>
                                    <td>79,619/-</td>
                                    <td>4,619/-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <ul  class="pl-3">

                        <li>
                            इस सिद्धांत के मद्देनज़र, नीचे के टेबल में आप को <b>प्रति दिन </b>  ऋण वापसी का भी गणना  दिखाया गया है –                                    
                        </li> 
                    </ul>

                    <div class="table-responsive-xl mb-2">
                        <table class="table sakhi-tablecstm">
                            <thead>
                                <tr class="bg-success-100 text-center">
                                    <th scope="col" class="th-lg">अवधि</th>
                                    <th scope="col" class="th-lg">प्रति दिन देयता (EWI)</th>
                                    <th scope="col" class="th-lg">कुल भुगतान की राशि</th>
                                    <th scope="col" class="th-lg">ब्याज जो दिया गया होगा</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>एक साल/ 365 दिन </td>
                                    <td class="bg-success-100">210/-</td>
                                    <td>76,514/-</td>
                                    <td>1,514/-</td>
                                </tr>
                                <tr class="text-center">
                                    <td>दो साल/ 730 दिन</td>
                                    <td class="bg-success-100">107/-</td>
                                    <td>78,044/-</td>
                                    <td>3,044/-</td>
                                </tr>
                                <tr class="text-center">
                                    <td>तीन साल/ 1095 दिन </td>
                                    <td class="bg-success-100">73/-</td>
                                    <td>79,594/-</td>
                                    <td>4,594/-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
<!--                    <div class="h4 font-weight-bold mb-1">1. आपने अबतक कितना ऋण वापस की है ( रू) : <?php
//                        echo Editable::widget([
//                            'name' => 'bc_return_amount',
//                            'asPopover' => false,
//                            'value' => $model->bc_return_amount,
//                            'inputType' => Editable::INPUT_TEXT,
//                            'header' => 'लक्ष्य',
//                            'options' => ['class' => 'form-control h1', 'type' => 'number', 'min' => 0, 'max' => 100000],
//                            'formOptions' => ['action' => ['/bc/supportfund/setamount?bcid=' . $model->id]],
//                            'pluginEvents' => [
//                                "editableChange" => "function(event, val) { console.log('Changed Value ' + val); }",
//                                "editableSubmit" => "function(event, val, form) { console.log('Submitted Value ' + val); }",
//                                "editableBeforeSubmit" => "function(event, jqXHR) { console.log('Before submit triggered'); }",
//                                "editableSubmit" => "function(event, val, form, jqXHR) { console.log('Submitted Value ' + val); }",
//                                "editableReset" => "function(event) { console.log('Reset editable form'); }",
//                                "editableSuccess" => "function(event, val, form, data) {  history.go(0); }",
//                                "editableError" => "function(event, val, form, data) { console.log('Error while submission of value ' + val); }",
//                                "editableAjaxError" => "function(event, jqXHR, status, message) { console.log(message); }",
//                            ],
//                        ]);
                        ?> 
                    </div>-->
                    <div class="h4 font-weight-bold mb-2">2. भविष्य में आप किस तरह से ऋण वापस करना चाहतीं हैं -</div>
                    <div class="table-responsive-xl " >
                        <table class="table sakhi-tablecstm">
                            <thead>
                                <tr class="bg-success-100 text-center">
                                    <th scope="col" class="th-lg">दैनिक, साप्ताहिक या मासिक</th>
                                    <th scope="col" class="th-lg">कितने रुपये के दर से </th>
                                    <th scope="col" class="th-lg">अंतिम तिथि जिसके पश्चात स्वयं सहायता समूह द्वारा दंड का प्रावधान</th>
                                    <th scope="col" class="th-lg"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>प्रति दिन (कोई निश्चित समय निर्धारित नहीं) </td>
                                    <td>न्यूनतम रुपये 500/-; कम से कम सप्ताह में तीन बार</td>
                                    <td>बीसी सपोर्ट फण्ड प्राप्त होने के तिथि से 1, 095 दिन के अंदर</td>
                                    <td>
                                        <?php
                                        echo CheckboxX::widget([
                                            'name' => 'bc_amount_repay',
                                            'value' => $model->bc_amount_repay == 1 ? 1 : '',
                                            'disabled' => $model->bc_amount_repay ? true : false,
                                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                            'options' => ['id' => 'bc_amount_repay_1' . $model->id, 'confirm_text' => 'प्रति दिन (कोई निश्चित समय निर्धारित नहीं) करने पर सहमत है I', 'bc_amount_repay' => 1, 'bcid' => $model->id, 'ajax_url' => Yii::$app->params['app_url']['sakhi'] . '/bc/supportfund/setrepay?bc_amount_repay=1&bcid=' . $model->id],
                                            'pluginOptions' => ['threeState' => false, 'size' => 'lg']
                                        ]);
                                        ?>    
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>सप्ताह में एक बार (कोई निश्चित दिन निर्धारित नहीं)</td>
                                    <td>न्यूनतम रुपये 500/-</td>
                                    <td>बीसी सपोर्ट फण्ड प्राप्त होने के तिथि से 456 सप्ताह के अंदर</td>
                                    <td><?php
                                        echo CheckboxX::widget([
                                            'name' => 'bc_amount_repay',
                                            'value' => $model->bc_amount_repay == 2 ? 1 : '',
                                            'disabled' => $model->bc_amount_repay ? true : false,
                                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                            'options' => ['id' => 'bc_amount_repay_2' . $model->id, 'confirm_text' => 'सप्ताह में एक बार (कोई निश्चित दिन निर्धारित नहीं) करने पर सहमत है I', 'bc_amount_repay' => 1, 'bcid' => $model->id, 'ajax_url' => Yii::$app->params['app_url']['sakhi'] . '/bc/supportfund/setrepay?bc_amount_repay=2&bcid=' . $model->id],
                                            'pluginOptions' => ['threeState' => false, 'size' => 'lg']
                                        ]);
                                        ?>  </td>
                                </tr>
                                <tr class="text-center">
                                    <td>सप्ताह में दो बार (कोई निश्चित दिन निर्धारित नहीं)</td>
                                    <td></td>
                                    <td>बीसी सपोर्ट फण्ड प्राप्त होने के तिथि से 456 सप्ताह के अंदर</td>
                                    <td><?php
                                        echo CheckboxX::widget([
                                            'name' => 'bc_amount_repay',
                                            'value' => $model->bc_amount_repay == 3 ? 1 : '',
                                            'disabled' => $model->bc_amount_repay ? true : false,
                                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                            'options' => ['id' => 'bc_amount_repay_3' . $model->id, 'confirm_text' => 'सप्ताह में दो बार (कोई निश्चित दिन निर्धारित नहीं) करने पर सहमत है I', 'bc_amount_repay' => 1, 'bcid' => $model->id, 'ajax_url' => Yii::$app->params['app_url']['sakhi'] . '/bc/supportfund/setrepay?bc_amount_repay=3&bcid=' . $model->id],
                                            'pluginOptions' => ['threeState' => false, 'size' => 'lg']
                                        ]);
                                        ?>  </td>
                                </tr>
                                <tr class="text-center">
                                    <td>महीने में दो बार (कोई निश्चित समय निर्धारित नहीं)</td>
                                    <td></td>
                                    <td>बीसी सपोर्ट फण्ड प्राप्त होने के तिथि से 36 माह के अंदर</td>
                                    <td><?php
                                        echo CheckboxX::widget([
                                            'name' => 'bc_amount_repay',
                                            'value' => $model->bc_amount_repay == 4 ? 1 : '',
                                            'disabled' => $model->bc_amount_repay ? true : false,
                                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                            'options' => ['id' => 'bc_amount_repay_4' . $model->id, 'confirm_text' => 'महीने में दो बार (कोई निश्चित समय निर्धारित नहीं) करने पर सहमत है I', 'bc_amount_repay' => 1, 'bcid' => $model->id, 'ajax_url' => Yii::$app->params['app_url']['sakhi'] . '/bc/supportfund/setrepay?bc_amount_repay=4&bcid=' . $model->id],
                                            'pluginOptions' => ['threeState' => false, 'size' => 'lg']
                                        ]);
                                        ?>  </td>
                                </tr>
                                <tr class="text-center">
                                    <td>हर महीने एक बार (कोई निश्चित दिन निर्धारित नहीं)</td>
                                    <td></td>
                                    <td>बीसी सपोर्ट फण्ड प्राप्त होने के तिथि से 36 माह के अंदर</td>
                                    <td><?php
                                        echo CheckboxX::widget([
                                            'name' => 'bc_amount_repay',
                                            'value' => $model->bc_amount_repay == 5 ? 1 : '',
                                            'disabled' => $model->bc_amount_repay ? true : false,
                                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                            'options' => ['id' => 'bc_amount_repay_5' . $model->id, 'confirm_text' => 'हर महीने एक बार (कोई निश्चित दिन निर्धारित नहीं) करने पर सहमत है I', 'bc_amount_repay' => 1, 'bcid' => $model->id, 'ajax_url' => Yii::$app->params['app_url']['sakhi'] . '/bc/supportfund/setrepay?bc_amount_repay=5&bcid=' . $model->id],
                                            'pluginOptions' => ['threeState' => false, 'size' => 'lg']
                                        ]);
                                        ?>  </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class=" mx-2">
                    <a href="<?= '/bc/supportfund/report?bcid=' . $model->id ?>" class="btn btn-info btn-lg btn-block py-2 <?= $url_class ?>"><span>3. इंडिविजुअल रिपोर्ट</span> </a>
                </div>
                <div class="panel-content_cstm h4 ">
                    <?php
                    Pjax::begin([
                        'id' => 'grid-data',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>
                    <?php
                    echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => 'कुल सपोर्ट फण्ड वापसी :  {totalCount}',
                        'emptyText' => 'कोई परिणाम नहीं मिला।',
                        'pager' => [
                            'class' => \yii\bootstrap4\LinkPager::class,
                            'prevPageLabel' => '<span class="fal fa-arrow-left"></span>',
                            'nextPageLabel' => '<span class="fal fa-arrow-right"></span>',
                            'maxButtonCount' => 3,
                        ],
                        'itemView' => '_view',
                    ]);
                    ?>
                    <?php Pjax::end(); ?>  


                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .cbx-disabled {
        color: #000000 !important;

    }
</style>
<?php
$js = <<<js
$(document).ready(function(){
    $('input[type=checkbox]').change(function(){
        var id= '#' + $(this).attr('id'); 
        var ajax_url = $(this).attr('ajax_url');
        var confirm_text=$(this).attr('confirm_text');
        if(this.checked) {
            if (confirm(confirm_text)) {
                $.ajax({
                url: ajax_url,
                type: "POST",
                success: function () {
                history.go(0);
                }
            });
            } else { 
              history.go(0);
            }
        }
    });
});
js;

$this->registerJs($js);
?>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use kartik\tabs\TabsX;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\base\GenralModel;
?>

<div class="row">
    <div class="col-xl-12">
         <?php
                    Pjax::begin([
                        'id' => 'grid-data',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Performance BCs feedback : Total : ' . $feedback['total'] ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">
                   
                    <div class="clearfix pt-3"></div>

                    <?php
                    $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'search-form'
                                ],
                                'id' => 'search-form',
                                'layout' => 'inline',
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_searchfeedback', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <?php ActiveForm::end(); ?>
                    <div class="col-xl-12">
                        <table class="table">
                            <tr>
                                <th width="10%" class="text-90deg-text">ऑपरेशनल समस्यायें (Opertional issues)</th>
                                <td width="90%">
                                    <table style="width:100%">
                                        <tr>
                                            <td width="80%">वर्किंग/ वित्तीय पूँजी की कमी; बैंकिंग का कार्य करने के लिए हाथ में काफ़ी कैश रक़म की ज़रूरत पड़ती है; जिसका अभाव है;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-success color-success-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"  style="width:<?= $feedback['ques16'] > 20 ? $feedback['ques16'] : 20 ?>%" aria-valuenow="<?= $feedback['ques16'] ?>" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques16'] ?>%</div>
                                                </div>
                                            </td>  
                                        </tr>  
                                        <tr>
                                            <td width="80%">हमें हमारे संभावित कस्टमर के बारे कोई जानकारी नहीं है; कौन हमारा कस्टमर हो सकते है या कौन नहीं; इसके बारे में स्पष्ट समझ नहीं है;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-success color-success-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"  style="width:<?= $feedback['ques17'] > 20 ? $feedback['ques17'] : 20 ?>%" aria-valuenow="25" aria-valuemin="<?= $feedback['ques17'] ?>" aria-valuemax="100"><?= $feedback['ques17'] ?>%</div>
                                                </div>
                                            </td>  
                                        </tr> 
                                        <tr>
                                            <td width="80%">कॉल सेंटर पर शिकायत करने पर भी कोई निवारण नहीं होता; ब्लॉक या मिशन मैनेजर/ बीएमएम के पास भी कोई सुनवाई नहीं होती;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-success color-success-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques18'] > 20 ? $feedback['ques18'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques18'] ?>%</div>
                                                </div>
                                            </td>   
                                        </tr> 
                                        <tr>
                                            <td width="80%">मानदेय का भुगतान नियमित नहीं है। कभी कभी एक एक साल तक मानदेय नहीं मिल पाता है – इस से कार्य की शुरुआती समय में काफ़ी दिक़्क़त होती है;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-success color-success-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques19'] > 20 ? $feedback['ques19'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques19'] ?>%</div>
                                                </div>
                                            </td> 
                                        </tr> 
                                        <tr>
                                            <td width="80%">अक्सर कई लोगों द्वारा भ्रष्टाचार/ कमीशन के लिए दवाब बनाया जाता है। ग्राम प्रधान का सहयोग नहीं मिल पाता है । </td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-success color-success-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques20'] > 20 ? $feedback['ques20'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques20'] ?>%</div>
                                                </div>
                                            </td>  
                                        </tr> 
                                    </table>  
                                </td>
                            </tr> 
                        </table>
                    </div> 
                    <div class="col-xl-12">
                        <table class="table">
                            <tr>
                                <th width="10%" class="text-90deg-text">जागरूकता की कमी ( Awareness gap)</th>
                                <td width="90%">
                                    <table style="width:100%">
                                        <tr>
                                            <td width="80%">ग्रामीण कस्टमर्स में हमारे बारे में जागरूकता की कमी। उन्हें बीसी सखियों के माध्यम से बैंकिंग ट्रांजेक्शन करने पर जागरूकता नहीं की गई है।</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-warning color-warning-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques12'] > 20 ? $feedback['ques12'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques12'] ?>%</div>
                                                </div>
                                            </td>  
                                        </tr> 
                                        <tr>
                                            <td width="80%">ग्राम प्रधान भी हमारे पक्ष में आम लॉग में जागरूकता नहीं बढ़ाते हैं; पंचायत सचिवालय में बैठने तक नहीं देते;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-warning color-warning-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques13'] > 20 ? $feedback['ques13'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques13'] ?>%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="80%">बीसी सखी के कार्य-स्थल पर इंटरनेट नेटवर्क की कमी – ट्रांजेक्शन में अक्सर दिक़्क़त आना;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-warning color-warning-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques14'] > 20 ? $feedback['ques14'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques14'] ?>%</div>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td width="80%">मनी-लाउंड्रिंग, फ्रॉड ट्रांजेक्शन व कमाई पर लगनेवाले टैक्स का डर; इस बारे में हमें कोई ख़ास जानकारी भी नहीं दी जाती है; </td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-warning color-warning-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques15'] > 20 ? $feedback['ques15'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques15'] ?>%</div>
                                                </div>
                                            </td>  
                                        </tr>
                                    </table>  
                                </td>
                            </tr> 
                        </table>
                    </div>  
                    <div class="col-xl-12">
                        <table class="table">
                            <tr>
                                <th width="10%" class="text-90deg-text">सेटलमेंट बैंक से जुड़ी समस्यायें (Settlement Bank)</th>
                                <td width="90%">
                                    <table style="width:100%">
                                        <tr>
                                            <td width="80%">सेटलमेंट बैंक का उदासीन व्यवहार – वे हमसे आम कस्टमर की तरह पेश आतें है, लाइन लगाना पड़ता है। ब्रांच में काफ़ी समय लगता है; कभी कभी पूरा दिन का समय लग जाता है;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-info color-info-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques8'] > 20 ? $feedback['ques8'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques8'] ?>%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="80%">बैंक काफ़ी ज़्यादा कस्टमर चार्ज लगाता है जो कभी हमारे बीसी कमीशन के आय से भी ज़्यादा होता है;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-info color-info-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques9'] > 20 ? $feedback['ques9'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques9'] ?>%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="80%">गाँव में ही बैंक या जन सुविधा केंद्र का ब्रांच है; पार्टनर बैंक ने दूसरे एजेंट डिप्लॉय किया हुआ है । इसलिए लोग वहीं से बैंकिंग करना उचित समझते हैं;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-info color-info-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques10'] > 20 ? $feedback['ques10'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques10'] ?>%</div>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td width="80%">कुछ बैंकों द्वारा अन्य बैंकों के साथ ट्रांजेक्शन करना अलाउ ना करना (Offus) _ उदाहरण बैंक ऑफ़ बड़ौदा, सेंट्रल तथा canara बैंक इत्यादि;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-info color-info-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques11'] > 20 ? $feedback['ques11'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques11'] ?>%</div>
                                                </div>
                                            </td> 
                                        </tr>
                                    </table>  
                                </td>
                            </tr> 
                        </table>
                    </div>
                    <div class="col-xl-12">
                        <table class="table">
                            <tr>
                                <th width="10%" class=" text-90deg-text">पार्टनर बैंक से संबद्ध समस्यायें (Problems attributed to partner banks)</th>
                                <td width="90%">
                                    <table style="width:100%">
                                        <tr>
                                            <td width="80%">स्वयं सहायता समूह से 75,000/- रुपये का ऋण मिलने के बाद भी महीनों मशीन नहीं मिला, इसलिए बीसी के तौर पर कार्य नहीं शुरू कर पाना । इस से हमारे ऋण वापसी तथा उनपर बढ़ती ब्याज का दवाब बढ़ता जाता है;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-fusion color-fusion-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques4'] > 20 ? $feedback['ques4'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques4'] ?>%</div>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td width="80%">मशीन चलाना नहीं आता है; लंबे समय तक मशीन ख़राब पड़ा रहता है – सुनवाई नहीं होती है; कोई स्थायी व्यवस्था नहीं है कि मशीनें फंक्शनल रहें;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-fusion color-fusion-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques5'] > 20 ? $feedback['ques5'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques5'] ?>%</div>
                                                </div>
                                            </td> 
                                        </tr> 
                                        <tr>
                                            <td width="80%">पार्टनर बैंकों से ऑपरेशनल जुड़ाव नहीं है, उनसे अपेक्षित मदद का अभाव; उनका हमारे काम पर कोई रुचि नहीं है;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-fusion color-fusion-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques6'] > 20 ? $feedback['ques6'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques6'] ?>%</div>
                                                </div>
                                            </td>  
                                        </tr> 
                                        <tr>
                                            <td width="80%">ट्रांजैक्शंस किए जाने पर कमीशन का दर बहुत ही कम है। अलग अलग बैंकों के कमीशन के दरों में काफ़ी असमानता है;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-fusion color-fusion-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques7'] > 20 ? $feedback['ques7'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques7'] ?>%</div>
                                                </div>
                                            </td>  
                                        </tr> 
                                    </table>  
                                </td>
                            </tr>
                        </table>
                    </div> 
                    <div class="col-xl-12">
                        <table class="table">
                            <tr>
                                <th width="10%" class="text-90deg-text">बीसी सखियों के स्वयं से जुड़े दिक़्क़तें (Issues attributed Sakhis)</th>
                                <td width="90%">
                                    <table style="width:100%">
                                        <tr>
                                            <td width="80%">घर परिवार की ज़िम्मेदारी है, (जैसे छोटे बच्चे का होना, बड़ा परिवार का होना, खेतीबाड़ी तथा अन्य पारिवारिक व्यवसाय में व्यस्तता इत्यादि)</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-danger color-danger-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques1'] > 20 ? $feedback['ques1'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques1'] ?>%</div>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td width="80%">घर से निकलने में दिक़्क़त है – जो कस्टमर घर पर आ जाते हैं, उनके साथ ही बैंकिंग ट्रांजेक्शन संभव है; बाहर निकल कर बीसी का कार्य नहीं कर पाते हैं;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-danger color-danger-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques2'] > 20 ? $feedback['ques2'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques2'] ?>%</div>
                                                </div>
                                            </td>  
                                        </tr> 
                                        <tr>
                                            <td width="80%">घर से अपेक्षित सहयोग नहीं मिल पाता है – बैंकिंग कार्य करने के लिए स्वयं का स्मार्ट फ़ोन भी उपलब्ध ना होता है;</td> 
                                            <td width="20%">
                                                <div class="progress progress-xl bg-danger color-danger-800 progress-bar-animated">
                                                    <div class="progress-bar " role="progressbar"   style="width:<?= $feedback['ques3'] > 20 ? $feedback['ques3'] : 20 ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $feedback['ques3'] ?>%</div>
                                                </div>
                                            </td>  
                                        </tr> 
                                    </table>  
                                </td>
                            </tr> 
                        </table>
                    </div>      
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
   
JS;
                    $this->registerJs($script);
                    ?>
                   
                </div>
            </div>

        </div>  
         <?php Pjax::end(); ?>
    </div>
</div>
<?php
$css = <<<cs
 .text-90deg-text{
  transform: translateX(-10%) translateY(5%) rotate(-90deg);
}
.progress-bar{
font-size:18px
 }  
cs;
$this->registerCss($css);
?>        
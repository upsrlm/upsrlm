<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
//common\assets\FioriSrlmAsset::register($this);
$this->title = 'Technology';
$this->params['breadcrumbs'][] = $this->title;
?>
   <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?= $this->title ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div style="min-height: 650px">
        <div class="container-fluid px-3 px-lg-5 py-4">
            <div class="row mb-4 align-items-center">
                <div class="col-lg-7">
                    <div class="section-heading logo_img mb-2" style="text-align: left;">
                        <img src="/images/upsakhi.webp" alt="">
                        <h2>UP <em>BCSakhi</em></h2>
                    </div>
                    <p>Uttar Pradesh State Rural Livelihood Mission (UPSRLM), is an arm of the Department of Rural Development, Uttar Pradesh, has decided to shortlist and select candidates for BC (Banking Correspondent) Sakhis to be assigned in each of the State’s 3,534 Gram Panchayats from were no applications received. This app is approved by UPSRLM for prospective candidates for submitting their applications after being registered. The App, as per the notification of UPSRLM, DoRD, is to be launched on May 25th 2022 and the date for closure of submission of application is August 26th 2023. Candidates would have to be residents of the GP they want to apply for. </p>
                    <div class="app-store-btns">
                        <a class="google" href="https://play.google.com/store/apps/details?id=com.up.srlm.bcselection&hl=en_IN&gl=US">Google Play </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="right_img">
                        <img src="/images/Mockup.png" alt="" class="imgHight w-100">
                    </div>
                </div>
            </div>
            <div class="row my-2 align-items-center">
                <div class="col-lg-5 order-lg-1 order-2">
                    <div class="right_img">
                        <img src="/images/rishtamobile.png" alt="" class="imgHight w-100">
                    </div>
                </div>
                <div class="col-lg-7 order-lg-2 order-1">
                    <div class="section-heading logo_img mb-2" style="text-align: left;">
                        <img src="/images/unnamed.webp" alt="">
                        <h2>RISHTA</h2>
                    </div>
                    <p>RISHTA/ रिश्ता मोबाइल ऐप उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन, ग्राम विकास विभाग, उत्तर प्रदेश शासन से समर्थित त्वरित ग़रीबी उन्मूलन व सरकारी योजनाओं के लाभ स्वयं सहायता समूहों (SHG/ एसएचजी) के सदस्यों को आसान तरीक़े से पहुँचाने का एक अनोखा प्रयास है । इस ऐप के माध्यम से मिशन से जुड़े सभी एसएचजी बिना किसी मानवीय मध्यस्थता के टेक्नॉलजी-आधारित माध्यमों से स्वयं योजनाओं के लाभ पा सकेंगे; उन्हें सरकारी कार्यालयों में अनावश्यक दौड़ना नहीं पड़ेगा, उनका समय, ऊर्जा व पैसा बचेगा । रिश्ता ऐप के कुछ प्रमुख सुविधाएँ हैं - (१) सरकारी लाभों की जानकारी, आवेदन भरना तथा लाभ प्राप्त करना मोबाइल ऐप से हो पाएगा, समूह सखी ये कार्य करेंगी; (२) योजनाओं लाभों की पूर्व सूचना मोबाइल ऐप पर सीधे पहुँचेंगी; (३) सभी योजनाओं के वित्तीय लाभ का भुगतान समूह सदस्यों के खाते में बिना किसी और के मध्यस्थता के सम्पन्न होगी । इससे ना सिर्फ़ ग्रामीणों को योजनाओं के लाभ तक सहज पहुँच सम्भव होगी, भ्रष्टाचार, उत्कोच का लेनदेन में नहीं हो पाएगी ।</p>
                    <div class="app-store-btns">
                        <a class="google" href="https://play.google.com/store/apps/details?id=com.triline.upsrlm.rishta">Google Play </a>
                    </div>
                </div>

            </div>
            <div class="row my-4 align-items-center">
            <div class="col-lg-7">
                <div class="section-heading logo_img mb-2" style="text-align: left;">
                    <img src="/images/mopup.webp" alt="">
                    <h2>MoP-<em>UP</em></h2>
                </div>
                <p>MoP-UP app is promoted by Uttar Pradesh State Rural Livelihood Mission (UPSRLM) an extended schematic arm of Department of Rural Development (DoRD), Government of Uttar Pradesh (GoUP). UPSRLM is mandated to implement DAY National Rural Livelihood Mission, of Ministry of Rural Development (MoRD), Government of India (GOI). </p>
                <p>The app, in integral part of UPSRLM’s technology platform, intends to integrate Gram Pradhans, other village-level functionaries.</p>
                <div class="app-store-btns">
                    <a class="google" href="https://play.google.com/store/apps/details?id=com.triline.upsrlm.mopup" target="_blank">Google Play </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="right_img">
                    <img src="/images/mopupmobile.png" alt="" class="imgHight w-100">
                </div>
            </div>
        </div>
        </div>
    </div>

<?php
//$css = <<<cs
//
//@media(min-width:1300px){
//	.right_img img{
//		width: 531px !important;
//		height: 531px !important;
//		text-align: center !important;
//		filter: drop-shadow(-2px 22px 10px #000000);
//	  }
//	
//
//  }
//cs;
//$this->registerCss($css);
?>


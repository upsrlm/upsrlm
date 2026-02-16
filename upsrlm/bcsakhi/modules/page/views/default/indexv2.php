<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\WebApplication;
use common\models\master\MasterRole;

?>


<!-- Banner Starts Here -->
<div class="main-banner header-text" id="top">
    <div class="Modern-Slider">
        <div class="item item-1">
            <div class="img-fill">
            </div>
        </div>
        <div class="item item-2">
            <div class="img-fill">
            </div>
        </div>
        <div class="item item-3">
            <div class="img-fill">
            </div>
        </div>
        
        
    </div>
</div>
<!-- Banner Ends Here -->

<!-- 
        <?php
        echo yii\bootstrap4\Carousel::widget([
            'items' => [
                '<img src="/images/s6.jpg" style="width:100%"/>',
                '<img src="/images/s0.jpg" style="width:100%"/>',
                '<img src="/images/s3.jpg" style="width:100%"/>',
                '<img src="/images/s6.jpg" style="width:100%"/>',
            ]
        ]);
        ?>    -->

<div class="partners mt-0">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="title">
                    <h3>BC Sakhi </h3>
                </div>
                <p> Department of Rural Development (DoUD), Government of Uttar Pradesh (GoUP) has launched a scheme for appointing one Business Correspondent Sakhi (BC) in each of the State’s 58,000 Gram Panchayats (GP). Approx. 2.167 lakh BC applications received, UPSRLM has shortlisted 56,825 BC candidates for

                    उत्तर प्रदेश के मुख्यमंत्री जी ने कहा है कि UP BC Sakhi Yojana के अंतर्गत ग्रामीण क्षेत्रों की महिलाएं अब डिजिटल मोड के माध्यम से लोगों के घर पर बैंकिंग सेवाएं और पैसे का लेनदेन करेंगी। जिससे ग्रामीण लोगो को भी सुविधाएं होंगी और महिलाओ को भी रोजगार मिलेगा | नई यूपी बैंकिंग संवाददाता सखी योजना से ग्रामीण महिलाओं को कमाई के लिए काम करने में मदद मिलेगी | इन महिलाओ को (बैंकिंग कॉरेस्पॉन्डेंट सखी) को 6 महीने तक 4 हजार रुपये की धनराशि प्रति माह सरकार द्वारा दी जाएगी | इसके अलावा बैंक से भी महिलाओ को लेनदेन पर कमिशन मिलेगा | जिससे उनकी हर महीने आय निश्चित हो जाएगी।</p>

            </div>
            <div class="col-md-5">           
                    <div class="title">
                        <h3>Youtube</h3>
                    </div>
                <div class="panel-body h-100">
                    <iframe class="responsive-iframe" src="https://www.youtube.com/embed/zZP5J2lpnYU?controls=0" width="100%" height="90%">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="services">
    <div class="container2">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h2>Top 20 Highest commission earned <em>BC Sakhi</em></h2>
                </div>
            </div>
            <?php foreach ($top_20_bc as $bc) { ?>
                <div class="col-md-12">
                    <?= bcsakhi\components\widget\bc\Sakhiv2Widget::widget(['model' => $bc]) ?>
                </div>
            <?php } ?>

        </div>
    </div>
</div>



</div>

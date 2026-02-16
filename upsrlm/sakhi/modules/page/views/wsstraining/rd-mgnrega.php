<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use common\models\master\MasterRole;

$this->title = 'MGNREGA - महात्मा गाँधी राष्ट्रीय ग्रामीण रोजगार गारंटी योजना';
$section_form_url = '/page/wsstraining';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <p>लाभ : 1दिन से 100 दिन तक रोजगार प्रति परिवार रूपए 201 से 20100 तक लाभ मिलता है । और 33% महिलाओ के लिए काम की प्राथमिकता मिलती है । </p>
                    <h4>
                        पात्रता
                    </h4>
                     <img class="d-block w-100" src="<?= '/images/labour1.png' ?>" alt="">
                    <div>
                        <ul>
                            <li>पात्र ग्राम पंचायत का निवासी हो; आयु 18 वर्ष से अधिक और काम करने करने के लिए इच्छुक हों ।</li>   
                            <li>MGNREGA में एक वर्ष में कम से कम 90 दिन तक कार्य किया हो ।</li> 
                            <li>स्वयं या अभिभावक का श्रम विभाग के “उत्तर प्रदेश भवन एवं अन्य सन्निर्माण कर्मकार कल्याण बोर्ड” (BOCW) में पंजीकृत हों ।</li> 
                            
                        </ul>
                    </div>

                    <div>


                        <a href="<?= $section_form_url . '/rd-mgnrega-feedback' ?>" class="btn btn-success btn-block "><span>प्रतिक्रियाा</span> </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$demand_application= \common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaDa::find()->where(['mgnrega_scheme_id'=>$model->id])->limit(1)->orderBy('created_at desc')->one();

?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    if ($model->current_mgnrega_beneficiary == 1 || $model->current_mgnrega_beneficiary_interested_work == 1 and $model->status == 2) {
                        ?>
                        <?php
                        if ($demand_application != null) {

                            echo $this->render('_demandapplication_view', ['model' => $demand_application]);
                        }
                        ?>

                    <?php } ?>
                    <div class="col-md-12">
                        <p><span class="formlabel">1). क्या आप मनरेगा योजना का लाभ प्राप्त कर रहे हैं?: </span><?= $model->yesnooption('current_mgnrega_beneficiary') ?></p>
                        <p><span class="formlabel">2). क्या आप MGNREGA में काम करने को इच्छुक है?: </span><?= $model->yesnooption('current_mgnrega_beneficiary_interested_work') ?></p>
                        <p><span class="formlabel">3). अगर इच्छुक हैं तो कितने दिन के लिए काम चाहिए?: </span><?= $model->workdaylabel ?></p>
                    </div>
                    <?php
                    if ($model->current_mgnrega_beneficiary == 1 || $model->current_mgnrega_beneficiary_interested_work == 1) :
                        ?>
                        <div class="col-lg-12">
                            <p class="formlabel">1). आवेदकों का ब्योरा </p>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>क्र. सं.</th>
                                            <th>नाम</th>
                                            <th>आयु</th>
                                            <th>लिंग</th>
                                            <th>काम करने के इच्छुक</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($model->formapplicants) {
                                            $srn = 1;
                                            foreach ($model->formapplicants as $applicant) {
                                                ?>
                                                <tr>
                                                    <td><?= $srn ?></td>
                                                    <td><?= $applicant->name ?></td>
                                                    <td><?= $applicant->age ?></td>
                                                    <td><?= $applicant->genderlabel ? $applicant->genderlabel->name_hi : '' ?></td>
                                                    <th>हाँ</th>
                                                </tr>
                                                <?php
                                                $srn++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <p><span class="formlabel">2). मकान नम्बर : </span><?= $model->house_no ?></p>
                            <p><span class="formlabel">3). ग्राम का नाम : </span><?= $model->village_name ?></p>
                            <p><span class="formlabel">4). ग्राम पंचायत का नाम : </span><?= $model->gram_panchayat_name ?></p>
                            <p><span class="formlabel">5). ब्लॉक का नाम : </span><?= $model->block_name ?></p>
                            <p><span class="formlabel">6). परिवार के मुखिया का नाम : </span><?= $model->family_head_name ?></p>
                            <p><span class="formlabel">7). श्रेणी : </span><?= $model->caste_category_name ?></p>
                            <p><span class="formlabel">8). क्या परिवार अल्पसंख्यक है : </span><?= $model->yesnooption('minority_family') ?></p>
                            <p><span class="formlabel">9). क्या आई ए वाई (इंदिरा आवास योजना) लाभार्थी हैं : </span><?= $model->yesnooption('iay_beneficiary') ?></p>
                            <p><span class="formlabel">10). क्या भूमि सुधार लाभार्थी हैं : </span><?= $model->yesnooption('land_reforms') ?></p>
                            <p><span class="formlabel">11). क्या लघु कृषक या सीमांत कृषक हैं : </span><?= $model->yesnooption('small_marginal_farmers') ?></p>
                            <p><span class="formlabel">12). क्या लाभार्थी अनुसूचित जनजाति या अन्य परम्परागत बनवासी हैं : </span><?= $model->yesnooption('st_or_tribal') ?></p>
                            <p><span class="formlabel">13). क्या बीपीएल (below poverty line) परिवार हैं : </span><?= $model->yesnooption('bpl_family') ?></p>
                            <p><span class="formlabel">14). क्या आर एस बी वाई/ आई लाभार्थी हैं : </span><?= $model->yesnooption('rsbyi_beneficiary') ?></p>
                            <p><span class="formlabel">15). क्या आम आदमी बीमा योजना (एएबीवाई) के लाभार्थी हैं : </span><?= $model->yesnooption('aaby_beneficiary') ?></p>
                            <p><span class="formlabel">16). बीपीएल परिवार सर्वेक्षण/ सामाजिक आर्थिक जाति जन गणना (एसईसीसी) के अनुसार परिवार आईडी : </span><?= $model->bpl_secc_id ?></p>
                            <p><span class="formlabel">17). मोबाइल नम्बर जिस पर परिवार को एस एम एस (SMS) के माध्यम से जानकारी दी जा सके : </span><?= $model->mobile_number ?></p>
                            <?php if ($model->status == 2) : ?>
                                <p><span class="formlabel">18). आवेदन पत्र जमा करने की तिथि : </span><?= $model->form_complete_date ?></p>
                                <br>
                                <p><span class="formlabel">मैं/ हम/ प्रमाणित करता हूँ/ करते हैं/, कि उपरोक्त दी गई जानकारी सही है</span></p>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <div class="col-lg-12 mb-3">
                            <p><span class="formlabel">4). आवेदन पत्र जमा करने की तिथि : </span><?= $model->form_complete_date ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($model->current_job_card_photo != null) { ?>
                        <div class='card'>
                            <div class="col-lg-12">  
                                <label for="applicationform-training">जॉब कार्ड का सीधा और स्पष्ट फोटो </label>
                                <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                                    <?= $model->current_job_card_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->jabcard_photo_url . '" data-src="' . $model->jabcard_photo_url . '"  class="lozad" title="आधार फ्रंट फोटो"/>
                                        </span> ' : '-' ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  
    .formlabel {
        font-weight:bold;
    }

CSS;
$this->registerCss($style);
?>
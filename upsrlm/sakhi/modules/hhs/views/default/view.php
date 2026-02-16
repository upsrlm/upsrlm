<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\bootstrap4\Modal;
use yii\grid\GridView;
use common\models\master\MasterRole;
use common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey;
use kartik\dialog\Dialog;
use kartik\dialog\DialogAsset;
use kartik\export\ExportMenuAsset;

DialogAsset::register($this);
ExportMenuAsset::register($this);
$this->title = 'अति गरीब परिवार विवरण';
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="nfsa-base-survey-view h4">
    <div class="panel panel-info cstm-img">
        <div class="row">
            <div class="col-lg-12 mx-1">
                <div class='box-header blue-background ext-center'>
                    <div class='text-center'><?= $model->formstatus ?></div>

                </div>
            </div> 
            <?php if($model->formdup){ ?>
            <div class="col-lg-12 mx-1 mt-1">
             <div class='text-center'><?= $model->formdup ?></div>
            </div>
            <?php } ?>
            <div class="col-lg-12 mx-1 mt-1">
                <div class='card px-2'>

                    <label class="bold_lable"> परिवार की मुखिया का प्रोफाइल फोटो </label>

                    <?php if (isset($model->photo_of_eligible_household)) { ?>
                        <img id="member_photo-image_old" src="<?= $model->image_photo_of_eligible_household ?>" data-src="<?= $model->image_photo_of_eligible_household ?>"  alt="<?= $model->photo_of_eligible_household ?>" class="img-responsive mb-2" width="100%" height="auto">
                    <?php } ?>

                </div>
            </div>
            <div class="col-lg-12 mx-1">
                <div class='card px-2'>

                    <label class="bold_lable"> पासबुक फोटो </label>
                    <?php if (isset($model->passbook_photo)) { ?>
                        <img id="passbook_photo-image_old" src="<?= $model->image_passbook_photo ?>" alt="<?= $model->passbook_photo ?>" class="img-responsive mb-2" width="100%" height="auto">
                    <?php } ?>

                </div>
            </div>
            <div class="col-lg-12 mx-1">
                <div class='card px-2'>

                    <label class="bold_lable"> आधार फ्रंट फोटो  </label>
                    <?php if (isset($model->aadhar_card_front)) { ?>
                        <img id="aadhar_front_photo-image_old" src="<?= $model->image_aadhar_card_front ?>" alt="<?= $model->aadhar_card_front ?>" class="img-responsive mb-2" width="100%" height="auto">
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-12 mx-1">
                <div class='card px-2'>

                    <label class="bold_lable"> आधार बैक फोटो   </label>                      
                    <?php if (isset($model->aadhar_card_back)) { ?>
                        <img id="aadhar_back_photo-image_old" src="<?= $model->image_aadhar_card_back ?>" alt="<?= $model->aadhar_card_back ?>" class="img-responsive mb-2" width="100%" height="auto">
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-12 mx-1">
                <div class='card px-2'>

                    <label class="bold_lable"> मुखिया/ परिवार के सदस्य के साथ आवासीय घर का फोटो  </label> 
                    <?php if (isset($model->house_photo_full_frame)) { ?>
                        <img id="aadhar_back_photo-image_old" src="<?= $model->image_house_photo_full ?>" alt="<?= $model->house_photo_full_frame ?>" class="img-responsive mb-2" width="100%" height="auto">
                    <?php } ?>


                </div>
            </div>
            <?php if ($model->area == common\models\base\GenralModel::AREA_RURAL) { ?>

                <div class="col-md-4 mx-1">
                    <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                        <div class='box-header blue-background'>
                            <div class='text-center'>1. उत्तरदाता/ के प्रकार</div>

                        </div>
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th>{label}</th><td class="font-weight-bolder">{value}</td></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'Types Of Respondents1',
                                    'visible' => $model->area == 1,
                                    'label' => 'उत्तरदाता के प्रकार',
                                    'format' => 'html',
                                    'value' => $model->respondents,
                                ],
                            ],
                        ]);
                        ?>
                    </div>

                    <div class='box bordered-box blue-border ' style='margin-bottom:0;'>
                        <div class='box-header blue-background'>
                            <div class='text-center'>2. निवास/ गृह स्थल</div>

                        </div>
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th>{label}</th><td class="font-weight-bolder">{value}</td></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'residence',
                                    'visible' => $model->area == 1,
                                    'label' => 'निवास/ गृह स्थल',
                                    'format' => 'html',
                                    'value' => $model->relresidence != null ? $model->relresidence->hindi_name : '-',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class='col-md-4 mx-1'>
                    <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                        <div class='box-header blue-background'>
                            <div class='text-center'>3. भोजन कार्यक्रम</div>

                        </div>
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th>{label}</th><td class="font-weight-bolder">{value}</td></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'ration_card',
                                    'label' => 'राशन कार्ड है?',
                                    'format' => 'html',
                                    'value' => $model->rationcardv,
                                ],
                                [
                                    'attribute' => 'ration_card_type',
                                    'label' => 'अगर हाँ तो राशन कार्ड का प्रकार',
                                    'format' => 'html',
                                    'value' => $model->rationcardtv,
                                ],
                                [
                                    'attribute' => 'food_program_mid_day_meal',
                                    'visible' => $model->area == 1,
                                    'label' => 'मिड डे मील कार्यक्रमों तक पहुँच?',
                                    'format' => 'html',
                                    'value' => $model->foodprogrammiddaymeal != null ? $model->foodprogrammiddaymeal->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'food_program_icd_services',
                                    'visible' => $model->area == 1,
                                    'label' => 'समेकित बाल विकास सेवाएं (ICDS) कार्यक्रमों तक पहुँच?',
                                    'format' => 'html',
                                    'value' => $model->foodprogramicdservices != null ? $model->foodprogramicdservices->hindi_name : '-',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-md-4 mx-1">
                    <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                        <div class='box-header blue-background'>
                            <div class='text-center'>4. परिसंपत्ति</div>

                        </div>
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th>{label}</th><td class="font-weight-bolder">{value}</td></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'type_of_asset_house1',
                                    'visible' => $model->area == 1,
                                    'label' => 'आवासीय स्थिति [ आवास की गुणवत्ता ]',
                                    'format' => 'raw',
                                    'value' => $model->house != null ? $model->house->hindi_name . ' [ ' . $model->housetype->hindi_name . ' ] ' : '-',
                                ],
//                               
                                [
                                    'attribute' => 'type_of_asset_land',
                                    'visible' => $model->area == 1,
                                    'label' => 'भूमि',
                                    'format' => 'html',
                                    'value' => $model->land != null ? $model->land->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'small_animals_numbers',
                                    'visible' => $model->area == 1,
                                    'label' => 'छोटे पशु (सूअर, बकरी/ चूहे)  [ उपयोगिता ] ',
                                    'format' => 'html',
                                    'value' => $model->smallanimalsnumbers != null ? $model->smallanimalsnumbers->hindi_name . '<br/>' . $model->smallanimalsuse . '' : '-',
                                ],
//                               
                                [
                                    'attribute' => 'big_animals_numbers',
                                    'visible' => $model->area == 1,
                                    'label' => 'बड़े पशु (भैंस/ गाय/ ऊँट) [ उपयोगिता ] ',
                                    'format' => 'html',
                                    'value' => $model->biganimalsnumbers != null ? $model->biganimalsnumbers->hindi_name . ' <br/>' . $model->biganimalsuse . '' : '-',
                                ],
//                               
                                [
                                    'attribute' => 'birds_animals_numbers',
                                    'visible' => $model->area == 1,
                                    'label' => 'पक्षी: देशी मुर्गी/ बत्तख [ उपयोगिता  ]',
                                    'format' => 'html',
                                    'value' => $model->birdsanimalsnumbers != null ? $model->birdsanimalsnumbers->hindi_name . '<br/>' . $model->birdsanimalsuse . '' : '-',
                                ],
//                                
                                [
                                    'attribute' => 'mechanized_equipment',
                                    'label' => 'यंत्रीकृत उपकरण',
                                    'format' => 'html',
                                    'value' => $model->mechanizedequipment != null ? $model->mechanizedequipment->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'mechanized_vehicle',
                                    'label' => 'यंत्रीकृत वाहन/ मोटरसाइकिल',
                                    'format' => 'html',
                                    'value' => $model->mechanizedvehicle != null ? $model->mechanizedvehicle->hindi_name : '-',
                                ],
//                                [
//                                    'attribute' => 'created_by',
//                                    'label' => 'Enumerator',
//                                    'format' => 'html',
//                                    'value' => $model->enumerator != null ? ($model->enumerator->name . "</br/>" . $model->enumerator->mobile_no) : '',
//                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-md-4 mx-1">
                    <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                        <div class='box-header blue-background'>
                            <div class='text-center'>5. रोज़गार/ सामाजिक सुरक्षा (safetynet)</div>

                        </div>
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th>{label}</th><td class="font-weight-bolder">{value}</td></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'ess_nrega_job_card',
                                    'visible' => $model->area == 1,
                                    'label' => 'नरेगा जॉब कार्ड है?',
                                    'format' => 'html',
                                    'value' => $model->essnregajobcard != null ? $model->essnregajobcard->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'get_pension_yes_no',
                                    'visible' => $model->area == 1,
                                    'label' => '  पेंशन मिलता हैं? ',
                                    'format' => 'html',
                                    'value' => $model->pensionyesno != null ? $model->pensionyesno->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'ayushman_india',
                                    'visible' => $model->area == 1,
                                    'label' => 'आयुष्मान भारत',
                                    'format' => 'html',
                                    'value' => $model->ayushmanindia != null ? $model->ayushmanindia->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'ess_nrega_demand_application',
                                    'visible' => $model->area == 1,
                                    'label' => 'कभी मांग प्रपत्र (Demand application) भरवाया गया ?',
                                    'format' => 'html',
                                    'value' => $model->demandapplication != null ? $model->demandapplication->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'narega_day_work',
                                    'visible' => $model->area == 1,
                                    'label' => 'पिछले दो वर्षों में कितना कुल कार्य मिला',
                                    'format' => 'html',
                                    'value' => $model->naregadaywork != null ? $model->naregadaywork->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'payments_received',
                                    'visible' => $model->area == 1,
                                    'label' => 'भुगतान प्राप्त हुआ',
                                    'format' => 'html',
                                    'value' => $model->paymentsreceived != null ? $model->paymentsreceived->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'get_pension',
                                    'visible' => $model->area == 1,
                                    'label' => 'पेंशन का Type',
                                    'format' => 'html',
                                    'value' => $model->pensiontype != null ? $model->pensiontype->hindi_name : '-',
                                ],
                                [
                                    'attribute' => 'profit_received_in_the_last_2_years',
                                    'visible' => $model->area == 1,
                                    'label' => 'भुगतान प्राप्ति (गत 2 वर्षों में)',
                                    'format' => 'html',
                                    'value' => $model->payment2years != null ? $model->payment2years->hindi_name : '-',
                                ],
                            ],
                        ]);
                        ?>
                    </div>

                </div>




            <?php } ?>

        </div>
        <br>


        <div class="row">

            <div class="col-md-6 mx-1">
                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                    <div class='box-header blue-background'>
                        <div class='text-center'>भाग दो: राष्ट्रीय खाद्य सुरक्षा क़ानून के प्रावधानों के अन्तर्गत सूचनाएँ</div>
                    </div>
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th>{label}</th><td class="font-weight-bolder">{value}</td></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'tax_payers',
                                'label' => 'क्या आयकर दाता हैं?',
                                'format' => 'html',
                                'value' => $model->taxpayers != null ? $model->taxpayers->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'wheeler_in_the_family',
                                'label' => 'परिवार में चार पहिया वाहन है?',
                                'format' => 'html',
                                'value' => $model->wheelerinthefamily != null ? $model->wheelerinthefamily->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'tractor',
                                'label' => 'परिवार में ट्रेक्टर है?',
                                'format' => 'html',
                                'value' => $model->reltractor != null ? $model->reltractor->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'family_has_a_harvester',
                                'label' => 'परिवार में हार्वेस्टर है?',
                                'format' => 'html',
                                'value' => $model->familyhasaharvester != null ? $model->familyhasaharvester->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'ac',
                                'label' => 'परिवार में ए सी है?',
                                'format' => 'html',
                                'value' => $model->relac != null ? $model->relac->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'generator',
                                'label' => 'परिवार में 5 के वि ए या उससे  अधिक का जनरेटर है?',
                                'format' => 'html',
                                'value' => $model->relgenerator != null ? $model->relgenerator->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'irrigated_land',
                                'label' => 'परिवार के समस्त सदस्यों के पास कुल सिंचित भूमि (एकड़ में)',
                                'format' => 'html',
                                'value' => $model->irrigated_land,
                            ],
                            [
                                'attribute' => 'number_of_licenses',
                                'label' => 'परिवार के पास कुल उपलब्ध शस्त्र लाइसेंसों की संख्या',
                                'format' => 'html',
                                'value' => $model->survey == 1 ? $model->number_of_licenses : $model->number_of_licenses,
                            ],
                        ],
                    ]);
                    ?>
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th>{label}</th><td class="font-weight-bolder">{value}</td></tr>',
                        'attributes' => [
//                                [

                            [
                                'attribute' => 'beggar',
                                'label' => '(क) भिक्षावृत्ति करने वाले',
                                'format' => 'html',
                                'value' => $model->relbeggar != null ? $model->relbeggar->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'domestic_workers',
                                'label' => '(ख) दूसरे के घरों में घरेलू कामकाज करने वाले',
                                'format' => 'html',
                                'value' => $model->domesticworkers != null ? $model->domesticworkers->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'shoe_slippers_worker',
                                'label' => '(ग) जूते चप्पल की मरम्मत करने वाले',
                                'format' => 'html',
                                'value' => $model->shoeslippersworker != null ? $model->shoeslippersworker->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'hauliers_hawkers_rickshaw_pullers',
                                'label' => '(घ) फेरी लगाने वाले/ खोमचे वाले/ रिक्शा चालक आदि',
                                'format' => 'html',
                                'value' => $model->hauliershawkersrickshawpullers != null ? $model->hauliershawkersrickshawpullers->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'suffering_from_leprosy_cancer_aids',
                                'label' => '(च) कुष्ठ रोग/ कैंसर/ एड्स से पीड़ित',
                                'format' => 'html',
                                'value' => $model->sufferingfromleprosycanceraids != null ? $model->sufferingfromleprosycanceraids->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'orphans',
                                'label' => '(छ) अनाथ/ माता पिता विहीन बच्चे',
                                'format' => 'html',
                                'value' => $model->relorphans != null ? $model->relorphans->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'cleaner',
                                'label' => '(ज) स्वच्छ्कार',
                                'format' => 'html',
                                'value' => $model->relcleaner != null ? $model->relcleaner->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'daily_salaried_laborers',
                                'label' => '(झ) दैनिक वेतनभोगी मजदूर यथा- कुली पल्लेदार आदि',
                                'format' => 'html',
                                'value' => $model->dailysalariedlaborers != null ? $model->dailysalariedlaborers->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'families_of_landless_laborers',
                                'label' => 'भूमिहीन मजदूरों के परिवार',
                                'format' => 'html',
                                'value' => $model->familiesoflandlesslaborers != null ? $model->familiesoflandlesslaborers->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'below_poverty_line',
                                'label' => 'गरीबी रेखा से नीचे जीवन यापन करने वाले परिवार (राजस्व विभाग के अद्यावधिक आय के प्रमाणपत्र के आधार पर)',
                                'format' => 'html',
                                'value' => $model->belowpovertyline != null ? $model->belowpovertyline->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'abandoned_women',
                                'label' => 'परित्यक्त महिलाऐं',
                                'format' => 'html',
                                'value' => $model->abandonedwomen != null ? $model->abandonedwomen->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'family_headed_by_destitute_woman',
                                'label' => 'परिवार जिसकी मुखिया निराश्रित महिला, विकलांग अथवा मानसिक रूप से विक्षिप्त व्यक्ति है एवं इस परिवार में कोई अन्य बालिग़ पुरुष नहीं है',
                                'format' => 'html',
                                'value' => $model->familyheadedbydestitutewoman != null ? $model->familyheadedbydestitutewoman->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'housingless_families',
                                'label' => 'आवासविहीन परिवार एवं ऐसे परिवार जिनके स्वामित्व में 30 वर्ग मी क्षेत्रफल तक के ऐसे कच्चे आवास हों जो उनकी निजी भूमि पर हों तथा जिनमे वो स्वयं निवास करते हों',
                                'format' => 'html',
                                'value' => $model->housinglessfamilies != null ? $model->housinglessfamilies->hindi_name : '-',
                            ],
                        ],
                    ]);
                    ?>
                </div>

            </div>

            <div class="col-md-6 mx-1">
                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                    <div class='box-header blue-background'>
                        <div class='text-center'>पार्ट 3: किन सुविधाओं का लाभ मिलता है/ नहीं मिलता है?</div>
                    </div>
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th>{label}</th><td class="font-weight-bolder">{value}</td></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'personal_features_accommodation',
                                'label' => 'आवास (ग्राम्य विकास विभाग)',
                                'format' => 'html',
                                'value' => $model->getColumnvalue('personal_features_accommodation'),
                            ],
                            [
                                'attribute' => 'personal_features_toilet',
                                'label' => 'शौचालय (पंचायती राज विभाग)',
                                'format' => 'html',
                                'value' => $model->getColumnvalue('personal_features_toilet'),
                            ],
                            [
                                'attribute' => 'personal_features_structure_building_under_narega',
                                'label' => 'नरेगा के तहत संरचना निर्माण (ग्राम्य विकास विभाग)',
                                'format' => 'html',
                                'value' => $model->getColumnvalue('personal_features_structure_building_under_narega'),
                            ],
                            [
                                'attribute' => 'personal_features_connection_of_tap_water',
                                'label' => 'नल से जल का कनेक्शन (ग्रामीण जलापूर्ति व नमामि गंगे)',
                                'format' => 'html',
                                'value' => $model->getColumnvalue('personal_features_connection_of_tap_water'),
                            ],
                            [
                                'attribute' => 'other_features_ration',
                                'label' => 'राशन',
                                'format' => 'html',
                                'value' => $model->getOtherfeaturesvalue('other_features_ration'),
                            ],
                            [
                                'attribute' => 'other_features_economic_benefits_of_schooling',
                                'label' => 'स्कूली शिक्षा से जुड़े आर्थिक लाभ',
                                'format' => 'html',
                                'value' => $model->getOtherfeaturesvalue('other_features_economic_benefits_of_schooling'),
                            ],
                            [
                                'attribute' => 'other_features_kisan_samman',
                                'label' => 'किसान सम्मान',
                                'format' => 'html',
                                'value' => $model->getOtherfeaturesvalue('other_features_kisan_samman'),
                            ],
                            [
                                'attribute' => 'other_features_benefits_provided_labor_department',
                                'label' => 'श्रम विभाग द्वारा प्रदत्त लाभ',
                                'format' => 'html',
                                'value' => $model->getOtherfeaturesvalue('other_features_benefits_provided_labor_department'),
                            ],
                            [
                                'attribute' => 'other_features_labor_worker_work_in_narega',
                                'label' => 'नरेगा में श्रम कामगार का काम',
                                'format' => 'html',
                                'value' => $model->getOtherfeaturesvalue('other_features_labor_worker_work_in_narega'),
                            ],
                            [
                                'attribute' => 'other_features_benefits_associated_upsrlm',
                                'label' => 'उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन से जुड़े लाभ',
                                'format' => 'html',
                                'value' => $model->getOtherfeaturesvalue('other_features_benefits_associated_upsrlm'),
                            ],
                            [
                                'attribute' => 'other_features_benefits_of_social_welfare_department',
                                'label' => 'समाज कल्याण विभाग के लाभ',
                                'format' => 'html',
                                'value' => $model->getOtherfeaturesvalue('other_features_benefits_of_social_welfare_department'),
                            ],
                            [
                                'attribute' => 'other_features_benefits_of_women_welfare_department',
                                'label' => 'महिला कल्याण विभाग के लाभ',
                                'format' => 'html',
                                'value' => $model->getOtherfeaturesvalue('other_features_benefits_of_women_welfare_department'),
                            ],
                            [
                                'attribute' => 'other_features_benefits_of_health_department',
                                'label' => 'स्वास्थ्य विभाग के लाभ',
                                'format' => 'html',
                                'value' => $model->getOtherfeaturesvalue('other_features_benefits_of_health_department'),
                            ],
                        ],
                    ]);
                    ?>

                </div>

            </div>

        </div>

        <div class="row"> 

            <div class="col-lg-6 mx-1">
                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                    <div class='box-header blue-background'>
                        <div class='text-center'>मूल प्रोफ़ाइल</div>

                    </div>
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th>{label}</th><td class="font-weight-bolder">{value}</td></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'name_of_head_of_household',
                                'label' => 'परिवार के मुखिया का नाम',
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'color:red'],
                                'value' => $model->name_of_head_of_household,
                            ],
                            [
                                'attribute' => 'fathers_name_english',
                                'label' => 'परिवार के मुखिया के पिता/ पति का नाम',
                                'format' => 'html',
                                'value' => $model->fathers_name_english,
                            ],
//                            [
//                                'attribute' => 'husbands_name_hindi',
//                                'label' => ' पति का नाम',
//                                'format' => 'html',
//                                'value' => $model->husbands_name_english,
//                            ],
                            [
                                'attribute' => 'category',
                                'label' => 'सामाजिक वर्ग/ श्रेणी',
                                'format' => 'html',
                                'value' => $model->relcategory != null ? $model->relcategory->hindi_name : '',
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'label' => 'मोबाइल नंo',
                                'format' => 'html',
                                'value' => $model->mobile_no,
                            ],
                            [
                                'attribute' => 'aadhaar_card_number_of_head',
                                // 'visible' => $model->aadhaar_card_number_of_head,
                                'label' => 'परिवार के मुखिया का आधार कार्ड नं',
                                'format' => 'raw',
                                'value' => $model->aadhaar_card_number_of_head,
                            ],
                            [
                                'attribute' => 'voter_card_yes_no',
                                'label' => 'वोटर कार्ड',
                                'format' => 'raw',
                                'value' => $model->votercard != null ? $model->votercard->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'epic_number_of_head',
                                'label' => 'परिवार के मुखिया का EPIC No.',
                                'format' => 'html',
                                'value' => $model->epic_number_of_head,
                            ],
                            [
                                'attribute' => 'gender_of_head',
                                'label' => 'परिवार के मुखिया का लिंग',
                                'format' => 'html',
                                'value' => $model->gender != null ? $model->gender->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'occupation',
                                'label' => 'पेशा/ व्यवसाय',
                                'format' => 'html',
                                'value' => $model->reloccupation != null ? $model->reloccupation->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'head_dob',
                                'label' => 'जन्म तिथि [ वर्तमान आयु ]',
                                'format' => 'html',
                                'value' => $model->head_dob != null ? Yii::$app->formatter->asDatetime($model->head_dob, "php:d-m-Y") . '<br> [ ' . $model->head_age . ' Years ]' : '',
                            ],
                            [
                                'attribute' => 'family_has_smartphone',
                                'label' => 'क्या परिवार के किसी सदस्य के पास स्मार्टफ़ोन/ टचवाला फ़ोन है',
                                'format' => 'html',
                                'value' => $model->smartphones != null ? $model->smartphones->hindi_name : '-',
                            ],
                            [
                                'attribute' => 'head_district_code',
                                'visible' => $model->area == 1,
                                'label' => 'जिला [ ग्राम पंचायत ]',
                                'format' => 'html',
                                'value' => ($model->hdistrict != null and $model->area == 1) ? $model->hdistrict->district_name . '<br> [ ' . $model->hgp->gram_panchayat_name . ' ] ' : '-',
                            ],
                            [
                                'attribute' => 'head_block_code',
                                'visible' => $model->area == 1,
                                'label' => 'Block [ ग्राम ]',
                                'format' => 'html',
                                'value' => ($model->hblock != null and $model->hvillage != null and $model->area == 1) ? $model->hblock->block_name . '<br> [ ' . $model->hvillage->village_name . ' ]' : '-',
                            ],
                        ],
                    ]);
                    ?>
                </div> 



            </div>  


        </div>
        
    </div> 

</div>
<?php
$js = <<<JS
 $(function () {
//$('a.backlink').on('click', function () {         
//  //$.getScript(this.href);
////            alert($.getScript(this.href)); 
//  history.pushState(null, '', this.href);         
//  return false;
//});     
$('.aproveretur').click(function(){                
   var url=$(this).attr('url'); 
   var message=$(this).attr('msg');  
   var actionOk = confirm(message);  
       if(actionOk){
                   $.ajax({
                        url: url,
                        type: 'post',   
                        dataType: 'json',
                        context: this,    
                        success: function (data) {
                               if(data.success === true){
                                     history.go(data.ret);
                                    console.log('req 1');
                                   }
                            },
                            error  : function (e)
                            {
                                console.log(e);
                            }
                           });
      }               
   });                     
 }); 
        
JS;
$this->registerJs($js);
?> `
<?php
$css = <<<cs
      .img{cursor : pointer }
cs;
$this->registerCss($css);
?>

<style>
    .box .box-header.blue-background {
        color: #000;
    }
    .box .box-header {
        padding: 0px 15px;
    }
    .box .box-header {
        font-size: 21px;
        font-weight: 200;
        line-height: 30px;
        padding: 6px 12px;
        overflow: hidden;
        *zoom: 1;
        width: 100%;
    }
    .blue-background {
        background-color: #d9edf7 !important;
        border-color: #bce8f1;
    }
    th{
        font-weight: normal;
    }
    td{
        font-weight: normal;
    }
    hr{
        margin: 5px;
        height: 1px;
        background-color: #ccc;
        width: 106.8%;
    }

</style>


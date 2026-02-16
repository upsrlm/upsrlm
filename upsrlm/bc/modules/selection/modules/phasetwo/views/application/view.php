<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\bootstrap4\Modal;
use yii\grid\GridView;
use kartik\popover\PopoverX;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
use common\helpers\Utility;
/* @var $this yii\web\View */
/* @var $model app\models\nfsa\NfsaBaseSurvey */

$this->title = 'BC Selection Application';
$this->params['breadcrumbs'][] = ['label' => 'BC Selection Application', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$dataProvider = new yii\data\ArrayDataProvider([
    'allModels' => $model->family,
    'pagination' => false,
        ]);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $model->name ?>
                </h2>
                <div class="panel-toolbar">
                    <?php if (isset(bc\modules\selection\models\base\GenralModel::form_data_validation_option()[$model->form_data_validate])) { ?>
                    <h2><span class="label label-primary"><?=bc\modules\selection\models\base\GenralModel::form_data_validation_option()[$model->form_data_validate]?></span></h2>
                    <?php } ?>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <div class="row panel">
                        <?php if ($model->form_number > 5) { ?>
                            <?php if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
                                <!--                            <div class="col-md-12">
                                                                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                                                                    <div class='box-header blue-background'>
                                                                        <div class='text-center'>Rating</div>
                                
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <table class="table table-striped table-bordered detail-view">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><?= $model->getAttributeLabel('sec1') ?></th> 
                                                                                <th><?= $model->getAttributeLabel('sec2') ?></th> 
                                                                                <th><?= $model->getAttributeLabel('sec3') ?></th>
                                                                                <th><?= $model->getAttributeLabel('sec4') ?></th>
                                                                                <th><?= $model->getAttributeLabel('sec5') ?></th> 
                                                                                <th><?= $model->getAttributeLabel('over_all') ?></th> 
                                                                            </tr>   
                                                                        </thead> 
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?= $model->sec1 . '/' . SrlmBcApplication::MAX_NO_BASIC_AND_FAMILY . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(' . \common\helpers\Utility::percentageOf($model->sec1, SrlmBcApplication::MAX_NO_BASIC_AND_FAMILY) . ')' ?></td> 
                                                                                <td><?= $model->sec2 . '/' . SrlmBcApplication::MAX_NO_CRITERI1 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(' . \common\helpers\Utility::percentageOf($model->sec2, SrlmBcApplication::MAX_NO_CRITERI1) . ')' ?></td> 
                                                                                <td><?= $model->sec3 . '/' . SrlmBcApplication::MAX_NO_CRITERI2 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(' . \common\helpers\Utility::percentageOf($model->sec3, SrlmBcApplication::MAX_NO_CRITERI2) . ')' ?></td> 
                                                                                <td><?= $model->sec4 . '/' . SrlmBcApplication::MAX_NO_CRITERI3 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(' . \common\helpers\Utility::percentageOf($model->sec4, SrlmBcApplication::MAX_NO_CRITERI3) . ')' ?></td> 
                                                                                <td><?= $model->sec5 . '/' . SrlmBcApplication::MAX_NO_CRITERI4 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(' . \common\helpers\Utility::percentageOf($model->sec5, SrlmBcApplication::MAX_NO_CRITERI4) . ')' ?></td> 
                                                                                <td><?= $model->over_all . '/' . SrlmBcApplication::MAX_NO_TOTAL . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(' . \common\helpers\Utility::percentageOf($model->over_all, SrlmBcApplication::MAX_NO_TOTAL) . ')' ?></td> 
                                                                            </tr>  
                                                                        </tbody>
                                                                    </table>
                                                                </div>     
                                                            </div>-->
                            <?php } ?>
                        <?php } ?>
                        <div class="col-md-12">
                            <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                                <div class='box-header blue-background'>
                                    <div class='text-center'>OTP Verified mobile no : <?= Utility::mask($model->user->mobile_no) ?> </div>

                                </div>
                            </div>
                            <?php if ($model->form_number > 0) { ?>
                                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                                    <div class='box-header blue-background'>
                                        <div class='text-center'>Basic Profile (मूल प्रोफ़ाइल) </div>

                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class='box bordered-box blue-border' style='margin-bottom:0;'>

                                            <?=
                                            DetailView::widget([
                                                'model' => $model,
                                                'attributes' => [
                                                    [
                                                        'attribute' => 'first_name',
                                                        'label' => '1. पहला नाम',
                                                        'format' => 'html',
                                                        'value' => $model->first_name,
                                                    ],
                                                    [
                                                        'attribute' => 'middle_name',
                                                        'label' => '2. मध्य नाम',
                                                        'format' => 'html',
                                                        'value' => $model->middle_name != null ? $model->middle_name : '',
                                                    ],
                                                    [
                                                        'attribute' => 'sur_name',
                                                        'label' => '3. उपनाम',
                                                        'format' => 'html',
                                                        'value' => $model->sur_name != null ? $model->sur_name : '',
                                                    ],
                                                    [
                                                        'attribute' => 'gender',
                                                        'label' => '5. लिंग',
                                                        'format' => 'html',
                                                        'value' => $model->genderrel != null ? $model->genderrel->name_hi : '',
                                                    ],
                                                    [
                                                        'attribute' => 'age',
                                                        'label' => '6. आयु',
                                                        'format' => 'html',
                                                        'value' => $model->age != null ? $model->age : '',
                                                    ],
                                                    [
                                                        'attribute' => 'cast',
                                                        'label' => '7. सामाजिक वर्ग',
                                                        'format' => 'html',
                                                        'value' => $model->castrel != null ? $model->castrel->name_hi : '',
                                                    ],
                                                    [
                                                        'attribute' => 'address',
                                                        'label' => 'पता',
                                                        'format' => 'html',
                                                        'value' => function ($model) {
                                                            return $model->fulladdress;
                                                        },
                                                    ],
                                                    [
                                                        'attribute' => 'aadhar_number',
                                                        'label' => '15. आधार नंबर',
                                                        'format' => 'html',
                                                        'value' => $model->aadhar_number != null ? common\helpers\Utility::maskaadhar($model->aadhar_number) : '',
                                                    ],
                                                    [
                                                        'attribute' => 'guardian_name',
                                                        'label' => '16. पति/ पिता/ अभिभावक का नाम',
                                                        'format' => 'html',
                                                        'value' => $model->guardian_name != null ? $model->guardian_name : '',
                                                    ],
                                                    [
                                                        'attribute' => 'reading_skills',
                                                        'label' => '17. आपका शिक्षा/ पढ़ने लिखने की कुशलता',
                                                        'format' => 'html',
                                                        'value' => $model->readingskills != null ? $model->readingskills->name_hi : '',
                                                    ],
                                                    [
                                                        'attribute' => 'mobile_number',
                                                        'label' => '18. मोबाइल  नंबर',
                                                        'format' => 'html',
                                                        'value' => $model->mobile_number != null ? Utility::mask($model->mobile_number) : '',
                                                    ],
                                                    [
                                                        'attribute' => 'phone_type',
                                                        'label' => '19. कौन सा मोबाइल है?',
                                                        'format' => 'html',
                                                        'value' => $model->phonetype != null ? $model->phonetype->name_hi : '',
                                                    ],
                                                ],
                                            ]);
                                            ?>
                                        </div>


                                    </div>

                                    <div class="col-md-6">
                                        <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                                            <table>
                                                <tr>
                                                    <th>4. प्रोफाइल फोटो</th>
                                                    <th>13. आधार फ्रंट फोटो</th>
                                                    <th>14. आधार बैक फोटो</th>
                                                </tr> 
                                                <tr>
                                                    <td><?= ($model->user->profile_photo != null and $model->gender) ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->profile_photo_url . '" data-src="' . $model->profile_photo_url . '"  class="lozad" title="profile_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                                    <td><?= ($model->user->aadhar_front_photo != null and $model->gender) ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->aadhar_front_photo_url . '" data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                                    <td><?= ($model->user->aadhar_back_photo != null and $model->gender) ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                                </tr>
                                            </table>
                                            <?=
                                            DetailView::widget([
                                                'model' => $model,
                                                'attributes' => [
                                                    [
                                                        'attribute' => 'what_else_with_mobile1',
                                                        'label' => '20. फ़ोन करने के अलावा, मोबाइल से और क्या क्या कर लेते हैं?',
                                                        'format' => 'html',
                                                        'value' => $model->wewm,
                                                    ],
                                                    [
                                                        'attribute' => 'whats_app_number',
                                                        'label' => '21. कोई व्हाट्सएप्प नंबर है?',
                                                        'format' => 'html',
                                                        'value' => $model->watsup != null ? $model->watsup->name_hi : '',
                                                    ],
                                                    [
                                                        'attribute' => 'vechicle_drive1',
                                                        'label' => '22. निम्न में से कौन सा वाहन चलाना आता है?',
                                                        'format' => 'html',
                                                        'value' => $model->vd,
                                                    ],
                                                ],
                                            ]);
                                            ?> 

                                        </div>
                                    </div>
                                </div>  
                            </div>
                        <?php } ?>


                    </div>
                    <?php if ($model->form_number > 1) { ?>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                                    <div class='box-header blue-background'>
                                        <div class='text-center'>Family Profile (पारिवारिक प्रोफ़ाइल)</div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'marital_status',
                                                    'label' => '1. वैवाहिक स्थिति',
                                                    'format' => 'html',
                                                    'value' => $model->ms != null ? $model->ms->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?>
                                        <div class='box-header blue-background'>
                                            <div class='text-center'>2. घर में कितने सदस्य हैं? बच्चों एवं सदस्यों का आयुवार विवरण?</div>

                                        </div>
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'house_member_details1',
                                                    'label' => 'अगर उम्र 10 साल से कम है',
                                                    'format' => 'html',
                                                    'value' => $model->house_member_details1 != null ? $model->house_member_details1 : '',
                                                ],
                                                [
                                                    'attribute' => 'house_member_details2',
                                                    'label' => '11 से 16 साल की उम्र के बीच',
                                                    'format' => 'html',
                                                    'value' => $model->house_member_details2 != null ? $model->house_member_details2 : '',
                                                ],
                                                [
                                                    'attribute' => 'house_member_details3',
                                                    'label' => '16 साल से ऊपर की उम्र',
                                                    'format' => 'html',
                                                    'value' => $model->house_member_details3 != null ? $model->house_member_details3 : '',
                                                ],
                                                [
                                                    'attribute' => 'future_scope',
                                                    'label' => '3. आपके परिवार का मुख्य आजीविका के साधन क्या है? ',
                                                    'format' => 'html',
                                                    'value' => $model->fs,
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'opportunities_for_livelihood',
                                                    'label' => '4. आपके परिवार के आजीविका के लिए और मुख्य अवसर क्या क्या हैं?  ',
                                                    'format' => 'html',
                                                    'value' => $model->ofl,
                                                ],
                                                [
                                                    'attribute' => 'other_occupation',
                                                    'label' => 'अन्य व्यवसाय ',
                                                    'format' => 'html',
                                                    'visible' => $model->other_occupation,
                                                    'value' => $model->other_occupation,
                                                ],
                                                [
                                                    'attribute' => 'planning_intervention1',
                                                    'label' => '5. इन अवसरों के रास्तें में क्या क्या प्रमुख दिक्कतें हैं?',
                                                    'format' => 'html',
                                                    'value' => $model->pi,
                                                ],
                                                [
                                                    'attribute' => 'immediate_aspiration1',
                                                    'label' => '6. घर में प्रमुख तीन कमी जो आप अपने साधन से पूरा करना चाहती हैं?',
                                                    'format' => 'html',
                                                    'value' => $model->ias,
                                                ],
                                            ],
                                        ]);
                                        ?>


                                    </div>
                                </div>      
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($model->form_number > 2) { ?>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                                    <div class='box-header blue-background'>
                                        <div class='text-center'>Part 1 (भाग 1)</div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'already_group_member',
                                                    'label' => '1. क्या आप किसी स्वयं सहायता समूह के सदस्य, पदाधिकारी या कम्युनिटी/ सामुदायिक कैडर हैं?',
                                                    'format' => 'html',
                                                    'value' => $model->agm != null ? $model->agm->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?>

                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'thought_of_forming_group',
                                                    'label' => '2. क्या आपने कभी समूह गठन करने की सोची?',
                                                    'format' => 'html',
                                                    'visible' => ($model->already_group_member == 1),
                                                    'value' => $model->thofformg != null ? $model->thofformg->name_hi : '',
                                                ],
                                                [
                                                    'attribute' => 'your_group_name',
                                                    'label' => '2. आपके समूह का नाम लिखें',
                                                    'format' => 'html',
                                                    'visible' => ($model->already_group_member != 1),
                                                    'value' => $model->your_group_name,
                                                ],
                                            ],
                                        ]);
                                        ?>


                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'which_program_your_group_formed',
                                                    'label' => '3. आपके समूह के गठन किस कार्यक्रम के अंतर्गत हुआ है? ',
                                                    'format' => 'html',
                                                    'visible' => ($model->already_group_member != 1),
                                                    'value' => $model->whygformed != null ? $model->whygformed->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?>


                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'if_you_have_group_members_what_are_they',
                                                    'label' => '5. अगर आपने समूह के सदस्यों के बारे में है, तो वे क्या है?',
                                                    'format' => 'html',
                                                    'visible' => ($model->already_group_member == 1),
                                                    'value' => $model->ifyougroupmemberswhatarethe != null ? $model->ifyougroupmemberswhatarethe->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?>


                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'what_could_you_do_if_you_were_in_a_group1',
                                                    'label' => '6. अगर आप समूह में होते तो क्या सहयोग कर सकते',
                                                    'format' => 'html',
                                                    'visible' => ($model->already_group_member == 1),
                                                    'value' => $model->wcydoiywiagroup != null ? $model->wcydoiywiagroup : '',
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>

                                </div>
                                <div class="clearfix"></div>
                                <?php if (!empty($model->family) and $model->already_group_member != 1) { ?>
                                    <div class='box-header blue-background'>
                                        <div class='text-center'>4. अपने समूह के सभी/ ज़्यादातर अन्य (खुद को छोड़कर) सदस्यों के नाम लिखें (कम से कम पांच) – with mobile no.</div>

                                    </div>
                                    <?=
                                    GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'summary' => "",
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
                                            [
                                                'attribute' => 'member_name',
                                                'contentOptions' => ['style' => 'width: 30%'],
                                                'enableSorting' => false,
                                                'value' => function ($model) {
                                                    return $model->member_name;
                                                },
                                            ],
                                            [
                                                'attribute' => 'mobile_no',
                                                'contentOptions' => ['style' => 'width: 50%'],
                                                'enableSorting' => false,
                                                'value' => function ($model) {
                                                    return $model->mobile_no;
                                                },
                                            ],
                                        ],
                                    ]);
                                    ?>
                                <?php } ?>
                                <?php if ($model->already_group_member == 1 and $model->thought_of_forming_group == 1) { ?>
                                    <div class="col-lg-6">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'try_towards_group_formation',
                                                    'label' => '3 तो समूह गठन के दिशा में आपने क्या कोशिश की ?',
                                                    'format' => 'html',
                                                    'visible' => ($model->already_group_member == 1 and $model->thought_of_forming_group == 1),
                                                    'value' => $model->trytgf != null ? $model->trytgf : '',
                                                ],
                                            ],
                                        ]);
                                        ?>

                                    </div>
                                <?php } ?>
                                <div class="col-lg-6">
                                    <?=
                                    DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            [
                                                'attribute' => 'leadership_name',
                                                'label' => '5. समूह की स्थापना में किसने/ किन्होंने पहल की थी – सबसे ज़्यादा सहयोग किया? ',
                                                'format' => 'html',
                                                'visible' => ($model->already_group_member != 1),
                                                'value' => $model->leadership_name != null ? $model->leadership_name : '',
                                            ],
                                            [
                                                'attribute' => 'role_in_group1',
                                                'label' => '6. समूह की स्थापना में आपकी क्या भूमिका रही',
                                                'format' => 'html',
                                                'visible' => ($model->already_group_member != 1),
                                                'value' => $model->rolingroup != null ? $model->rolingroup : '',
                                            ],
                                        ],
                                    ]);
                                    ?>

                                </div>
                                <div class="col-lg-6">
                                    <?=
                                    DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            [
                                                'attribute' => 'why_did_you_get_elected1',
                                                'label' => '7. आपको पदाधिकारी क्यों चुना गया',
                                                'format' => 'html',
                                                'visible' => ($model->already_group_member != 1),
                                                'value' => $model->wdygelect != null ? $model->wdygelect : '',
                                            ],
                                        ],
                                    ]);
                                    ?>

                                </div>
                            </div>

                            <?php if ($model->already_group_member != 1) { ?> 

                                <div class="col-md-12">
                                    <div class="col-lg-12">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th width="30%" style="vertical-align:middle">8. आपके समूह में सबसे क्रियाशील एवं सृजनशील दो सदस्य कौन है?</th>
                                                <td>
                                                    <?=
                                                    DetailView::widget([
                                                        'model' => $model,
                                                        'attributes' => [
                                                            [
                                                                'attribute' => 'active_members_name1',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->active_members_name1 != null ? $model->active_members_name1 : '',
                                                            ],
                                                            [
                                                                'attribute' => 'active_members_name2',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->active_members_name2 != null ? $model->active_members_name2 : '',
                                                            ],
                                                        ],
                                                    ]);
                                                    ?> 


                                                </td>
                                            </tr>

                                        </table>
                                    </div>    
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-lg-12">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th width="30%" style="vertical-align:middle">9. वे कौन दो सदस्य हैं जो आपके समूह के सदस्यों के अधिकार के लिए लड़ने, संघर्ष करने के लिए तैयार रहते हैं?</th>
                                                <td>
                                                    <?=
                                                    DetailView::widget([
                                                        'model' => $model,
                                                        'attributes' => [
                                                            [
                                                                'attribute' => 'belongingness_name1',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->belongingness_name1 != null ? $model->belongingness_name1 : '',
                                                            ],
                                                            [
                                                                'attribute' => 'belongingness_name2',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->belongingness_name2 != null ? $model->belongingness_name2 : '',
                                                            ],
                                                        ],
                                                    ]);
                                                    ?> 


                                                </td>
                                            </tr>

                                        </table>
                                    </div>    
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-lg-12">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th width="30%" style="vertical-align:middle">10. वे कौन दो सदस्य हैं जो आपके समूह के सदस्यों के अधिकार एवं व्यक्तिगत सदस्यों के अधिकार बारे में जागरूक हैं, पूरी समझ रखते हैं ?</th>
                                                <td>
                                                    <?=
                                                    DetailView::widget([
                                                        'model' => $model,
                                                        'attributes' => [
                                                            [
                                                                'attribute' => 'awareness_name1',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->awareness_name1 != null ? $model->awareness_name1 : '',
                                                            ],
                                                            [
                                                                'attribute' => 'awareness_name2',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->awareness_name2 != null ? $model->awareness_name2 : '',
                                                            ],
                                                        ],
                                                    ]);
                                                    ?> 


                                                </td>
                                            </tr>

                                        </table>
                                    </div>    
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-lg-12">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th width="30%" style="vertical-align:middle">11. क्या कोई दो सदस्य हैं जो दुसरे समूहों से भी संपर्क रखते है?</th>
                                                <td>
                                                    <?=
                                                    DetailView::widget([
                                                        'model' => $model,
                                                        'attributes' => [
                                                            [
                                                                'attribute' => 'member_who_contact_in_other_group_name1',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->member_who_contact_in_other_group_name1 != null ? $model->member_who_contact_in_other_group_name1 : '',
                                                            ],
                                                            [
                                                                'attribute' => 'member_who_contact_in_other_group_name2',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->member_who_contact_in_other_group_name2 != null ? $model->member_who_contact_in_other_group_name2 : '',
                                                            ],
                                                        ],
                                                    ]);
                                                    ?> 


                                                </td>
                                            </tr>

                                        </table>
                                    </div>    
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-lg-12">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th width="30%" style="vertical-align:middle">12. क्या दो कोई सदस्य हैं जिनकी दुसरे समूह में भी मांग है?</th>
                                                <td>
                                                    <?=
                                                    DetailView::widget([
                                                        'model' => $model,
                                                        'attributes' => [
                                                            [
                                                                'attribute' => 'demanded_group_member_name1',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->demanded_group_member_name1 != null ? $model->demanded_group_member_name1 : '',
                                                            ],
                                                            [
                                                                'attribute' => 'demanded_group_member_name2',
                                                                'label' => 'सदस्य',
                                                                'format' => 'html',
                                                                'value' => $model->demanded_group_member_name2 != null ? $model->demanded_group_member_name2 : '',
                                                            ],
                                                        ],
                                                    ]);
                                                    ?> 


                                                </td>
                                            </tr>

                                        </table>
                                    </div>    
                                </div> 
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <?=
                                            DetailView::widget([
                                                'model' => $model,
                                                'attributes' => [
                                                    [
                                                        'attribute' => 'why_demanded1',
                                                        'label' => '13. अगर हां, तो क्यों?',
                                                        'format' => 'html',
                                                        'value' => $model->whydemanded != null ? $model->whydemanded : '',
                                                    ],
                                                    [
                                                        'attribute' => 'capable_fast_pace',
                                                        'label' => '14. क्या आपको समूह के बाहर कोई एक या दो व्यक्ति दीखते है जो आपके समूह को तेज़ गति से आगे बढ़ाने में सक्षम है?',
                                                        'format' => 'html',
                                                        'value' => $model->capablefastpace != null ? $model->capablefastpace->name_hi : '',
                                                    ],
                                                    [
                                                        'attribute' => 'capable_fast_pace_member_name',
                                                        'label' => '15. सदस्य नाम',
                                                        'format' => 'html',
                                                        'visible' => $model->capable_fast_pace == 1,
                                                        'value' => $model->capable_fast_pace_member_name != null ? $model->capable_fast_pace_member_name : '',
                                                    ],
                                                    [
                                                        'attribute' => 'capable_fast_pace_member_number',
                                                        'label' => '16. सदस्य मोबाइल नंबर',
                                                        'format' => 'html',
                                                        'visible' => $model->capable_fast_pace == 1,
                                                        'value' => $model->capable_fast_pace_member_number != null ? $model->capable_fast_pace_member_number : '',
                                                    ],
                                                ],
                                            ]);
                                            ?> 
                                        </div>

                                        <div class="col-lg-6">
                                            <?=
                                            DetailView::widget([
                                                'model' => $model,
                                                'attributes' => [
                                                    [
                                                        'attribute' => 'his_perception1',
                                                        'label' => '17. उनके बारे में आपका आंकलन बताएं',
                                                        'format' => 'html',
                                                        'value' => $model->hisperception != null ? $model->hisperception : '',
                                                    ],
                                                ],
                                            ]);
                                            ?> 
                                        </div>
                                    </div>     
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if ($model->form_number > 2 and $model->already_group_member != 1) { ?>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                                    <div class='box-header blue-background'>
                                        <div class='text-center'>Part 2 (भाग 2)</div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'most_contribute_name',
                                                    'label' => '1. आपके समूह गतिविधिओं में सबसे ज़्यादा किसका सहयोग रहता है?',
                                                    'format' => 'html',
                                                    'value' => $model->most_contribute_name != null ? $model->most_contribute_name : '',
                                                ],
                                            ],
                                        ]);
                                        ?>

                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'group_culture',
                                                    'label' => '2. नियमानुसार वचत के अलावा क्या आपके समूह में स्वेच्छा से किये जाने वाले वचत का भी प्रावधान है?',
                                                    'format' => 'html',
                                                    'value' => $model->groupculture != null ? $model->groupculture->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?>

                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'provision_in_the_group_as_voluntary',
                                                    'label' => '1. क्या समूह में नियमानुसार वचत के अलावा स्वेच्छा से किये जाने वाले वचत का भी प्रावधान होना चाहिए?',
                                                    'format' => 'html',
                                                    'value' => $model->provisioninthegroupasvoluntary != null ? $model->provisioninthegroupasvoluntary->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?>

                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'entrepreneurial',
                                                    'label' => '3.अगर हाँ, तो कौन सबसे ज़्यादा स्वेच्छा से वचत की पैरवी करता है?',
                                                    'format' => 'html',
                                                    'value' => $model->entrepreneurial != null ? $model->entrepreneurial : '',
                                                ],
                                            ],
                                        ]);
                                        ?>

                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'economic_status',
                                                    'label' => '4. समूह में उनकी आर्थिक स्थिति कैसी है?',
                                                    'format' => 'html',
                                                    'value' => $model->economicstatus != null ? $model->economicstatus->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>    
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">5. क्या कोई दो सदस्य हैं जो नए अनजान नियमों/ विषयों से नहीं घबराता है? कौन ?</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'afraid_unknown_rules1',
                                                            'label' => 'सदस्य',
                                                            'format' => 'html',
                                                            'value' => $model->afraid_unknown_rules1 != null ? $model->afraid_unknown_rules1 : '',
                                                        ],
                                                        [
                                                            'attribute' => 'afraid_unknown_rules2',
                                                            'label' => 'सदस्य',
                                                            'format' => 'html',
                                                            'value' => $model->afraid_unknown_rules2 != null ? $model->afraid_unknown_rules2 : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div> 
                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">6. समूह के लिए नए उंचाईओं - उद्यमों या व्यवसायों के स्थापना की संकल्पना कीन्हे हैं ?</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'concept_of_setting_up_new_heights',
                                                            'label' => '6. समूह के लिए नए उंचाईओं - उद्यमों या व्यवसायों के स्थापना की संकल्पना कीन्हे हैं',
                                                            'format' => 'html',
                                                            'value' => $model->concept_of_setting_up_new_heights != null ? $model->concept_of_setting_up_new_heights : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div> 

                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">7. क्या कोई दो सदस्य दूसरे सदस्य के लिए कोई व्यावसायिक, आजीविका के अवसर की समझ रखता हैं? चर्चा करता है?</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'livelihood_opportunity_for_another_member1',
                                                            'label' => 'सदस्य',
                                                            'format' => 'html',
                                                            'value' => $model->livelihood_opportunity_for_another_member1 != null ? $model->livelihood_opportunity_for_another_member1 : '',
                                                        ],
                                                        [
                                                            'attribute' => 'negotiate_best2',
                                                            'label' => 'सदस्य',
                                                            'format' => 'html',
                                                            'value' => $model->livelihood_opportunity_for_another_member2 != null ? $model->livelihood_opportunity_for_another_member2 : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div>  
                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">8. किसी व्यावसायिक/ आर्थिक विषय पर, कौन दो सदस्य सबसे अच्छा मोलभाव कर सकता है?</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'negotiate_best1',
                                                            'label' => 'सदस्य',
                                                            'format' => 'html',
                                                            'value' => $model->negotiate_best1 != null ? $model->negotiate_best1 : '',
                                                        ],
                                                        [
                                                            'attribute' => 'negotiate_best2',
                                                            'label' => 'सदस्य',
                                                            'format' => 'html',
                                                            'value' => $model->negotiate_best2 != null ? $model->negotiate_best2 : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div> 
                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">9. कौन दो सदस्य समूह के फायदे/ हित को ध्यान में रखकर औरों से बात कर सकता है - समूह के लाभ को सुरक्षित कर सकता है?</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'which_member_can_talk_advantages21',
                                                            'label' => 'सदस्य',
                                                            'format' => 'html',
                                                            'value' => $model->which_member_can_talk_advantages1 != null ? $model->which_member_can_talk_advantages1 : '',
                                                        ],
                                                        [
                                                            'attribute' => 'which_member_can_talk_advantages22',
                                                            'label' => 'सदस्य',
                                                            'format' => 'html',
                                                            'value' => $model->which_member_can_talk_advantages2 != null ? $model->which_member_can_talk_advantages2 : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div> 
                        </div>
                    <?php } ?>           
                    <?php if ($model->form_number > 4) { ?>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                                    <div class='box-header blue-background'>
                                        <div class='text-center'>Part 3 (भाग 3)</div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'can_read_write_hindi',
                                                    'label' => '1. क्या आप आराम से हिंदी पढ़ और लिख लेते हैं??',
                                                    'format' => 'html',
                                                    'value' => $model->canreadwritehindi != null ? $model->canreadwritehindi->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?>  
                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'confirtable_in_english',
                                                    'label' => '2. अंग्रेज़ी पढ़ने लिखने में आप कितना सहज हैं?',
                                                    'format' => 'html',
                                                    'value' => $model->confirtableinenglish != null ? $model->confirtableinenglish->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?> 
                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'recognize_english_hindi',
                                                    'label' => '3. क्या आप हिंदी और अंग्रेज़ी में सभी अंक पहचान लेते हैं I',
                                                    'format' => 'html',
                                                    'value' => $model->recognizeenglishhindi != null ? $model->recognizeenglishhindi->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?>  
                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'can_add_substract_multiply',
                                                    'label' => '4. क्या आप हिंदी और अंग्रेज़ी में जोड़, घटाव, गुणा, भाग इत्यादि कर लेते हैं ?',
                                                    'format' => 'html',
                                                    'value' => $model->canaddsubstractmultiply != null ? $model->canaddsubstractmultiply->name_hi : '',
                                                ],
                                            ],
                                        ]);
                                        ?> 
                                    </div>
                                    <div class="col-lg-4">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'who_maintain_account',
                                                    'label' => '5. कौन सदस्य आपके समूह का खाता बही रखता है या उनका रखरखाव करता है?',
                                                    'format' => 'html',
                                                    'value' => $model->who_maintain_account != null ? $model->who_maintain_account : '',
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">6. नीचे दिए गए शब्दों के मतलब का कोई दूसरा शब्द चुनें</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'template' => '<tr><th width="75%">{label}</th><td width="25%">{value}</td></tr>',
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'choose_other_meaning1',
                                                            'label' => 'मुद्रा',
                                                            'format' => 'html',
                                                            'value' => $model->othermeaning1 != null ? $model->othermeaning1->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'choose_other_meaning2',
                                                            'label' => 'श्रम',
                                                            'format' => 'html',
                                                            'value' => $model->othermeaning2 != null ? $model->othermeaning2->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'choose_other_meaning3',
                                                            'label' => 'व्यय',
                                                            'format' => 'html',
                                                            'value' => $model->othermeaning3 != null ? $model->othermeaning3->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'choose_other_meaning4',
                                                            'label' => 'निवेदन',
                                                            'format' => 'html',
                                                            'value' => $model->othermeaning4 != null ? $model->othermeaning4->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'choose_other_meaning5',
                                                            'label' => 'ऋण',
                                                            'format' => 'html',
                                                            'value' => $model->othermeaning5 != null ? $model->othermeaning5->name_hi : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div>
                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">7. नीचे दिए गए वाक्यों से हूबहू मिलता जुलता कोई दूसरा वाक्य चुनें</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'template' => '<tr><th width="75%">{label}</th><td width="25%">{value}</td></tr>',
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'same_to_same_word1',
                                                            'label' => 'वह विश्राम कर रहा है',
                                                            'format' => 'html',
                                                            'value' => $model->sameword1 != null ? $model->sameword1->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'same_to_same_word2',
                                                            'label' => 'रमेश भ्रमण पर गया',
                                                            'format' => 'html',
                                                            'value' => $model->sameword2 != null ? $model->sameword2->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'same_to_same_word3',
                                                            'label' => 'सुनीता को व्यवसाय के लिए धन की आवश्यकता है',
                                                            'format' => 'html',
                                                            'value' => $model->sameword3 != null ? $model->sameword3->name_hi : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div> 
                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">8. नीचे दिए गए अंग्रेज़ी वाक्यों का हिंदी मतलब बताएं</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'template' => '<tr><th width="75%">{label}</th><td width="25%">{value}</td></tr>',
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'english_to_hindi1',
                                                            'label' => 'My name is Rajesh',
                                                            'format' => 'html',
                                                            'value' => $model->englishtohindi1 != null ? $model->englishtohindi1->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'english_to_hindi2',
                                                            'label' => 'I live in Varanasi',
                                                            'format' => 'html',
                                                            'value' => $model->englishtohindi2 != null ? $model->englishtohindi2->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'english_to_hindi3',
                                                            'label' => 'I like mangoes and banana ',
                                                            'format' => 'html',
                                                            'value' => $model->englishtohindi3 != null ? $model->englishtohindi3->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'english_to_hindi4',
                                                            'label' => 'I like Red colour',
                                                            'format' => 'html',
                                                            'value' => $model->englishtohindi4 != null ? $model->englishtohindi4->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'english_to_hindi5',
                                                            'label' => 'I love my family',
                                                            'format' => 'html',
                                                            'value' => $model->englishtohindi5 != null ? $model->englishtohindi5->name_hi : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div>
                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">9. नीचे दिए गए अंक-गणित का जवाब भरें; जोड़, घटाव, गुना-भाग एवं प्रतिशत निकलन</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'template' => '<tr><th width="75%">{label}</th><td width="25%">{value}</td></tr>',
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'percentage_option1',
                                                            'label' => '100 रुपये का 20 प्रतिशत कितना हुआ?',
                                                            'format' => 'html',
                                                            'value' => $model->percentageoption1 != null ? $model->percentageoption1->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'percentage_option2',
                                                            'label' => '300 रुपये का 30 प्रतिशत कितना हुआ?',
                                                            'format' => 'html',
                                                            'value' => $model->percentageoption2 != null ? $model->percentageoption2->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'percentage_option3',
                                                            'label' => '200 रुपये का 45 प्रतिशत कितना हुआ?',
                                                            'format' => 'html',
                                                            'value' => $model->percentageoption3 != null ? $model->percentageoption3->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'percentage_option4',
                                                            'label' => '500 रुपये का 5 प्रतिशत कितना हुआ?',
                                                            'format' => 'html',
                                                            'value' => $model->percentageoption4 != null ? $model->percentageoption4->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'percentage_option5',
                                                            'label' => '900 रुपये का 4 प्रतिशत कितना हुआ?',
                                                            'format' => 'html',
                                                            'value' => $model->percentageoption5 != null ? $model->percentageoption5->name_hi : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div>
                            <div class="col-md-12">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th width="30%" style="vertical-align:middle">10. नीचे दिए गए लेखा-बही के हिसाब से, दिए गए विकल्पों पर अपना निर्णय लेंा</th>
                                            <td>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'template' => '<tr><th width="75%">{label}</th><td width="25%">{value}</td></tr>',
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'option_decision1',
                                                            'label' => 'रामू ने सुरेश से 1,000 रूपए लिए और बनिया का 800 रूपए का उधार चुकाया, तो रामू के पास कितने रुपये शेष बचे?',
                                                            'format' => 'html',
                                                            'value' => $model->optiondecision1 != null ? $model->optiondecision1->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'option_decision2',
                                                            'label' => 'एक स्वयं सहायता समूह में 10 सदस्य हैं, अगर सभी सदस्यों ने समूह के लिए 200-200 रूपए जमा किये तो कुल कितने रुपये एकत्रित हुए?',
                                                            'format' => 'html',
                                                            'value' => $model->optiondecision2 != null ? $model->optiondecision2->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'option_decision3',
                                                            'label' => 'राजेश ने विमला से 5 प्रतिशत सालाना ब्याज पर 1000 रूपए लिए, दो साल बाद राजेश विमला को कुल कितने रूपए वापस देगा?',
                                                            'format' => 'html',
                                                            'value' => $model->optiondecision3 != null ? $model->optiondecision3->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'option_decision4',
                                                            'label' => 'महेश के पास 10,000 रू थे, उसने 500 रू माला को दिए, 400 रू राहुल को दिए, 3000 रू अपनी माँ को दिए, तो अब महेश के पास कुल कितने रूपए शेष बचे?',
                                                            'format' => 'html',
                                                            'value' => $model->optiondecision4 != null ? $model->optiondecision4->name_hi : '',
                                                        ],
                                                        [
                                                            'attribute' => 'option_decision5',
                                                            'label' => 'रामू 20 रूपए प्रति किलो के हिसाब से 50 किलो आलू लाया और उसे 25 रूपए प्रति किलो के हिसाब से बेच दिया, तो उसे कुल कितना लाभ हुआ?',
                                                            'format' => 'html',
                                                            'value' => $model->optiondecision5 != null ? $model->optiondecision5->name_hi : '',
                                                        ],
                                                    ],
                                                ]);
                                                ?> 


                                            </td>
                                        </tr>

                                    </table>
                                </div>    
                            </div>

                        </div>        
                    <?php } ?>
                    <?php if ($model->form_number > 5) { ?>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class='box bordered-box blue-border' style='margin-bottom:0;'>
                                    <div class='box-header blue-background'>
                                        <div class='text-center'>Part 4 (भाग 4)</div>

                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-lg-6">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'mobile_use_experience',
                                                    'label' => '1. यहाँ तक आपको मोबाइल ऍप का उपयोग करना कैसा महसूस हुआ?',
                                                    'format' => 'html',
                                                    'value' => $model->musee != null ? $model->musee->name_hi : '',
                                                ],
                                                [
                                                    'attribute' => 'whose_mobile_you_using',
                                                    'label' => '2. आप किनके स्मार्टफोन पर यह ऍप उपयोग कर रहे हैं?',
                                                    'format' => 'html',
                                                    'value' => $model->whosemuse != null ? $model->whosemuse->name_hi : '',
                                                ],
                                                [
                                                    'attribute' => 'no_of_people_using_phone',
                                                    'label' => '3. आपके समूह में कितने सदस्यों के पास स्वयं का स्मार्टफोन है?',
                                                    'format' => 'html',
                                                    'value' => $model->no_of_people_using_phone != null ? $model->no_of_people_using_phone : '',
                                                ],
                                                [
                                                    'attribute' => 'no_of_family_people_using_phone',
                                                    'label' => '4. आपके समूह में कितने सदस्यों के परिवारों में स्मार्टफोन उपलब्ध है, जिनका वे आवश्यकता अनुसार कभी कभी उपयोग कर सकते हैं?',
                                                    'format' => 'html',
                                                    'value' => $model->no_of_family_people_using_phone != null ? $model->no_of_family_people_using_phone : '',
                                                ],
                                                [
                                                    'attribute' => 'need_help_to_fill_form',
                                                    'label' => '5. इस फॉर्म को भरने के लिए आपको किसी और का मदद क्यों लेना पड़ा ?',
                                                    'format' => 'html',
                                                    'value' => $model->needhelptofillform != null ? $model->needhelptofillform->name_hi : '',
                                                ],
                                                [
                                                    'attribute' => 'already_worked',
                                                    'label' => '6. (Yes) क्या आपने पहले भी कभी ऐसा फॉर्म मोबाइल ऍप पर भरा है?',
                                                    'format' => 'html',
                                                    'value' => $model->aw != null ? $model->aw->name_hi : '',
                                                ],
                                                [
                                                    'attribute' => 'own_mobile',
                                                    'label' => '7. (No) अगर आपका स्वयं का मोबाइल हो, तो क्या आप बिना किसी के मदद के ये फॉर्म भर सकते हैं?',
                                                    'format' => 'html',
                                                    'value' => $model->ownmobile != null ? $model->ownmobile->name_hi : '',
                                                ],
                                                [
                                                    'attribute' => 'own_mobile_means',
                                                    'label' => '8. स्वयं के पास मोबाइल फ़ोन होने का आपके लिए क्या मायने हैं ? ',
                                                    'format' => 'html',
                                                    'value' => $model->own_mobile_means,
                                                ],
                                            ],
                                        ]);
                                        ?>


                                    </div>

                                    <div class="col-lg-6">
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => '9. method_used_for_ledger_account',
                                                    'label' => '9. समूह के बही खाता का रखरखाव के लिए कौन सी पद्धति सही व आसान दोनों है ',
                                                    'format' => 'html',
                                                    'value' => $model->method_used_for_ledger_account,
                                                ],
                                                [
                                                    'attribute' => 'need_training',
                                                    'label' => '10. मोबाइल पर कार्य करने के लिए आपको कोई प्रशिक्षण की आवश्यकता है? कितने समय की ',
                                                    'format' => 'html',
                                                    'value' => $model->need_training,
                                                ],
                                            ],
                                        ]);
                                        ?>

                                    </div>
                                </div>    
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>

            <div class="col-lg-12 text-center">
                <?php
                $html = '';
                if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]) and $model->form_data_validate == '0' and $model->form_number == '6') {
                    $html .= Html::button('Validate Application Form', [
                                'data-pjax' => "0",
                                'class' => 'btn   btn-info popbc',
                                'value' => '/selection/phase2/application/validateform?id=' . $model->id,
                                'title' => 'Validate Application Form  of  ' . $model->name
                    ]);
                }
                echo $html;
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<<JS
$(function () {

        $('.popb').elevateZoom({
         scrollZoom : true,
        responsive : true,
        zoomWindowOffetx:-600
   });
   $('.popbc').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
        });
});  

JS;
$this->registerJs($js);
?> 
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-xl',
//    'options' => ['data-backdrop' => 'true',],
    'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
    ],
]);
echo "<div id='imagecontent'></div>";
Modal::end();
?>


<?php
$js = <<<JS
             
        observer = lozad('.lozad', {
                                        load: function (el) {
                                            console.log('loading element');
                                            el.src = el.getAttribute('data-src');
                                            // Custom implementation to load an element
                                            // e.g. el.src = el.getAttribute('data-src');

                
                
                                                $(el).elevateZoom({
                                                    scrollZoom: true,
                                                    responsive: true,
                                                    zoomWindowOffetx: -600
                                                });
                                                $('.popbc').click(function () {
                                                    $('#imagecontent').html('');
                                                    $('#modal').modal('show')
                                                            .find('#imagecontent')
                                                            .load($(this).attr('value'));
                                                    document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';
                                                });

//                                            $(function () {
//                                                $('.popb').elevateZoom({
//                                                    scrollZoom: true,
//                                                    responsive: true,
//                                                    zoomWindowOffetx: -600
//                                                });
//                                                $('.popbc').click(function () {
//                                                    $('#imagecontent').html('');
//                                                    $('#modal').modal('show')
//                                                            .find('#imagecontent')
//                                                            .load($(this).attr('value'));
//                                                    document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';
//                                                });
//                                            });

                                        }
                                    }); // lazy loads elements with default selector as '.lozad'
                                    observer.observe();     
        
JS;
$this->registerJs($js);
?> 





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
        padding: 10px 15px;
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
        font-weight: bold;
        vertical-align:middle;
    }
    hr{
        margin: 5px;
        height: 1px;
        background-color: #ccc;
        width: 106.8%;
    }


</style>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\master\MasterRole;

$this->title = "SHG Feedback";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">
                    <?= Html::a('SHG Feedback', ['/shg/feedback'], ['class' => 'btn btn-success']) ?>
                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped table-bordered detail-view'],
                        'template' => "<tr><th style='width:45%'>{label}</th><td style='width:55%'>{value}</td></tr>",
                        'attributes' => [
                            [
                                'attribute' => 'name_of_shg',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg != null ? $model->shg->name_of_shg : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg != null ? $model->shg->district_name : '';
                                }
                            ],
                            [
                                'attribute' => 'block_name',
                                'label' => 'Block ',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg != null ? $model->shg->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'gp',
                                'label' => 'GP ',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg != null ? $model->shg->gram_panchayat_name : '';
                                }
                            ],
                            [
                                'attribute' => 'ques_1',
                                'label' => '1. आपके समूह को वचत करते हुए कितना समय हो गया है?',
                                'value' => function ($model) {
                                    return $model->ques1;
                                }
                            ],
                            [
                                'attribute' => 'ques_2',
                                'label' => '2. समूह में कितने सदस्य को अबतक राज्य ग्रामीण आजीविका मिशन या बैंक से ऋण मिल पाया है?',
                                'value' => function ($model) {
                                    return $model->ques_2;
                                }
                            ],
                            [
                                'attribute' => 'ques_3',
                                'label' => '3. समूह में जिन्हें अबतक ऋण नहीं मिला है उन में से कितने सदस्य को ऋण की त्वरित आवश्यकता है?',
                                'value' => function ($model) {
                                    return $model->ques_3;
                                }
                            ],
                            [
                                'attribute' => 'ques_4',
                                'label' => '4. समूह में जिन्हें अबतक ऋण मिला है उन में से कितने सदस्य को दोबारा ऋण की त्वरित आवश्यकता है?',
                                'value' => function ($model) {
                                    return $model->ques_4;
                                }
                            ],
                            [
                                'attribute' => 'ques_5',
                                'label' => '5. क्या जिन्हें अबतक ऋण मिला है, क्या ऋण उनके ज़रूरत के हिसाब से यथेष्ट थे?',
                                'value' => function ($model) {
                                    return $model->ques5;
                                }
                            ],
                            [
                                'attribute' => 'ques_6',
                                'label' => '6. आपके समूह के लिए राज्य ग्रामीण आजीविका मिशन के साथ अबतक का अनुभव कैसा रहा?',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return '';
                                }
                            ],
                            [
                                'attribute' => 'ques_6',
                                'label' => 'पार्ट – 1: अबतक का आँकलन ',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ques6p1html;
                                }
                            ],
                            [
                                'attribute' => 'ques_6',
                                'label' => 'पार्ट – 2: प्रक्रिया पर आपकी राय/ फ़ीड्बैक',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ques6p2html;
                                }
                            ],
                            [
                                'attribute' => 'ques_6',
                                'label' => 'पार्ट – 3: कार्यक्रम पर आपके प्रमुख सुझाव ',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ques6p3html;
                                }
                            ],
                            [
                                'attribute' => 'ques_7',
                                'label' => '7. समूह के कुल कितने सदस्य को त्वरित ऋण की आवश्यकता है?',
                                'value' => function ($model) {
                                    return $model->ques_7;
                                }
                            ],
                            [
                                'attribute' => 'ques_8',
                                'label' => '8 प्रति सदस्य औसत कितने रुपए की ऋण की आवश्यकता है?',
                                'value' => function ($model) {
                                    return $model->ques8;
                                }
                            ],
                        ],
                    ])
                    ?>

                </div>
            </div>

        </div>
    </div>

</div>        

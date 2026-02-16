<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use common\models\master\MasterRole;

$this->title = "CLF Feedback";
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
                    <?= Html::a('CLF Feedback', ['/clf/feedback'], ['class' => 'btn btn-success']) ?>
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
                        'template' => "<tr><th style='width:65%'>{label}</th><td style='width:35%'>{value}</td></tr>",
                        'attributes' => [
                            [
                                'attribute' => 'name_of_clf',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->clf != null ? $model->clf->name_of_clf : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->clf != null ? $model->clf->district_name : '';
                                }
                            ],
                            [
                                'attribute' => 'block_name',
                                'label' => 'Block ',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->clf != null ? $model->clf->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'ques_1',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques1;
                                }
                            ],
                            [
                                'attribute' => 'ques_2',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques2;
                                }
                            ],
                            [
                                'attribute' => 'ques_3',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques3;
                                }
                            ],
                            [
                                'attribute' => 'ques_4',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques4;
                                }
                            ],
                            [
                                'attribute' => 'ques_5',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques5;
                                }
                            ],
                            [
                                'attribute' => 'ques_5',
                                'label' => '6. अगर मोबाइल-ऐप आधारित व्यवस्था हो तो क्यों?',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return '';
                                }
                            ],
                            [
                                'attribute' => 'ques_61',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ques_61 == 1 ? '<i class="fal fa-check" aria-hidden="true"></i>' : '<i class="icon-check-empty"></i>';
                                }
                            ],
                            [
                                'attribute' => 'ques_62',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ques_62 == 1 ? '<i class="fal fa-check" aria-hidden="true"></i>' : '<i class="icon-check-empty"></i>';
                                }
                            ],
                            [
                                'attribute' => 'ques_63',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ques_63 == 1 ? '<i class="fal fa-check" aria-hidden="true"></i>' : '<i class="icon-check-empty"></i>';
                                }
                            ],
                            [
                                'attribute' => 'ques_64',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ques_64 == 1 ? '<i class="fal fa-check" aria-hidden="true"></i>' : '<i class="icon-check-empty"></i>';
                                }
                            ],
                            [
                                'attribute' => 'ques_65',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ques_65 == 1 ? '<i class="fal fa-check" aria-hidden="true"></i>' : '<i class="icon-check-empty"></i>';
                                }
                            ],
                            [
                                'attribute' => 'ques_66',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ques_66 == 1 ? '<i class="fal fa-check" aria-hidden="true"></i>' : '<i class="icon-check-empty"></i>';
                                }
                            ],
                            [
                                'attribute' => 'ques_7',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques7;
                                }
                            ],
                            [
                                'attribute' => 'ques_8',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques8;
                                }
                            ],
                            [
                                'attribute' => 'ques_9',
                                'label' => '9. प्रमुख 3 सुविधा',
                                'visible' => $model->ques_8 == '1',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return '';
                                }
                            ],
                            [
                        'attribute' => 'ques_91',
                        'visible' => $model->ques_8 == '1' and $model->ques_91 == '2',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_91 == 2 ? '' . $model->ques91oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_92',
                        'visible' => $model->ques_8 == '1' and $model->ques_92 == '2',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_92 == 2 ? '' . $model->ques92oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_93',
                        'visible' => $model->ques_8 == '1' and $model->ques_93 == '2',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_93 == 2 ? '' . $model->ques93oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_94',
                        'visible' => $model->ques_8 == '1' and $model->ques_94 == '2',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_94 == 2 ? '' . $model->ques94oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_95',
                        'visible' => $model->ques_8 == '1' and $model->ques_95 == '2',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_95 == 2 ? '' . $model->ques95oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_96',
                        'visible' => $model->ques_8 == '1' and $model->ques_96 == '2',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_96 == 2 ? '' . $model->ques96oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_97',
                        'visible' => $model->ques_8 == '1' and $model->ques_97 == '2',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_97 == 2 ? '' . $model->ques97oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_98',
                        'visible' => $model->ques_8 == '1' and $model->ques_98 == '2',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_98 == 2 ? '' . $model->ques98oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_99',
                        'visible' => $model->ques_8 == '1' and $model->ques_99 == '2',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_99 == 2 ? '' . $model->ques99oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                                        [
                        'attribute' => 'ques_9',
                        'label' => '9. अन्य सुविधाएँ',
                        'visible' => $model->ques_8 == '1',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return '';
                        }
                    ],
                    [
                        'attribute' => 'ques_91',
                        'visible' => $model->ques_8 == '1' and $model->ques_91 == '1',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_91 == 1 ? '' . $model->ques91oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_92',
                        'visible' => $model->ques_8 == '1' and $model->ques_92 == '1',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_92 == 1 ? '' . $model->ques92oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_93',
                        'visible' => $model->ques_8 == '1' and $model->ques_93 == '1',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_93 == 1 ? '' . $model->ques93oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_94',
                        'visible' => $model->ques_8 == '1' and $model->ques_94 == '1',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_94 == 1 ? '' . $model->ques94oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_95',
                        'visible' => $model->ques_8 == '1' and $model->ques_95 == '1',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_95 == 1 ? '' . $model->ques95oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_96',
                        'visible' => $model->ques_8 == '1' and $model->ques_96 == '1',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_96 == 1 ? '' . $model->ques96oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_97',
                        'visible' => $model->ques_8 == '1' and $model->ques_97 == '1',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_97 == 1 ? '' . $model->ques97oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_98',
                        'visible' => $model->ques_8 == '1' and $model->ques_98 == '1',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_98 == 1 ? '' . $model->ques98oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],
                    [
                        'attribute' => 'ques_99',
                        'visible' => $model->ques_8 == '1' and $model->ques_99 == '1',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ques_99 == 1 ? '' . $model->ques99oa.' रु' : '<i class="icon-check-empty"></i>';
                        }
                    ],        
                    [
                        'attribute' => 'ques_10',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->ques10;
                        }
                    ],
                            
                        ],
                    ])
                    ?>
                    <div class="col-lg-12">
                        <?= $model->group_photo != null ? '<span class="profile-picture">
                                        <img style="height:300px" src="' . $model->groupphotoUrl . '" data-src="' . $model->groupphotoUrl . '"  class="img-responsive lozad" title="सेल्फी  Photo"/>
                                        </span> ' : '-' ?> 
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>        
<?php
$js = <<<JS
observer = lozad('.lozad', {
load: function (el) {
el.src = el.getAttribute('data-src');
$(el).elevateZoom({
//zoomType: 'inner',
//cursor: 'crosshair'        
scrollZoom: true,
responsive: true,       
zoomWindowOffetx: -600
});
}
}); 
observer.observe();     
        
JS;
$this->registerJs($js);
?> 
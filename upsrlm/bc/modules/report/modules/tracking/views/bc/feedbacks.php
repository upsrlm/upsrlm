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

$this->title = 'BCs feedback';
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
<?= 'BCs feedback' ?>
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
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'header' => 'Srl.No.',],
                            [
                                'attribute' => 'bc_application_id',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->bc) ? $model->bc->name : '';
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'header' => 'Mobile No.',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->bc) ? common\helpers\Utility::mask($model->bc->mobile_no) . '<br/>' . common\helpers\Utility::mask($model->bc->mobile_number) : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'header' => 'BC District /<br/> BC Block/<br/> BC GP',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->bc) ? $model->bc->district_name . '/<br/>' . $model->bc->block_name . '/<br/>' . $model->bc->gram_panchayat_name : '';
                                }
                            ],
                            [
                                'attribute' => 'ques1',
                                'header' => 'BC Sakhi',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'visible' => (isset(Yii::$app->user->identity->role) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])),
                                'value' => function ($model) {
                                    return isset($model->ques1htmls) ? $model->ques1htmls : '';
                                }
                            ],
                            [
                                'attribute' => 'ques2',
                                'header' => 'Partner bank',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->ques2htmls) ? $model->ques2htmls : '';
                                }
                            ],
                            [
                                'attribute' => 'ques3',
                                'header' => 'Bank',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'visible' => (isset(Yii::$app->user->identity->role) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])),
                                'value' => function ($model) {
                                    return isset($model->ques3htmls) ? $model->ques3htmls : '';
                                }
                            ],
                            [
                                'attribute' => 'ques4',
                                'header' => 'Awareness gap',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'visible' => (isset(Yii::$app->user->identity->role) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])),
                                'value' => function ($model) {
                                    return isset($model->ques4htmls) ? $model->ques4htmls : '';
                                }
                            ],
                            [
                                'attribute' => 'ques5',
                                'header' => 'Operational issues',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'visible' => (isset(Yii::$app->user->identity->role) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])),
                                'value' => function ($model) {
                                    return isset($model->ques5htmls) ? $model->ques5htmls : '';
                                }
                            ],
                                    
                            [
                                'attribute' => 'pques1',
                                'header' => 'हैंडहेल्ड मशीन से सम्बंधित कोई समस्या',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'visible' => (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])),
                                'value' => function ($model) {
                                    return isset($model->hdhtmls) ? $model->hdhtmls : '';
                                }
                            ],
                            [
                                'attribute' => 'pques2',
                                'header' => 'फ्रॉड ट्रांसक्शन से  सम्बंधित कोई समस्या',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'visible' => (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])),
                                'value' => function ($model) {
                                    return isset($model->fthtmls) ? $model->fthtmls : '';
                                }
                            ],
//                            [
//                                'attribute' => 'pques3',
//                                'header' => 'बैंक से सम्बंधित कोई समस्या',
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'visible' => (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])),
//                                'value' => function ($model) {
//                                    return isset($model->pwbhtmls) ? $model->pwbhtmls : '';
//                                }
//                            ],
                            [
                                'attribute' => 'pques4',
                                'header' => 'BC  सखी के कमीशन पेमेंट भुगतान से सम्बंधित कोई समस्या',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'visible' => (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])),
                                'value' => function ($model) {
                                    return isset($model->pcbhtmls) ? $model->pcbhtmls : '';
                                }
                            ], 
                            [
                                'class' => 'kartik\grid\ExpandRowColumn',
                                'width' => '50px',
                                 'visible' => (isset(Yii::$app->user->identity->role) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])),
                                'value' => function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detail' => function ($model, $key, $index, $column) {
                                    return Yii::$app->controller->renderPartial('_feedbackdetail', ['model' => $model]);
                                },
                                'headerOptions' => ['class' => 'kartik-sheet-style'],
                                'expandOneOnly' => true,
                                'expandIcon' => '<span class="fal fa-caret-right glyphicon glyphicon-triangle-right"></span>',
                                'collapseIcon' => '<span class="fal fa-chevron-down glyphicon glyphicon-triangle-bottom"></span>',         
                            ],        
                        ],
                    ]);
                    ?>    
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
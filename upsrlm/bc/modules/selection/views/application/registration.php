<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;

$this->title = 'Report';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="dashboard-index">

    <?php
    Pjax::begin([
        'id' => 'grid-data',
        'enablePushState' => FALSE,
        'enableReplaceState' => FALSE,
        'timeout' => false,
    ]);
    ?>
    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
//                'fieldConfig' => [
//                    'template' => "<div class=\"col-lg-0\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
//                    'labelOptions' => ['class' => 'col-lg-0 control-label'],
//                ],
    ]);
    ?>


    <div class="ajax"> </div>
    <div class="col-xs-12">
        <div class="row">
            <?php if (true) {// (!Yii::$app->user->isGuest and ( count(array_intersect([UserModel::ROLE_ADMIN, UserModel::ROLE_CSO], ArrayHelper::getColumn(\Yii::$app->user->identity->userappliction, 'master_role_id'))) > 0)) {   ?> 
                <div class="col-xs-6 col-sm-2 pricing-box">
                    <div class="widget-box widget-color-blue3">
                        <div class="widget-header">
                            <h5 class=" bigger lighter">1. District with zero registration</h5>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="price col-sm-4">
                                        <?php
                                        echo \common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                        //echo ($dataProvider0->getTotalCount());
                                        ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '1']) ?>   
                                    </div>
                                </div>     
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>  


            <div class="col-xs-6 col-sm-2 pricing-box">
                <div class="widget-box widget-color-green">
                    <div class="widget-header">
                        <h5 class=" bigger lighter">2. Block with zero registration</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="row">
                                <div class="price col-sm-4">
                                    <?php
                                    echo \common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                    //echo ($dataProvider1->getTotalCount());
                                    ?>
                                </div>
                                <div class="col-sm-8">
                                    <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '2']) ?>   
                                </div>
                            </div>     
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2 pricing-box">
                <div class="widget-box widget-color-green">
                    <div class="widget-header">
                        <h5 class=" bigger lighter">3. GP not start registration</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="row">
                                <div class="price col-sm-4">
                                    <?php
                                    echo \common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count());
                                    //echo ($dataProvider1->getTotalCount());
                                    ?>
                                </div>
                                <div class="col-sm-8">
                                    <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '3']) ?>   
                                </div>
                            </div>     
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-3 pricing-box">
                <div class="widget-box widget-color-green">
                    <div class="widget-header">
                        <h5 class=" bigger lighter">4. GP start registration but incomplete</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="row">
                                <div class="price col-sm-4">
                                    <?php
                                    echo \common\helpers\Utility::numberIndiaStyle($dataProvider4->query->count());
                                    //echo ($dataProvider1->getTotalCount());
                                    ?>
                                </div>
                                <div class="col-sm-8">
                                    <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '4']) ?>   
                                </div>
                            </div>     
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row-fluid" style="padding-top:5px;padding-bottom:5px">
        <?php
        echo $this->render('_search', [
            'model' => $searchModel, 'form' => $form, 'button_type' => $button_type,
        ]);
        ?>
    </div>

    <div class="col-xs-12 applicant" id="printcontaineer">
        <?php
        if (isset($button_type) and $button_type != '') {
            ?>
            <div class="clear-fix"></div>
            <div class="<?= \Yii::$app->params['class'] ?>">    
                <div class="widget-header custom-header"><i class="ace-icon fa fa-globe"> </i> <?= \Yii::$app->params['title'] ?></div>
            </div>
            <?php
            if ($button_type == "1") {
                echo $this->render('@app/modules/srlm/views/bcselection/nordistrict', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'button_type' => $button_type,
                    'form' => $form,
                    'model' => $searchModel,
                ]);
            } elseif ($button_type == "2") {
                echo $this->render('@app/modules/srlm/views/bcselection/norblock', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'button_type' => $button_type,
                    'form' => $form,
                    'model' => $searchModel,
                ]);
            } elseif ($button_type == "3") {
                echo $this->render('@app/modules/srlm/views/bcselection/norgp', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'button_type' => $button_type,
                    'form' => $form
                ]);
            } elseif ($button_type == "4") {
                echo $this->render('@app/modules/srlm/views/bcselection/incomgp', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'button_type' => $button_type,
                    'form' => $form
                ]);
            }
            ?>

        <?php }
        ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php
    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/srlm/bcselection/registration"});
     $("#Searchform").attr("data-pjax", "True");         
      //$(this).closest('form').submit();
    });            
    var loader = $(".ajax");
    $(document).on({
        ajaxStart: function () {
           // loader.addClass("lmask");
        },
        ajaxStop: function () {
            loader.removeClass("lmask");
        }
    });
   $('#search-form').on('beforeSubmit', function () {
          
     
});   
          
JS;
    $this->registerJs($script);
    ?>      
    <?php Pjax::end(); ?>   

</div>    
<?php
$css = <<<cs
 .pagination{margin: 0px !important;}
cs;
$this->registerCss($css);
?>
   

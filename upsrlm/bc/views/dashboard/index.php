<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use kartik\widgets\Select2;
use bc\models\srlm\form\DashboardSearchForm;
use common\models\User;
use common\models\master\MasterRole;
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
//                    'template' => "{label}\n<div class=\"col-lg-0\">{input}</div>",
//                    'labelOptions' => ['class' => 'col-md-12 control-label'],
//                ],
    ]);
    ?>

    <div class="row-fluid" style="padding-top:5px;padding-bottom:5px">
        <?php
        echo $this->render('_search', [
            'model' => $searchModel, 'form' => $form
        ]);
        ?>
    </div>
    <div class="ajax"> </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6 col-sm-2 pricing-box">
                    <div class="widget-box widget-color-blue3">
                        <div class="widget-header">
                            <h5 class=" bigger lighter">0. Register OTP number </h5>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="price col-sm-4">
                                        <?php
                                        echo common\helpers\Utility::numberIndiaStyle($registeruser);
                                        //echo ($dataProvider0->getTotalCount());
                                        ?>
                                    </div>
<!--                                    <div class="col-sm-8">
                                        <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '1']) ?>   
                                    </div>-->
                                </div>     
                            </div>

                        </div>
                    </div>
                </div>
            <?php if (true) {// (!Yii::$app->user->isGuest and ( count(array_intersect([UserModel::ROLE_ADMIN, UserModel::ROLE_CSO], ArrayHelper::getColumn(\Yii::$app->user->identity->userappliction, 'master_role_id'))) > 0)) { ?> 
                <div class="col-xs-6 col-sm-2 pricing-box">
                    <div class="widget-box widget-color-blue3">
                        <div class="widget-header">
                            <h5 class=" bigger lighter">1. Total application submitted </h5>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="price col-sm-4">
                                        <?php
                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
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
                        <h5 class=" bigger lighter">2. Complete applications</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="row">
                                <div class="price col-sm-4">
                                    <?php
                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                    
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
            <div class="col-xs-6 col-sm-3 pricing-box">
                <div class="widget-box widget-color-green">
                    <div class="widget-header">
                        <h5 class=" bigger lighter">2a. Complete applications (Only Females)</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="row">
                                <div class="price col-sm-4">
                                    <?php
                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider2a->query->count());
                                    
                                    ?>
                                </div>
                                <div class="col-sm-8">
                                    <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '2a']) ?>   
                                </div>
                            </div>     
                        </div>

                    </div>
                </div>
            </div>
            <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN, MasterRole::ROLE_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_BDO, MasterRole::ROLE_MC])) { ?>
                <div class="col-xs-6 col-sm-2 pricing-box">
                    <div class="widget-box widget-color-red">
                        <div class="widget-header">
                            <h5 class=" bigger lighter">3. Incomplete applications</h5>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="price col-sm-4">
                                        <?php
                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count());
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
                    <div class="widget-box widget-color-red">
                        <div class="widget-header">
                            <h5 class=" bigger lighter">3a. Incomplete applications (Only Females)</h5>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="price col-sm-4">
                                        <?php
                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider3a->query->count());
                                        ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '3a']) ?>   
                                    </div>
                                </div>     
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?> 



            <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BDO, MasterRole::ROLE_MC])) { ?>
                <!--                <div class="col-xs-6 col-sm-2 pricing-box">
                                    <div class="widget-box widget-color-blue">
                                        <div class="widget-header">
                                            <h5 class=" bigger lighter">3. Hhs Return (by Others)</h5>
                                        </div>
                
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="price col-sm-4">
                <?php
                //  echo app\common\helpers\Utility::numberIndiaStyle($dataProvider3a->query->count());
                //echo ($dataProvider1a->getTotalCount());
                ?>
                                                    </div>
                                                    <div class="col-sm-8">
                <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '3a']) ?>   
                                                    </div>
                                                </div>     
                                            </div>
                
                                        </div>
                                    </div>
                                </div>-->
            <?php } ?>
            <!--            <div class="col-xs-6 col-sm-2 pricing-box">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <h5 class="bigger lighter">4. Hhs Application Received</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row">
                                            <div class="price col-sm-4">
            <?php
            //   echo app\common\helpers\Utility::numberIndiaStyle($dataProvider4->query->count());
            //echo ($dataProvider2->getTotalCount());
            ?>
                                            </div>
                                            <div class="col-sm-8">
            <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '4']) ?>   
                                            </div>
                                        </div>     
                                    </div>
                                </div>
            
                            </div>
                        </div>-->
            <?php if (true) {// (!Yii::$app->user->isGuest and ( count(array_intersect([UserModel::ROLE_CSO, UserModel::ROLE_DC, UserModel::ROLE_TEAM], ArrayHelper::getColumn(\Yii::$app->user->identity->userappliction, 'master_role_id'))) > 0)) {  ?>
                <!--                <div class="col-xs-6 col-sm-2 pricing-box">
                                    <div class="widget-box widget-color-red">
                                        <div class="widget-header">
                                            <h5 class="bigger lighter">5. High priority Hhs</h5>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="price col-sm-4">
                <?php
                // echo app\common\helpers\Utility::numberIndiaStyle($dataProvider5->query->count());
                //echo ($dataProvider2a->getTotalCount());
                ?>
                                                    </div>
                                                    <div class="col-sm-8">
                <?= Html::submitButton('More Info <i class="ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '5']) ?>   
                                                    </div>
                                                </div>     
                                            </div>
                                        </div>
                
                                    </div>
                                </div>-->

            <?php } ?>


        </div>
    </div>

</div>
<?php
$class = 'hide';
if ($button_type == "3a") {
    $class = 'show';
}
?>
<div class="hscamurut-search <?= $class ?>" >
    <div class="col-xs-12">  

        <?php
        echo $form->field($searchModel, 'section_at')->widget(Select2::classname(), [
            'data' => [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'],
            'options' => ['placeholder' => 'Select Section at', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('');
        ?>


        <div class="form-group">

            <?php echo Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn']) ?>
            <?= Html::button('<i class="fa fa-file-excel-o"></i> Download Incomplete applications (Only Females) CSV', ['class' => 'btn  btn-primary','style' => 'margin-top:10px;width:75px;margin-left:10px', 'id' => 'download', 'name' => 'download', 'value' => 'download', 'style' => 'padding: 6px 12px']) ?>
        </div>
    </div>       
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
            echo $this->render('@app/modules/srlm/modules/data/views/bcselection/bcselection_covered', ['searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'button_type' => $button_type,
                'form' => $form
            ]);
        } elseif ($button_type == "3") {
            echo $this->render('@app/modules/srlm/modules/data/views/bcselection/bcselection_incomplete', ['searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'button_type' => $button_type,
                'form' => $form
            ]);
        }elseif ($button_type == "3a") {
            echo $this->render('@app/modules/srlm/modules/data/views/bcselection/bcselection_incomplete_women', ['searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'button_type' => $button_type,
                'form' => $form
            ]);
        } elseif ($button_type == "2") {
            echo $this->render('@app/modules/srlm/modules/data/views/bcselection/bcselection_completed', ['searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'button_type' => $button_type,
                'form' => $form
            ]);
        }elseif ($button_type == "2a") {
            echo $this->render('@app/modules/srlm/modules/data/views/bcselection/bcselection_completed_women', ['searchModel' => $searchModel,
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
    $("#Searchform").attr({ "action":"/dashboard"});
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
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
    $('.applicant').html('');       
     
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
   

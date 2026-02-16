<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use common\models\User;
use common\models\master\MasterRole;
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

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
                                'layout' => 'inline',
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'method' => 'get',
                    ]);
                    ?>

                    <?php
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <div class="clearfix mt-3"></div>
                    <div class="col-xs-12 pt-3">
                        <div class="row">
                            <div class="col-xs-6 col-sm-3 pricing-box">
                                <div class="card">
                                    <div class="card-header bg-info-100">
                                        0. Register OTP number
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="price col-sm-6">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($registeruser);
                                                ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '1']) ?>   
                                            </div>
                                        </div>     
                                    </div>

                                </div>
                            </div>

                            <?php if (true) {// (!Yii::$app->user->isGuest and ( count(array_intersect([UserModel::ROLE_ADMIN, UserModel::ROLE_CSO], ArrayHelper::getColumn(\Yii::$app->user->identity->userappliction, 'master_role_id'))) > 0)) {   ?> 
                                <div class="col-xs-6 col-sm-3 pricing-box">
                                    <div class="card">
                                        <div class="card-header bg-info-100">
                                            1. Total Registration Start 
                                        </div>

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="price col-sm-6">
                                                    <?php
                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                                    ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?= Html::submitButton('More Info <i class="fal fa-angle-right ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '1']) ?>   
                                                </div>
                                            </div>     
                                        </div>

                                    </div>

                                </div>
                            <?php } ?>  
                            <div class="col-xs-6 col-sm-3 pricing-box">
                                <div class="card">
                                    <div class="card-header bg-success-100">
                                        2. Complete applications
                                    </div>

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="price col-sm-6">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= Html::submitButton('More Info <i class="fal fa-angle-right ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '2']) ?>   
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3 pricing-box">
                                <div class="card">
                                    <div class="card-header bg-success-500">
                                        2a. Complete applications (Only Females)
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="price col-sm-6">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider2a->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= Html::submitButton('More Info <i class="fal fa-angle-right ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '2a']) ?>   
                                            </div>
                                        </div>     

                                    </div>
                                </div>
                            </div>
                            <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN, MasterRole::ROLE_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_BDO, MasterRole::ROLE_MC])) { ?>
                                <div class="col-xs-6 col-sm-3 pricing-box mt-2">
                                    <div class="card">
                                        <div class="card-header bg-danger-300">
                                            3. Incomplete applications
                                        </div>

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="price col-sm-6">
                                                    <?php
                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count());
                                                    ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?= Html::submitButton('More Info <i class="fal fa-angle-right ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '3']) ?>   
                                                </div>
                                            </div>     
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-3 pricing-box mt-2">
                                    <div class="card">
                                        <div class="card-header bg-danger-300">
                                            3a. Incomplete applications (Only Females)
                                        </div>


                                        <div class="card-body">

                                            <div class="row">
                                                <div class="price col-sm-6">
                                                    <?php
                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider3a->query->count());
                                                    ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?= Html::submitButton('More Info <i class="fal fa-angle-right  ace-icon fa fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '3a']) ?>   
                                                </div>
                                            </div>     
                                        </div>

                                    </div>
                                </div>
                            <?php } ?> 

                        </div>
                    </div>


                    <?php
                    $class = 'd-none';
                    if ($button_type == "3a") {
                        $class = 'd-block';
                    }
                    ?>
                    <div class="hscamurut-search <?= $class ?>" >
                        <div class="col-lg-12">  

                            <?php
                            echo $form->field($searchModel, 'section_at')->widget(Select2::classname(), [
                                'data' => [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'],
                                'options' => ['placeholder' => 'Select Section at', 'style' => 'width:250px'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('');
                            ?>
                            <?php echo Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn']) ?>
                            <?= Html::button('<i class="fal fa-file-excel"></i> Download Incomplete applications (Only Females) CSV', ['class' => 'btn  btn-primary', 'style' => 'margin-left:10px', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>

                        </div>       
                    </div>  
                    <div class="col-lg-12 applicant" id="printcontaineer">
                        <?php
                        if (isset($button_type) and $button_type != '') {
                            ?>
                            <div class="card ">    
                                <div class="card-header <?= \Yii::$app->params['class'] ?>"><i class="fal fa-user"> </i> <?= \Yii::$app->params['title'] ?></div>
                            </div>
                            <div class="card-body">
                                <?php
                                if ($button_type == "1") {
                                    echo $this->render('@bc/modules/selection/modules/phasefour/views/application/bcselection_covered', ['searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                        'button_type' => $button_type,
                                        'form' => $form
                                    ]);
                                } elseif ($button_type == "3") {
                                    echo $this->render('@bc/modules/selection/modules/phasefour/views/application/bcselection_incomplete', ['searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                        'button_type' => $button_type,
                                        'form' => $form
                                    ]);
                                } elseif ($button_type == "3a") {
                                    echo $this->render('@bc/modules/selection/modules/phasefour/views/application/bcselection_incomplete_women', ['searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                        'button_type' => $button_type,
                                        'form' => $form
                                    ]);
                                } elseif ($button_type == "2") {
                                    echo $this->render('@bc/modules/selection/modules/phasefour/views/application/bcselection_completed', ['searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                        'button_type' => $button_type,
                                        'form' => $form
                                    ]);
                                } elseif ($button_type == "2a") {
                                    echo $this->render('@bc/modules/selection/modules/phasefour/views/application/bcselection_completed_women', ['searchModel' => $searchModel,
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
    $("#Searchform").attr({ "action":"/selection/phase4/dashboard"});
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});            

   $('#search-form').on('beforeSubmit', function () {
    $('.applicant').html('');       
     
});   
           
JS;
                        $this->registerJs($script);
                        ?>
                    </div>     
                    <?php Pjax::end(); ?>   

                </div>
            </div>
        </div> 
    </div>



<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\transaction\BcTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transaction performance report';
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
                    echo $this->render('_searchprimary', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>


                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-warning-700 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->select('bc_application_id')->distinct()->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total BC operational</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-dark ', 'name' => 'button_type', 'value' => '1']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider1))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total no. of Txn.</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-dark', 'name' => 'button_type', 'value' => '2']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa fa-volume-up position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider2))
                                                echo '<i class="fal fa-rupee-sign"></i> '.common\helpers\Utility::numberIndiaStyle($dataProvider2->query->sum('transaction_amount'));
                                            ?>
                                            <small class="m-0 l-h-n">Total transaction amount</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-dark', 'name' => 'button_type', 'value' => '3']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-rupee-sign fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider3))
                                                echo '<i class="fal fa-rupee-sign"></i> '.common\helpers\Utility::numberIndiaStyle($dataProvider3->query->sum('commission_amount'));
                                            ?>
                                            <small class="m-0 l-h-n">Total BC commission earned</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-dark', 'name' => 'button_type', 'value' => '4']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-rupee-sign fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-12" ">
                        <?php
                        if (isset($button_type) and $button_type != '') {
                            ?>

                            <?php
                            if ($button_type == "1") {
                                echo $this->render('total_bcs_operational', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProviderdata,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "2") {
//                                echo $this->render('total_no_of_txn', ['searchModel' => $searchModel,
//                                    'dataProvider' => $dataProviderdata,
//                                    'button_type' => $button_type,
//                                    'form' => $form
//                                ]);
                            } elseif ($button_type == "3") {
//                                echo $this->render('total_amount_transacted', ['searchModel' => $searchModel,
//                                    'dataProvider' => $dataProviderdata,
//                                    'button_type' => $button_type,
//                                    'form' => $form
//                                ]);
                            } elseif ($button_type == "4") {
//                                echo $this->render('total_bc_commission_earned', ['searchModel' => $searchModel,
//                                    'dataProvider' => $dataProviderdata,
//                                    'button_type' => $button_type,
//                                    'form' => $form
//                                ]);
                            }
                            ?>

                        <?php }
                        ?>
                    </div> 
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
   
JS;
                    $this->registerJs($script);
                    ?>
                    <?php ActiveForm::end(); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div> 
        </div>
    </div>
</div>

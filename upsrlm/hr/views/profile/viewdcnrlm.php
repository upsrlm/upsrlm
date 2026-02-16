<?php

use yii\helpers\Html;
use kartik\password\PasswordInput;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\TouchSpin;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\helpers\Url;

$style = <<< CSS
        .form-group {margin-bottom:5px;}
   .help-block {margin-top:3px;margin-bottom:3px;      }
    .form-horizontal .control-label {padding-top:0px;}
        .title {font-weight:bold; font-size:16px;}

CSS;
$this->registerCss($style);

$this->title = 'Profile View';
$this->params['breadcrumbs'][] = $this->title;
if (Yii::$app->session->hasFlash('error')) {
    echo "<div class='alert alert-success'>" . Yii::$app->session->getFlash('error') . "</div>";
}
?>
<div class='profile-form' style="padding:0px 10px;background-color: white">
    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Personal Information
            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'first_name',
                        ],
                    ])
                    ?>
                </div>
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'middle_name',
                        ],
                    ])
                    ?>  

                </div>
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'sur_name',
                        ],
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Contact Detail 
            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-6">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'primary_phone_no',
                            'alternate_phone_no'
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-6">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'whatsapp_no',
                            'email_id'
                        ],
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Official Information
            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-4">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'designation',
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'posting_district_name',
                        ],
                    ])
                    ?> 

                </div>
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'office_address',
                        ],
                    ])
                    ?> 

                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-3"> 

            <?= $user_model->profile_status == 0 ? Html::a('<i class="fa fa-thumb-up"></i> Update Profile', '/profile/update', ['id' => 'view-button', 'class' => 'btn btn-sm btn-info btn-block', 'style' => 'width:300px', 'title' => '']) : ""; ?>
        </div>       

        <div class="col-md-3"></div>
    </div>

</div>


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
        font-weight: normal;
    }
    hr{
        margin: 5px;
        height: 1px;
        background-color: #ccc;
        width: 106.8%;
    }

</style>

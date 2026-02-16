<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>
<?php if (isset($model)) { ?>

    <div class='box bordered-box orange-border grey-background' style="padding:10px;margin:20px;background-color: #bbbbbb">       
        <div class='box-header box-main-header grey-background'>
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Nodal Officer Information
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
                <div class="col-md-6">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name_of_organization',
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-6">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'designation',
                        ],
                    ])
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'inst_email',
                            'office_phone_no',
                            'office_address',
                        ],
                    ])
                    ?> 

                </div>
                <div class="col-md-6">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'hq_email',
                            'hq_phone_no',
                            'hq_address',
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
                Name of signatory of  Agreement with UPSRLM/ DoRD
            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'signatory_first_name',
                        ],
                    ])
                    ?>
                </div>
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'signatory_middle_name',
                        ],
                    ])
                    ?>  

                </div>
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'signatory_sur_name',
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
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'signatory_primary_phone_no',
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'signatory_alternate_phone_no'
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-4">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'signatory_whatsapp_no',
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
                <div class="col-md-6">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name_of_organization',
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-6">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'signatory_designation',
                        ],
                    ])
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'signatory_inst_email',
                            'signatory_office_phone_no',
                            'signatory_office_address',
                        ],
                    ])
                    ?> 

                </div>
                <div class="col-md-6">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'signatory_hq_email',
                            'signatory_hq_phone_no',
                            'signatory_hq_address',
                        ],
                    ])
                    ?> 

                </div>
            </div>
        </div>
    </div>



<?php } ?>
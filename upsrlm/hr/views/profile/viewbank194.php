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
                            [
                                'attribute' => 'bank_name',
                                'enableSorting' => false,
                                'label' => 'Name of Bank',
                                'value' => function ($model) {
                                    return $model->bank_name != null ? $model->bank_name : '';
                                }
                            ],
                        ],
                    ])
                    ?>
                </div>    
                <div class="col-md-4">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'first_name',
                                'enableSorting' => false,
                                'label' => 'Name of nodal officer/user',
                                'value' => function ($model) {
                                    return $model->first_name != null ? $model->first_name : '';
                                }
                            ],
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
                            [
                                'attribute' => 'primary_phone_no',
                                'enableSorting' => false,
                                'label' => 'Mobile No./user login',
                                'value' => function ($model) {
                                    return $model->primary_phone_no != null ? $model->primary_phone_no : '';
                                }
                            ],
                            [
                                'attribute' => 'alternate_phone_no',
                                'enableSorting' => false,
                                'label' => 'Alternate Mobile No.',
                                'value' => function ($model) {
                                    return $model->alternate_phone_no != null ? $model->alternate_phone_no : '';
                                }
                            ],
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-6">
                     <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'whatsapp_no',
                                'enableSorting' => false,
                                'label' => 'Whatsapp No',
                                'value' => function ($model) {
                                    return $model->whatsapp_no != null ? $model->whatsapp_no : '';
                                }
                            ],
                            [
                                'attribute' => 'email_id',
                                'enableSorting' => false,
                                'label' => 'Email ID.',
                                'value' => function ($model) {
                                    return $model->email_id != null ? $model->email_id : '';
                                }
                            ],
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
                <div class="col-md-3">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'place_of_posting',
                                'enableSorting' => false,
                                'label' => 'Place Of Posting.',
                                'value' => function ($model) {
                                    return (isset($model->profle_model) and $model->profle_model->place_of_posting != null) ? $model->profle_model->place_of_posting : '';
                                }
                            ],
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-3">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                             [
                                'attribute' => 'designation',
                                'enableSorting' => false,
                                'label' => 'Designation.',
                                'value' => function ($model) {
                                    return $model->designation != null ? $model->designation : '';
                                }
                            ],
                           
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-3">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                             [
                                'attribute' => 'employee_code_id',
                                'enableSorting' => false,
                                'label' => 'Employee code/ id no.',
                                'value' => function ($model) {
                                    return (isset($model->profle_model) and $model->profle_model->employee_code_id != null) ? $model->profle_model->employee_code_id : '';
                                }
                            ],
                           
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
               Reporting Officer Information
            </div>

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-3">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'bank_name_of_reporting_officer',
                                'enableSorting' => false,
                                'label' => 'Name of your reporting officer',
                                'value' => function ($model) {
                                    return (isset($model->profle_model) and $model->profle_model->bank_name_of_reporting_officer != null) ? $model->profle_model->bank_name_of_reporting_officer : '';
                                }
                            ],
                        ],
                    ])
                    ?>
                </div>
                <div class="col-md-3">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'bank_mobile_no_reporting_officer',
                                'enableSorting' => false,
                                'label' => 'Mobile no. of reporting officer',
                                'value' => function ($model) {
                                    return (isset($model->profle_model) and $model->profle_model->bank_mobile_no_reporting_officer != null) ? $model->profle_model->bank_mobile_no_reporting_officer : '';
                                }
                            ],
                        ],
                    ])
                    ?>  

                </div>
                <div class="col-md-3">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'bank_whatsapp_no_reporting_officer',
                                'enableSorting' => false,
                                'label' => 'WhatsApp no. of reporting officer',
                                'value' => function ($model) {
                                    return (isset($model->profle_model) and $model->profle_model->bank_whatsapp_no_reporting_officer != null) ? $model->profle_model->bank_whatsapp_no_reporting_officer : '';
                                }
                            ],
                        ],
                    ])
                    ?>

                </div>
                <div class="col-md-3">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'bank_email_reporting_officer',
                                'enableSorting' => false,
                                'label' => 'Email id: of reporting officer',
                                'value' => function ($model) {
                                    return (isset($model->profle_model) and $model->profle_model->bank_email_reporting_officer != null) ? $model->profle_model->bank_email_reporting_officer : '';
                                }
                            ],
                        ],
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>

    



<?php } ?>
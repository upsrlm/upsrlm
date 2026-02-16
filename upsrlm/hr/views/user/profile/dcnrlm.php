<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>
<?php if(isset($model)){ ?>

    <div class="panel panel-info">
        <div class="panel-heading panel-info">
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Personal Information
            </div>

        </div>            
        <div class='panel-body'>  
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

    <div class="panel panel-info">
        <div class="panel-heading panel-info">
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Contact Detail 
            </div>

        </div>            
        <div class='panel-body'> 
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

    <div class="panel panel-info">
        <div class="panel-heading panel-info">
            <div class='title'>
                <i class='icon-minus-sign'></i>
                Official Information
            </div>

        </div>            
        <div class='panel-body'> 
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


<?php } ?>
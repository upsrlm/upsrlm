<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;
?>
<?php if (isset($model)) { ?>
    
        <div class="panel panel-info">
            <div class="panel-heading panel-info">
                <div class='title'>
                    <i class='icon-minus-sign'></i>
                    Personal Information
                </div>

            </div>  
            <div class='panel-body'>   

                <div class="row">
                    <div class="col-md-6">

                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'first_name',
                                'middle_name',
                                'sur_name',
                                'father_name',
                                'date_of_birth',
                                [
                                    'attribute' => 'gender',
                                    'format' => 'raw',
                                    'value' => $model->gendr,
                                ],
                                'aadhaar_number',
                                'pan_number'
                            ],
                        ])
                        ?>
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'photo_profile',
                                    'visible' => ($model->photo_profile != NULL),
                                    'format' => 'raw',
                                    'value' => $model->photo_profile != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->getImageUrl("photo_profile") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
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
                                    'attribute' => 'photo_aadhaar_front',
                                    'visible' => ($model->photo_aadhaar_front != NULL),
                                    'format' => 'raw',
                                    'value' => $model->photo_aadhaar_front != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->getImageUrl("photo_aadhaar_front") . '" class="lozad" title="" style="cursor : pointer"/> 
                                  </span>' : '',
                                ],
                            ],
                        ])
                        ?> 



                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'photo_aadhaar_back',
                                    'visible' => ($model->photo_aadhaar_back != NULL),
                                    'format' => 'raw',
                                    'value' => $model->photo_aadhaar_back != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->getImageUrl("photo_aadhaar_back") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                                ],
                            ],
                        ])
                        ?> 

                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'photo_pan',
                                    'visible' => ($model->photo_pan != NULL),
                                    'format' => 'raw',
                                    'value' => $model->photo_pan != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->getImageUrl("photo_pan") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                                ],
                            ],
                        ])
                        ?> 
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info"> 
                            <div class="panel-heading panel-info">

                                <i class='icon-minus-sign'></i>
                                Present Address
                            </div>
                            <div class='panel-body'>
                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        'present_address_house_no',
                                        'present_address_street_mohalla',
                                        'present_address_postoffice',
                                        'present_address_district',
                                        'present_address_state'
                                    ],
                                ])
                                ?>
                            </div>
                        </div>
                    </div>    
                    <div class="col-md-6">
                        <div class="panel panel-info"> 
                            <div class="panel-heading panel-info">

                                <i class='icon-minus-sign'></i>
                                Permanent Address

                            </div> 
                            <div class='panel-body'>    
                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        'permanent_address_house_no',
                                        'permanent_address_street_mohalla',
                                        'permanent_address_postoffice',
                                        'permanent_address_district',
                                        'permanent_address_state'
                                    ],
                                ])
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading panel-info">
                    <i class='icon-minus-sign'></i>
                    Official Information
                </div>           
                <div class='panel-body'>
                    <div class="row">
                        <div class="col-md-6">

                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'designation',
                                    'date_of_joining',
                                    'posting_district_name',
                                    'date_of_last_posting'
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
                                        'attribute' => 'photo_letter_of_appointment',
                                        'visible' => ($model->photo_letter_of_appointment != NULL),
                                        'format' => 'raw',
                                        'value' => $model->photo_letter_of_appointment != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->getImageUrl("photo_letter_of_appointment") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                                    ],
                                ],
                            ])
                            ?> 


                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'photo_service_agreement',
                                        'visible' => ($model->photo_service_agreement != NULL),
                                        'format' => 'raw',
                                        'value' => $model->photo_service_agreement != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->getImageUrl("photo_service_agreement") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                                    ],
                                ],
                            ])
                            ?> 

                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'photo_letter_of_last_posting_order',
                                        'visible' => ($model->photo_letter_of_last_posting_order != NULL),
                                        'format' => 'raw',
                                        'value' => $model->photo_letter_of_last_posting_order != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->getImageUrl("photo_letter_of_last_posting_order") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                                    ],
                                ],
                            ])
                            ?> 

                        </div>
                    </div>
                </div>
            </div>


            <div class="panel panel-info">
                <div class="panel-heading panel-info">
                    <i class='icon-minus-sign'></i>
                    Salary Bank Account Detail            
                </div>

                <div class="panel-body">            

                    <div class="row">
                        <div class="col-md-6">

                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'bank_name',
                                    'bank_branch',
                                    'bank_account_number',
                                    'bank_ifsc_code'
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
                                        'attribute' => 'photo_pan',
                                        'visible' => ($model->photo_bank_passbook != NULL),
                                        'format' => 'raw',
                                        'value' => $model->photo_bank_passbook != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->getImageUrl("photo_bank_passbook") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
                                  </span>' : '',
                                    ],
                                ],
                            ])
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading panel-info">
                    <i class='icon-minus-sign'></i>
                    Brief professional profile           

                </div>            
                <div class='box-content box-status'>
                    <div class="row">
                        <div class="col-md-6">

                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'brief_professional_profile',
                                    'academic_qualification_awards',
                                    'professional_training',
                                ],
                            ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'experience',
                                    'professional_association'
                                ],
                            ])
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
           <?php echo $this->render('verificationstaus', ['model' => $model]);?>
        </div>
    
    <?php
    $js = <<<JS
$(function () {
        $('.popb').elevateZoom({
         scrollZoom : true,
        responsive : true,
        zoomWindowOffetx:-600
   });
   $('.popbc').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
        });
});  

JS;
    $this->registerJs($js);
    ?>
    <?php
    $js = <<<JS
                
        observer = lozad('.lozad', {
                                        load: function (el) {
                                            console.log('loading element');
                                            el.src = el.getAttribute('data-src');
                                            // Custom implementation to load an element
                                            // e.g. el.src = el.getAttribute('data-src');

                
                
                                                $(el).elevateZoom({
                                                    scrollZoom: true,
                                                    responsive: true,
                                                    zoomWindowOffetx: -600
                                                });
                                                $('.popbc').click(function () {
                                                    $('#imagecontent').html('');
                                                    $('#modal').modal('show')
                                                            .find('#imagecontent')
                                                            .load($(this).attr('value'));
                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
                                                });

//                                            $(function () {
//                                                $('.popb').elevateZoom({
//                                                    scrollZoom: true,
//                                                    responsive: true,
//                                                    zoomWindowOffetx: -600
//                                                });
//                                                $('.popbc').click(function () {
//                                                    $('#imagecontent').html('');
//                                                    $('#modal').modal('show')
//                                                            .find('#imagecontent')
//                                                            .load($(this).attr('value'));
//                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
//                                                });
//                                            });

                                        }
                                    }); // lazy loads elements with default selector as '.lozad'
                                    observer.observe();     
        
JS;
    $this->registerJs($js);
    ?> 
<?php } ?>

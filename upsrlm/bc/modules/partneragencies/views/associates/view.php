<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bc\models\PartnerAssociates */

$this->title = $model->name_of_the_field_officer;
$this->params['breadcrumbs'][] = ['label' => 'Field Associates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
                    <div class="row">
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'name_of_the_field_officer',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->name_of_the_field_officer;
                                        }
                                    ],
                                    [
                                        'attribute' => 'gender',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->gen;
                                        }
                                    ],
                                    [
                                        'attribute' => 'age',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->age;
                                        }
                                    ],
                                    [
                                        'attribute' => 'designation',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->designation;
                                        }
                                    ],
                                    [
                                        'attribute' => 'mobile_no',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->mobile_no;
                                        }
                                    ],
                                    [
                                        'attribute' => 'alternate_mobile_no',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->alternate_mobile_no;
                                        }
                                    ],
                                    [
                                        'attribute' => 'whatsapp_no',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->whatsapp_no;
                                        }
                                    ],
                                    [
                                        'attribute' => 'email_id',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return isset($model->email_id) ? $model->email_id : '';
                                        }
                                    ],
                                ],
                            ])
                            ?>   
                        </div>
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'name_of_supervisor',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->name_of_supervisor;
                                        }
                                    ],
                                    [
                                        'attribute' => 'designation_of_supervisor',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->designation_of_supervisor;
                                        }
                                    ],
                                    [
                                        'attribute' => 'mobile_no_of_supervisor',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->mobile_no_of_supervisor;
                                        }
                                    ],
                                    [
                                        'attribute' => 'bank_account_number',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->bank_account_number;
                                        }
                                    ],
                                    [
                                        'attribute' => 'District',
                                        'header' => 'District',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            $html = '';

                                            $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->disblock, 'district.district_name')));

                                            return $html;
                                        },
                                    ],
                                    [
                                        'attribute' => 'Block',
                                        'header' => 'Block',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            $html = '';

                                            $html .= '' . implode(', ', array_unique(ArrayHelper::getColumn($model->disblock, 'block.block_name')));

                                            return $html;
                                        },
                                    ],
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
                        </div>
                        <div class="col-md-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'company_letter',
                                        'visible' => ($model->company_letter != NULL),
                                        'format' => 'raw',
                                        'value' => $model->company_letter != NULL ? '<span class="profile-picture">
                                  <img width="220px" src="" data-src="' . $model->getImageUrl("company_letter") . '" class="lozad" title="Profile Photo" style="cursor : pointer"/> 
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


                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
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

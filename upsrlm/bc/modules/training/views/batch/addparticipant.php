<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use bc\models\master\MasterBlock;

$this->title = 'Add Participant';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="training-default-index">
    <div class="panel panel-default">
        <div class='panel-body'>
            <div class="col-md-4">

                <div>District : <?= $bmodel->district->district_name ?></div>
            </div>

            <div class="col-md-4">  
                <div>Batch Name :<?= $bmodel->batch_name ?></div>
            </div>

            <div class="col-md-4">

                <div id="applied">Batch Participant : <?= $model->batch_participant_count ?></div>
            </div>

            <?php
            if ($model->remaining_participant > 0) {

                $form = ActiveForm::begin([
                            'enableClientValidation' => true,
                ]);
                ?>



                <div class="col-xs-12" style="margin-top: 10px;">
                    <?=
                    $form->field($model, 'block_code')->dropDownList($model->block_option, [
                        'prompt' => '--Select Block',
                        'onchange' => '
                            $.post("/training/batch/getparticipants?&block=' . '" +$(this).val(), function (data){
                                $("#batchparticipantform-participant_ids").html( data );
                            });',
                    ])
                    ?>
                </div>



                <div class="col-xs-12">
                    <?= $form->field($model, 'participant_ids')->dropDownList([], ['prompt' => '--Select Participant--', 'multiple' => 'multiple', 'size' => 10]) ?>
                </div>



                <div class="col-xs-12">
                    <div class="text-center">
                        <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php
                ActiveForm::end();
            }
            ?>

        </div>
    </div>
</div>


<script type="text/javascript">
//    $(document).ready(function () {
//        var last_valid_selection = null;
//
//        $('#batchform-participant_ids').change(function (event) {
//
//            if ($(this).val().length > $('#remaining').text()) {
//
//                $(this).val(last_valid_selection);
//            } else {
//                last_valid_selection = $(this).val();
//            }
//        });
//    });
</script>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
$this->title = 'साड़ी की प्राप्ति';

$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    function takePictureSarre1(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatasaree1(data) {
        document.getElementById('bcsareeackform-get_saree1_quality_photo').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('saree1-image').setAttribute('value', data);
        if (typeof AndroidDevice !== "undefined") {
        }
    }
    function takePictureSarre2(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatasaree2(data) {
        document.getElementById('bcsareeackform-get_saree2_quality_photo').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('saree2-image').setAttribute('value', data);
        if (typeof AndroidDevice !== "undefined") {
        }
    }
    var date1 = <?= isset($model->get_saree1_date) ? strtotime($model->get_saree1_date) . '000' : 0 ?>;
    var date2 = <?= isset($model->get_saree2_date) ? strtotime($model->get_saree2_date) . '000' : 0 ?>;
    var mindate = <?= strtotime('2021-06-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;
</script>
<div class="clf-form">
    <div class="panel panel-default">

        <div class="col-lg-12">
            <div>
                <h2>साड़ी की प्राप्ति और क्वालिटी के सम्बंध में </h2> 

            </div>
            <div class='panel-body'>
                <?php $form = ActiveMobileForm::begin(['id' => 'form-bc-ack_saree', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  

                <?php
                if ($model->saree == 1) {
                    echo $this->render('_saree1', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
                if ($model->saree == 2) {
                    echo $this->render('_saree2', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
                ?>
                <div class="form-group text-center">
                    <?= $form->field($model, 'bc_application_id')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'saree')->hiddenInput()->label(false); ?>
                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                </div>
                <?php ActiveMobileForm::end(); ?>
            </div>
        </div>    
    </div>    

</div>
<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  

CSS;
$this->registerCss($style);
?>
<style>
    .col-lg-12 {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }

    .card .card-body {
        padding: 0px
    }

    .card-body .card {
        margin: 5px 0px
    }

    .card-body .card> :last-child,
    .card-group> :last-child {
        margin-bottom: 10px;
        margin-top: 5px;
    }

    .form-group:last-child,
    .form-group:only-child {
        margin-bottom: 10px;
    }
</style>
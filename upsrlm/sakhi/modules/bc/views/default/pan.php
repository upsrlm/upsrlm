<?php

use yii\bootstrap4\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    function takePicture(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageData(data) {
        document.getElementById('displayImage').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('pan').setAttribute('value', data);
        if (typeof AndroidDevice !== "undefined") {
        }
    }
    function imageData1(data) {
        document.getElementById('displayImage1').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('pan1').setAttribute('value', data);
        if (typeof AndroidDevice !== "undefined") {
        }
    }
</script>
<div class="panel panel-default">
    <div class="col-lg-12">
        <?= Html::beginForm(['/bc/default/pan', 'bcid' => $model->id], 'post', ['enctype' => 'multipart/form-data']) ?>

        <div class="col-lg-12">
            <button type="button" class="btn btn-info" onClick="takePicture('imageData')">
                <i class="fal fa-camera"></i> पैन कार्ड फोटो खीचे
            </button>
            <input type="hidden" value="" name='pan' id="pan">
        </div>
        <div class="col-lg-12 mt-3"><img id="displayImage" src="" class="img-responsive" width="200" height="300"/></div>
        <div class="col-lg-12 mt-3">
            <?= Html::submitButton('<i class="fal fa-upload"></i> अपलोड करें', ['class' => 'submit btn btn-danger']) ?>
        </div>    
        <?= Html::endForm() ?>
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
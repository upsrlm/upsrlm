<?php

use yii\bootstrap4\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    function takePicture(output) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(output);
        }
    }

    function imageData(data) {
        document.getElementById('pan').setAttribute('value', data);
        document.getElementById('image').setAttribute('value', 'data:image/png;base64,' + data);
        document.getElementById('displayImage').setAttribute('src', 'data:image/png;base64,' + data);
        if (typeof AndroidDevice !== "undefined") {
        }
    }
    function imageData1(data) {
        document.getElementById('pan1').setAttribute('value', data);
        document.getElementById('image1').setAttribute('value', 'data:image/png;base64,' + data);
        document.getElementById('displayImage1').setAttribute('src', 'data:image/png;base64,' + data);
        if (typeof AndroidDevice !== "undefined") {
        }
    }

</script>
<div class="panel panel-default">
    <div class="col-lg-12">
        <?= Html::beginForm(['/site/pan'], 'post', ['enctype' => 'multipart/form-data']) ?>
        <div class="col-lg-12">
            <button type="button" class="btn btn-info" onClick="takePicture('imageData')"/>>
            <i class="fal fa-camera"></i> पैन कार्ड
            </button>
            <input type="button" class="fal fa-camera-retro" value="Camera1" onClick="takePicture('imageData')"/>
            <input type="hidden" value="" name="pan" id="pan">
            <input type="hidden"  name="image" id="image">
        </div>
        <p><img id="displayImage" name="displayImage" width="200" height="300"/></p>
        <div class="col-lg-12">
            <input type="button" class="fal fa-camera-retro" value="Camera2" onClick="takePicture('imageData1')"/>
            <input type="hidden" value="" name="pan1" id="pan1">
            <input type="hidden"  name="image1" id="image1">
        </div>
        <p><img id="displayImage1" src="" name="displayImage1" width="200" height="300"/></p>
        <?= Html::submitButton('अपलोड करें', ['class' => 'submit']) ?>
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

<style>
    img[src=""] {
        display: none;
    }   
</style>
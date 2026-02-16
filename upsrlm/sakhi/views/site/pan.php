<?php

use yii\bootstrap4\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    function takePicture() {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture();
        }
    }

    function imageData(data) {
//        document.getElementById('displayImage').setAttribute('src', data);
//        document.getElementById('pan').setAttribute('value', data);
//        if (typeof AndroidDevice !== "undefined") {
//            alert(data);
//        }
        
        document.getElementById('pan').setAttribute('value', data);
        document.getElementById('image').setAttribute('value', 'data:image/png;base64,'+data);
        document.getElementById('displayImage').setAttribute( 'src', 'data:image/png;base64,'+data );
            if(typeof AndroidDevice !== "undefined"){
        }
    }

</script>
<div class="panel panel-default">
    <div class="col-lg-12">
        <?= Html::beginForm(['/site/pan'], 'post', ['enctype' => 'multipart/form-data']) ?>
        <div class="col-lg-12">
            <button type="button" class="btn btn-info">
      <span class="glyphicon glyphicon-search"></span> Search
    </button>
            <input type="button" class="fal fa-camera-retro" value="Camera" onClick="takePicture()"/>
            <input type="hidden" value="" name="pan" id="pan">
            <input type="hidden"  name="image" id="image">
        </div>
        <p><img id="displayImage" name="displayImage" width="200" height="300"/></p>
            <?= Html::submitButton('अपलोड करें', ['class' => 'submit']) ?>
            <?= Html::endForm() ?>
    </div>
</div>
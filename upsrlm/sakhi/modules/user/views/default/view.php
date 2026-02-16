<?php

use yii\helpers\Html;

$app = new \sakhi\components\App();
$this->title = 'प्रोफ़ाइल';
?>
<div class="card">
    <?= (isset($model->cboprofile) and $model->cboprofile->profile_photo != null) ? '<span class="profile-picture">
                                        <img width="300px"  src="' . $model->cboprofile->profile_photo_url . '" data-src="' . $model->cboprofile->profile_photo_url . '"  class="img-thumbnail lozad" title="प्रोफाइल फोटो"/>
                                        </span> ' : '' ?>
    <img src="img.jpg" alt="John" style="width:100%">
    <h1><?= $model->name ?></h1>
    <p class="title"><?= $model->username ?></p>
    <p><?= $model->otp_value ?></p>

</div>
<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\master\MasterRole;
use common\models\WebApplication;

$arr = explode('/', $this->theme->basePath);
$themename = end($arr);
?>
<?php if (!Yii::$app->user->isGuest) { ?> 
    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC])) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Agree for training </th> 
                    <th> Registered (Batch Assigned) </th> 
                    <th>Before Certified Block BC</th> 
                    <th> Certified Block BC</th> 
                </tr>
            </thead>  
            <tbody>
                <tr>
                    <td><?= common\helpers\Utility::numberIndiaStyle($dataProvidera->query->count()) ?></td>
                    <td><?= common\helpers\Utility::numberIndiaStyle($dataProviderinb->query->count()) ?></td>
                    <td><?= common\helpers\Utility::numberIndiaStyle($dataProviderab->query->count()) ?></td>
                    <td><?= common\helpers\Utility::numberIndiaStyle($dataProvidercb->query->count()) ?></td>
                </tr>

            </tbody>
        </table>

    <?php } ?>
<?php } ?>
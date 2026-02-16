<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});;
/* To initialize BS3 popovers set this below */
$(function () { 
    $("[data-toggle='popover']").popover(); 
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
?>
<?php echo $this->render('common'); ?>	

<div class="row">
    <div class="col-xs-6">
        <h3><b>Monitor</b> and share project data with donors,<br> and <b>raise funds</b> for your organization</h3>
        <ul>
            <li>Track location / Geo-tag your project data</li>
            <li>Capture visual evidence with photos</li>
            <li>Share real-time stories with audio/video</li>
            <li>Generate detailed, real-time reports</li>
        </ul>
    </div>
    <div class="col-xs-6 quick-steps">
        <h3 class="orange">Quick Steps</h3>
        <ul>
            <li>Join fieldata.org for free 
                <?php
                echo Html::tag('span', '(why free?)', [
                    'data-title' => 'Why Free?',
                    'data-content' => 'We believe in sharing & transparency (who doesn’t) ☺ Therefore, to encourage public sharing of data, we want to make Fieldata.inss free for all organizations and institutions that are willing to publicly share their data',
                    'data-toggle' => 'popover',
                    'style' => 'sscursor:pointer;'
                ]);
                ?>

            </li>
            <li>Create a project profile </li>
            <li>Design reporting and data-collection questionnaires</li>
            <li>Download the FD-Collect Mobile-App, and the questionnaires from m.fieldata.org  </li>
            <li>Enter, save and send data from mobile phones</li>
            <li>Analyze the received data and view automated reports</li>
            <li>Download project data and media </li>
        </ul>
        <p><a href="#">Download the manual</a> for detailed instructions.</p>
    </div>
</div>
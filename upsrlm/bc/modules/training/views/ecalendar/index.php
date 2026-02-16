<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

$this->title = "E-calendar";
$this->params['breadcrumbs'][] = $this->title;
$training = [];
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
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class='under-design city-table responsive-table'>
                                <?=
                                yii2fullcalendar\yii2fullcalendar::widget([
                                    'id' => 'calendar',
                                    'defaultView' => 'month',
                                    'header' => [
                                        'center' => 'title',
                                        'left' => '',
                                        'right' => ''
                                    ],
                                    'clientOptions' => [
                                        'eventLimit' => TRUE,
                                        'theme' => true,
                                        'fixedWeekCount' => false,
                                    ],
                                    'events' => $ecalendar,
                                    'eventRender' => new \yii\web\JsExpression('function (event, element) {console.log(event.title);element.find(".fc-title").html(event.title);}')
                                ]);
                                ?> 
                            </div>  
                        </div>
                        <div class="col-lg-4">

                            <div class="panel-group">
                                <div class="card">
                                    <div class="card-header">
                                        1. Total Training
                                    </div>
                                    <div class="card-body">
                                        <?= $reports[0]['no_of_batch'] ?>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        2. Total Participant
                                    </div>
                                    <div class="card-body">
                                        <?= $reports[0]['no_of_participant'] ?>
                                    </div>

                                </div>     

                                <div class="card">
                                    <div class="card-header">
                                        2. GP Covered
                                    </div>
                                    <div class="card-body">
                                        <?= $reports[0]['no_of_gp_covered'] ?>
                                    </div>

                                </div>     
                            </div>

                        </div> 
                    </div>
                </div>
            </div> 
        </div> 
    </div>  
</div>     
<?php
$css = <<<css
        .fc-week {
    height: 100px !important;
}
css;
$this->registerCss($css);
?>
<?php
$js = <<<js
       
        $(document).ready(function(){
            $('#calendar').fullCalendar('gotoDate', $("#reportsearch-year_month_start_date").val());
       }) 
js;

$this->registerJs($js);
?>
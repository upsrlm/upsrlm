<?php

use common\assets\HighChartsAssets;

HighChartsAssets::register($this);

?>

<div id="panel-1" class="panel">
    <div class="panel-hdr">
        <h2>
            Daily Calling Progress
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <div id="progresschart"></div>
        </div>
    </div>
</div>

<?php
print_r($model->dailyprogress);
$script = <<< JS

    $(function(){
        const progresschart = Highcharts.chart('progresschart', {
            chart: {
                type:chart_type,
                zoomType: 'xy'
            },
            title: {
                text: 'Daily Calling Progress'
            },

            subtitle: {
                text:''
            },

            yAxis: {
                title: {
                    text: 'Number of Completed Calls'
                }
            },

            xAxis: {
                categories:date_category,
                accessibility: {
                    rangeDescription: 'Range: 2010 to 2017'
                }
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                }
            },

            series: interview_series,

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            },
            credits:false

        });
    

    });
JS;
$this->registerJs($script);
?>
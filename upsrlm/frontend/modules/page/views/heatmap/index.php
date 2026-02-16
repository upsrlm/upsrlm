<?php

use yii\helpers\Html;
use common\helpers\Utility;
use yii\bootstrap4\Accordion;

common\assets\LeafLeftAssets::register($this);
$this->title = 'Monthly BC Active';

$parentgeojsondata = $searchModel->parentgeojson;
$parentgeojsonRender = $parentgeojsondata['render'];
$parentgeojsonContent = $parentgeojsondata['content'];
$chart_height = '600px';
if ($searchModel->district_code) {
    $chart_height = '600px';
    if ($searchModel->block_code) {
        $block_list = \common\models\master\MasterBlock::find()->where(['block_code' => array_keys($searchModel->block_option)])->andFilterWhere(['block_code' => $searchModel->block_code])->cache(7000)->asarray()->all();
        foreach ($block_list as $block) {
            $block_json_name = 'block_' . $block['id'] . '_geojson';
            $block_file_path = Yii::$app->params['datapath'] . "/dashboard-geojson/blocks/block_" . $block['id'] . ".json";
            if (file_exists($block_file_path)) {
                echo "<script>
                var $block_json_name =" . $this->renderFile($block_file_path) . "; 
            </script>";
            } else {
                echo '<script>
                var ' . $block_json_name . ' ={
                    "type": "FeatureCollection",
                    "features": []
                }; 
            </script>';
            }
        }
        echo '<script>
            var block_list = ' . json_encode($block_list) . ';
            </script>';
    } else {
        $block_list = \common\models\master\MasterBlock::find()->where(['block_code' => array_keys($searchModel->block_option)])->andFilterWhere(['block_code' => $searchModel->block_code])->cache(7000)->asarray()->all();
        foreach ($block_list as $block) {
            $block_json_name = 'block_' . $block['id'] . '_geojson';
            $block_file_path = Yii::$app->params['datapath'] . "/dashboard-geojson/blocks/block_" . $block['id'] . ".json";
            if (file_exists($block_file_path)) {
                echo "<script>
                var $block_json_name =" . $this->renderFile($block_file_path) . "; 
            </script>";
            } else {
                echo '<script>
                var ' . $block_json_name . ' ={
                    "type": "FeatureCollection",
                    "features": []
                }; 
            </script>';
            }
        }
        echo '<script>
            var block_list = ' . json_encode($block_list) . ';
            </script>';
    }

    echo '<script>
        var parent_geojson = ' . $this->$parentgeojsonRender($parentgeojsonContent) . ';
    </script>';
}
?>
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?= $this->title ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 justify-content-center">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <!--                <div class="card-border p-3">
                                     
                <?php //echo $this->render('_search', ['model' => $searchModel, 'total_count' => $total_count]) ?>
                                </div>   -->
                <div class="card ">          
                    <div class="card-bodys " id="monthData">
                        <?php
                        foreach ($heatmap_chart_group_list as $index => $heatmap_chart_group_data) {
                            $heatmap_chart_list = $heatmap_chart_group_data['charts'];
                            ?>
                            <div class="row mb-1 bg-white" id="group_card_<?= $index ?>">
                                <div class="col-md-2 justify-content-center" >
                                    &nbsp;
                                </div>
                                <div class="col-md-8 justify-content-center" >
                                    <div class="card-border p-0">
                                        <div class="row">

                                            <?php
                                            foreach ($heatmap_chart_list as $heatmap_chart_data) {
                                                $json_data_tag = 'json_data_' . $heatmap_chart_data['tag'];

                                                $heatmap_arraydata = $searchModel->heatmapData([$heatmap_chart_data['column_query']]);
                                                $total_samples = array_sum(array_column($heatmap_arraydata, 'total_sample'));
                                                $achived_samples = array_sum(array_column($heatmap_arraydata, 'achived_sample'));
                                                $overall_percentage = $total_samples > 0 ? ($achived_samples / $total_samples) * 100 : 0;
                                                $json_data = [];
                                                foreach ($heatmap_arraydata as $heatmap_data) {
                                                    $json_data[$heatmap_data['code']] = $heatmap_data;
                                                }
                                                $per_0_to_20 = count(array_filter($heatmap_arraydata, function ($data) {
                                                            $percentage = 0;
                                                            if ($data['total_sample'] > 0) {
                                                                $percentage = ($data['achived_sample'] * 100) / $data['total_sample'];
                                                            }
                                                            return $percentage >= 0 && $percentage <= 20;
                                                        }));
                                                $per_21_to_40 = count(array_filter($heatmap_arraydata, function ($data) {
                                                            $percentage = 0;
                                                            if ($data['total_sample'] > 0) {
                                                                $percentage = ($data['achived_sample'] * 100) / $data['total_sample'];
                                                            }
                                                            return $percentage > 20 && $percentage <= 40;
                                                        }));
                                                $per_41_to_80 = count(array_filter($heatmap_arraydata, function ($data) {
                                                            $percentage = 0;
                                                            if ($data['total_sample'] > 0) {
                                                                $percentage = ($data['achived_sample'] * 100) / $data['total_sample'];
                                                            }
                                                            return $percentage > 40 && $percentage <= 80;
                                                        }));
                                                $per_81_to_100 = count(array_filter($heatmap_arraydata, function ($data) {
                                                            $percentage = 0;
                                                            if ($data['total_sample'] > 0) {
                                                                $percentage = ($data['achived_sample'] * 100) / $data['total_sample'];
                                                            }
                                                            return $percentage > 80 && $percentage <= 100;
                                                        }));
                                                ?>

                                                <div class="col-md-12 mb-1">
                                                    <div class="card-border p-0">
                                                        <script>
                                                            var <?= $json_data_tag ?> = <?php echo json_encode($json_data); ?>;
                                                        </script>
                                                        <h3 class="text-center"><?= $heatmap_chart_data['title'] . ' ' ?><?= isset($searchModel->month_model) ? date("F Y", strtotime($searchModel->month_model->month_start_date)) : "" ?></h3>

                                                        <div class="d-flex flex-wrap justify-content-between mb-1">
                                                            <div class="bg-danger-300 text-center float-left" style="background-color: #ea9abf">
                                                                <h3 class="h3  fw-800">
                                                                    Total : <?= Utility::numberIndiaStyle($achived_samples) ?>
                                                                </h3>
                                                            </div>
                                                            <div class="d-flex flex-wrap justify-content-center mb-1">
                                                                <span class="badge ml-2 rounded-pill px-4 py-2 fs-6 text-white me-2 mb-2"
                                                                      style="background: linear-gradient(to right, <?= $searchModel->shadeof100colors()[0] ?>, <?= $searchModel->shadeof100colors()[20] ?>);">
                                                                    <b>0–20%</b>: <?= $per_0_to_20 ?>
                                                                </span>

                                                                <span class="badge ml-2 rounded-pill px-4 py-2 fs-6 text-white me-2 mb-2"
                                                                      style="background: linear-gradient(to right, <?= $searchModel->shadeof100colors()[21] ?>, <?= $searchModel->shadeof100colors()[40] ?>);">
                                                                    <b>21–40%</b>: <?= $per_21_to_40 ?>
                                                                </span>

                                                                <span class="badge ml-2 rounded-pill px-4 py-2 fs-6 text-dark me-2 mb-2"
                                                                      style="background: linear-gradient(to right, <?= $searchModel->shadeof100colors()[41] ?>, <?= $searchModel->shadeof100colors()[80] ?>);">
                                                                    <b>41–80%</b>: <?= $per_41_to_80 ?>
                                                                </span>

                                                                <span class="badge ml-2 rounded-pill px-4 py-2 fs-6 text-dark mb-2"
                                                                      style="background: linear-gradient(to right, <?= $searchModel->shadeof100colors()[81] ?>, <?= $searchModel->shadeof100colors()[100] ?>);">
                                                                    <b>81–100%</b>: <?= $per_81_to_100 ?>
                                                                </span>
                                                            </div>     
                                                            <div class="bg-danger-300 text-center" style="background-color: #ea9abf">
                                                                <h3 class="h3  fw-800">
                                                                    Percentage : <?= round($overall_percentage, 0) ?>%
                                                                </h3>
                                                            </div>
                                                        </div>

                                                        <!--                                                        <div class="d-flex justify-content-between mb-1">
                                                                                                                    
                                                                                                                   
                                                                                                                </div>-->

                                                        <div id="map_current_data_<?= $heatmap_chart_data['tag'] ?>" style="height:<?= $chart_height ?>;"></div>
                                                        <div class="legend-container mt-2">
                                                            <div class="legend-bar"></div>
                                                        </div>
                                                        <div class="legend-labels">
                                                            <span>0</span>
                                                            <span>100</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 justify-content-center" >
                                    &nbsp;
                                </div>
                            </div>
                        <?php } ?>


                    </div>
                    <div class="row">
                    <div class="col-md-2 justify-content-center" >
                        &nbsp;
                    </div>
                    <div class="col-lg-8 text-center mb-0">
                        <input type="range" class="form-control-range" id="monthYearSlider" min="5" max="<?= $searchModel->month_deafault_value ?>" value="<?= $searchModel->month_deafault_value ?>">

                        <span id="monthYearLabel"><?= isset($searchModel->month_model) ? date("F Y", strtotime($searchModel->month_model->month_start_date)) : "" ?></span>
                    </div>
                    </div>     
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var block_code = "<?= $searchModel->block_code ?>";
    var gram_panchayat_code = "<?= $searchModel->gram_panchayat_code ?>";
    var shadeofcolors = <?php echo json_encode($searchModel->shadeof100colors()); ?>;
    var up_geojson = <?= $this->$geojsonRender($geojsonContent) ?>;
</script>
<script>
    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    const startYear = <?= $searchModel->startYear ?>;

    document.getElementById('monthYearSlider').addEventListener('input', function () {
        const offset = parseInt(this.value); // 0–119 for 10 years
        const year = startYear + Math.floor(offset / 12);
        const month = (offset % 12) + 1; // 1–12
        const label = monthNames[month - 1] + ' ' + year;
        document.getElementById('monthYearLabel').innerText = label;
//        $.ajax({
//            url: `/page/heatmap/data?month=${month}&year=${year}`,
//            type: "POST",
//            data: {month: month, year: year},
//            cache: false,
//            success: function (result) {
//                $("#monthData").html(result);
//            }
//        });
    });
    document.getElementById('monthYearSlider').addEventListener('change', function () {
        const offset = parseInt(this.value); // 0–119 for 10 years
        const year = startYear + Math.floor(offset / 12);
        const month = (offset % 12) + 1; // 1–12
        const label = monthNames[month - 1] + ' ' + year;
        document.getElementById('monthYearLabel').innerText = label;
        $.ajax({
            url: `/page/heatmap/data?month=${month}&year=${year}`,
            type: "POST",
            data: {month: month, year: year},
            cache: false,
            success: function (result) {
                $("#monthData").html(result);
            }
        });
    });
</script>
<?php
$script = <<< JS
        var mapOptions = {
            fullscreenControl: true,
            center: [27.207609, 80.826660], //up
            maxZoom: 8.0,
            minZoom: 6.0,
            zoom: 6.8,
            zoomSnap: 0,
            zoomDelta: 0.25,
            //zoomControl: false,
            //touchZoom: false,
            //doubleClickZoom: false,
            scrollWheelZoom: false,
            boxZoom: true,
            keyboard: false,
            //dragging: false,
            attributionControl: false,
            
        }
        var map_active = 0;
JS;
$this->registerJs($script);
?>
<?php
foreach ($heatmap_chart_group_list as $heatmap_chart_group_data) {
    $heatmap_chart_list = $heatmap_chart_group_data['charts'];
    foreach ($heatmap_chart_list as $heatmap_chart_data) {
        $map_current_data = 'map_current_data_' . $heatmap_chart_data['tag'];
        $json_data_tag = 'json_data_' . $heatmap_chart_data['tag'];
        $heatmap_title = $heatmap_chart_data['title'] . ' : ' . $heatmap_chart_group_data['title'];
        ?>

        <?php
        if ($searchModel->district_code) {
            $district = $searchModel->district;
            if ($searchModel->block_code) {
                $block = $searchModel->block;
                if ($searchModel->gram_panchayat_code) {
                    echo $this->render('_gp_js', [
                        'map_current_data' => $map_current_data,
                        'json_data_tag' => $json_data_tag,
                        'heatmap_title' => $heatmap_title,
                        'block' => $block,
                        'searchModel' => $searchModel,
                        'geojsonRender' => $geojsonRender,
                        'geojsonContent' => $geojsonContent,
                    ]);
                } else {
                    echo $this->render('_block_js', [
                        'map_current_data' => $map_current_data,
                        'json_data_tag' => $json_data_tag,
                        'heatmap_title' => $heatmap_title,
                        'block' => $block,
                        'searchModel' => $searchModel,
                        'geojsonRender' => $geojsonRender,
                        'geojsonContent' => $geojsonContent,
                    ]);
                }
            } else {
                echo $this->render('_district_js', [
                    'map_current_data' => $map_current_data,
                    'json_data_tag' => $json_data_tag,
                    'heatmap_title' => $heatmap_title,
                    'district' => $district,
                    'searchModel' => $searchModel,
                    'geojsonRender' => $geojsonRender,
                    'geojsonContent' => $geojsonContent,
                ]);
            }
        } else {
            echo $this->render('_state_js', [
                'map_current_data' => $map_current_data,
                'json_data_tag' => $json_data_tag,
                'heatmap_title' => $heatmap_title,
                'searchModel' => $searchModel,
                'geojsonRender' => $geojsonRender,
                'geojsonContent' => $geojsonContent,
            ]);
        }
        ?>

        <style>
            .legend-bar {
                flex-grow: 1;
                height: 20px;
                background: linear-gradient(to right, <?= implode(',', $searchModel->shadeof100colors()) ?>);
            }
        </style>

        <?php
    }
}
?>



<?php
$script = <<< JS
    $(document).ready(function () {
    function isFullScreen() {
      return document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement;
    }

    function enterFullScreen(element) {
      if (element.requestFullscreen) {
        element.requestFullscreen();
      } else if (element.webkitRequestFullscreen) {
        element.webkitRequestFullscreen();
      } else if (element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
      } else if (element.msRequestFullscreen) {
        element.msRequestFullscreen();
      }
    }

    function exitFullScreen() {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }

    $('.toggleFullScreen').on('click', function () {
        if (!isFullScreen()) {
            enterFullScreen($('#'+$(this).attr('data-containerid')).get(0));
            $(this).removeClass('fa-expand').addClass('fa-compress');
        } else {
            exitFullScreen();
            $(this).removeClass('fa-compress').addClass('fa-expand');
        }
    });    
  });
JS;
$this->registerJs($script);
?>

<style>
    .square-option-label {
        height: 12px;
        width: 12px;
        margin-right: 3px;
        margin-top: 2px;
    }

    .p-legend label {
        margin-right: 20px;
        margin-bottom: 0;
        font-size: 14px;
    }

    .legend-container {
        display: flex;
        align-items: center;
        width: 100%;
        font-family: Arial, sans-serif;
    }


    .legend-labels {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-top: 5px;
        font-size: 14px;
    }

    .card-border {
        border: 1px solid #1a233a;
        border-radius: 10px;
        padding: 5px;
    }
</style>
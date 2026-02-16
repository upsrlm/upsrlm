<?php
$lat =  $district->lat ? $district->lat : 27.207609;
$lng =  $district->lng ? $district->lng : 80.826660;

?>
<?php
$script = <<< JS
        var mapOptions = {
            center: [$lat, $lng], //up
            maxZoom: 13.0,
            minZoom: 7.0,
            zoom: 9,
            zoomSnap: 0,
            zoomDelta: 0.25,
            //zoomControl: false,
            //touchZoom: false,
            //doubleClickZoom: false,
            scrollWheelZoom: false,
            boxZoom: false,
            keyboard: false,
            //dragging: false,
            attributionControl: false,
            fullscreenControl: true,
        }
        var map_active = 0;

        var $map_current_data = new L.map('{$map_current_data}', mapOptions);
        $map_current_data.on('mouseover', function () {
            map_active = 1;
        });
        $map_current_data.on('mouseout', function () {
            map_active = 0;
        });
        $map_current_data.on('moveend', function () {
            if (map_active == 1) {
            }
        });
        $map_current_data.on('zoomend', function () {
            if (map_active == 1) {
            } else if (map_active == 2) {
            } else if (map_active == 3) {
            }
        });
JS;
$this->registerJs($script);
?>


<?php
$script = <<< JS
    $(document).ready(function () {

        var boundary_parent = new L.geoJson(parent_geojson,{ style: styleFunctionInactive }).addTo($map_current_data);

        var boundary1 = new L.geoJson(up_geojson, { style: assignColor }).addTo($map_current_data);
           
    
        $.each(block_list, function(code, block_data) {
            let block_json_name = 'block_' + block_data.id + '_geojson';
            let geojsonData = window[block_json_name]; 
            var boundary_block = new L.geoJson(geojsonData, { style: assignColor, onEachFeature: onEachFeatureCurrent })
                .bindTooltip(bindTooltip).addTo($map_current_data);
        });

        function onEachFeatureCurrent(feature, layer) {
            layer.on('mouseover', function () {
                this.setStyle({
                    'weight': 3,
                });
            });
            layer.on('mouseout', function () {
                this.setStyle({
                    'weight': 0.5,
                });

            }); 

            layer.on('click', function () {
                $('#analyticsheatmap-block_code').val(feature.properties.block_code).trigger("change");
                $('form').submit();
            });
        }
        function bindTooltip(layer) {
            json_data = $json_data_tag;
            t_json_data = json_data[layer.feature.properties.block_code];
            if (t_json_data == undefined) {
                var returnstr = "<b>" + String(t_json_data.name) + "<b/><br/> (%)&nbsp;&nbsp;&nbsp;<br/>";
            } else {
                if(Number(t_json_data.total_sample)>0){
                    achived_per = ((Number(t_json_data.achived_sample)*100)/(Number(t_json_data.total_sample)))
                }else{
                    achived_per=0;
                }
                var t_vs = "<table class='table table-bordered table-hover table-condensed table-sm w-100 dataTable dtr-inline'>"+
                   "<thead><tr><th colspan='2' style='background-color: #F0F0F0; color:#000000; text-align: center; font-weight:bold'>{$heatmap_title}</th></tr></thead>"+
                    "<tbody>"+
                        "<tr><th style='font-weight:bold;'>Total</th><td style='text-align: right; font-size:13px'>"+t_json_data.achived_sample+"</td></tr>"+
                        "<tr><th style='font-weight:bold;'>%</th><td style='text-align: right; font-size:13px'>"+Math.round(achived_per,1)+"</td></tr>"+ 
                    "</tbody></table>";
                var returnstr = "<b>District - " + t_json_data['district_name'] + "<b/><br> <b>Block -" + t_json_data['name'] + "<b/><br/>&nbsp;&nbsp;&nbsp;<br/>" + t_vs;
            }
            return returnstr;
        }

        function assignColor(feature) {
            json_data = $json_data_tag;
            t_json_data = json_data[feature.properties.block_code];
            if (t_json_data != undefined) {
                if(Number(t_json_data.total_sample)>0){
                    achived_per = ((Number(t_json_data.achived_sample)*100)/(Number(t_json_data.total_sample)))
                }else{
                    achived_per=0;
                }
                color_code = shadeofcolors[Math.round(achived_per)];
                return {
                    fillColor: color_code,
                    weight: .5,
                    color: 'white', 
                    fillOpacity: 1,
                };
            }
            return styleFunctionInactive();
        }

        function styleFunctionInactive() {
            return {
                fillColor: '#F0F0F0',
                weight: .5,
                opacity: 1,
                color: 'black', //Outline color
                fillOpacity: 1
            };
        }
    });     
JS;
$this->registerJs($script);
?>
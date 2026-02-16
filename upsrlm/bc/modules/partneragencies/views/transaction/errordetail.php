<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\assets\HandsonTableAsset;
use common\models\master\MasterRole;

HandsonTableAsset::register($this);
$excel_column = ['row_number','usr_id', 'txn_id', 'product_type', "txn_value", 'datetime', 'bc_commison', 'Error'];
$this->title = "BC's Transactions file errors";
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
<?= $this->title ?>
                </h2>
                <div class="panel-toolbar">
                    <?php if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT])) { ?>
                        <?= Html::a('Back', ['import'], ['class' => 'btn btn-success']) ?>
<?php } ?>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>

                </div>
            </div>
            <div class="panel-container show">

                <div id="example1" class="hot handsontable" style="margin-bottom: 80%"></div>
            </div>

        </div> 
    </div>

</div>    
<script>
    document.addEventListener("DOMContentLoaded", function () {
        reasonvalidator = function (value, callback) {
            var objhandsontable = $('#example1').handsontable('getInstance');
            var rownumber = objhandsontable.getSelected()[0];


        };
        var dataobj = <?php echo $data; ?>;
        var header =<?php echo json_encode($excel_column); ?>;
        function getData() {
            return dataobj
        }
        var tpl = [''],
                $container = $('#example1'),
                $container;

        $container.handsontable({
            data: getData(),
            columns: [
                 {data: 'row_number',
                    allowInvalid: true, readOnly: true},
                {data: 'usr_id',
                    allowInvalid: true, readOnly: true},
                {data: 'txn_id',
                    allowInvalid: true, readOnly: true},
                {data: 'product_type',
                    allowInvalid: true, readOnly: true},
                {data: 'txn_value',
                    allowInvalid: true, readOnly: true},
                {data: 'datetime',
                    allowInvalid: true, readOnly: true},
                {data: 'bc_commison',
                    allowInvalid: true, readOnly: true},
                {data: 'Error ',
                    allowInvalid: true, readOnly: true}
            ],
            colWidths: [180, 250, 250, 180, 280, 180, 180, 250],
//            renderAllRows: true,
            colHeaders: header,
////                       colHeaders:
////                                ['usr_id', 'txn_id', 'product_type', "txn_value", 'datetime', 'bc_commison', 'Error'],
//            rowHeaders: true,
            rowHeights: 30,
//            minSpareRows: 0,
//            minSpareCols: 0,
//            manualRowMove: true,
//            columnSorting: true,
//            sortIndicator: true,
//            customBorders: true,
//            headerTooltips: true,
//            manualColumnResize: true,
//            manualRowResize: true,
//            debug: true,
            manualRowResize: true,
            dropdownMenu: true,
//            filters: true,
        });
        function senddatatoserver(status) {
            var objhandsontable = $('#example1').handsontable('getInstance');
            var rownumber = objhandsontable.getSelected()[0];
        }


        function coverRenderer(instance, td, row, col, prop, value, cellProperties) {
            var escaped = Handsontable.helper.stringify(value),
                    img;
            img = document.createElement('input');
            img.type = "Button";
            var element = document.createElement("input");
            element.type = "button";
            element.value = "Save";
            element.name = "Save";
            element.className = "btn-info";
            element.onclick = function () {
                validaterow(instance, row);
            };
            Handsontable.Dom.addEvent(element, 'mousedown', function (e) {
                e.preventDefault();
            });

            Handsontable.Dom.empty(td);
            td.appendChild(element);

            return td;
        }
        function bindDumpButton() {
            if (typeof Handsontable === "undefined") {
                return;
            }
            Handsontable.Dom.addEvent(document.body, 'click', function (e) {
                var element = e.target || e.srcElement;
                if (element.nodeName == "BUTTON" && element.name == 'dump') {
                    var name = element.getAttribute('data-dump');
                    var instance = element.getAttribute('data-instance');
                    var hot = window[instance];
                    console.log('data of ' + name, hot.getData());
                }
            });
        }
        bindDumpButton();
    });
</script>



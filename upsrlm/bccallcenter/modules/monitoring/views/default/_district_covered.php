<div id="panel-1" class="panel">
    <div class="panel-hdr">
        <h2>District Coverage</h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <?php
            if ($model->districtcoverage) {
                foreach ($model->districtcoverage as $district => $districtcoverage) {
                    $percentage = $model->calculatepercantage(($districtcoverage['pending'] + $districtcoverage['complete']), $districtcoverage['complete']);
            ?>
                    <?= $district ?> (<?= $districtcoverage['pending'] ?>/<?= $districtcoverage['complete'] ?>)
                    <div class="progress progress-xl">
                        <div class="progress-bar progress-bar-striped bg-primary-500 progress-bar-animated" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
            <?php  }
            }
            ?>
        </div>
    </div>
</div>
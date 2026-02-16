<ul class="timelines">
    <?php
    $no = 1;
    foreach ($model as $key => $actives) {
        ?> 
        <li class="<?= $no % 2 ? '' : 'timeline-inverted' ?>">
            <div class="timeline-badge a<?= $key ?>">
                <span class="day"><?= $actives['time'] ?></span>
                
            </div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h5 class="timeline-title a<?= $key ?>"></h5>
                    
                </div>
                <div class="timeline-body">
                    <p><?= $actives['txt'] ?>
                    </p>
                </div>
            </div>
        </li>
        <?php
        $no++;
    }
    ?> 

</ul>
<div class="clearfix"></div>

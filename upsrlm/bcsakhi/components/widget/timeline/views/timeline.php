<?php

?>
<div class="timeline">
    <?php
    $no = 1;
    foreach ($model as $key => $actives) {
    ?>
        <div class="containers <?= $no % 2 ? 'left text-right' : 'right' ?>">
            <div class="date"><?= $actives['time'] ?></div>
            <i style="cursor : pointer" class="icon fal fab fa fa-folder-open-o" type="button" data-toggle="modal" data-target="#exampleModal<?= $key ?>"></i>
            <div class="content">
                <h2 style="cursor : pointer" type="button" data-toggle="modal" data-target="#exampleModal<?= $key ?>"><?= $actives['title'] ?> </h2>
                <h4 style="cursor : pointer; font-size:18px; color:#0001ff" type="button" data-toggle="modal" data-target="#exampleModal<?= $key ?>">Read More</h4>
                <div class="modal fade" id="exampleModal<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?= $actives['title'] ?> <br><span class="text-info"><?= $actives['time'] ?></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="collapse<?= $key ?>">
                                    <?= $actives['txt'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
        $no++;
    }
    ?>


</div>

<div class="subheader">
    <h1 class="subheader-title">
        <?= $fundtype->fund_type ?>
    </h1>
    <a href="/shg/default/fund?shgid=<?= $shg_model->id ?>&fund_type=<?= $fundtype->id ?>" class="btn btn-primary btn-sm float-right"><i class="fal fa-plus"></i></a>
</div>
<div class="subheader mb-2">
    कुल प्राप्त राशि : रु <?= $total_amount_received ?>
</div>
<div class="subheader mb-2">
    प्राप्त राशि की संख्या : <?= $number_of_ammount_received ?>
</div>

<?php
if ($models) {
    foreach ($models as $key => $model) {
        ?>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title"><?= $model->receivedfrom ?> <a href="/shg/default/fund?shgid=<?= $shg_model->id ?>&editfundid=<?= $model->id ?>&fund_type=<?= $fundtype->id ?>" class="btn btn-primary btn-sm float-right"><i class="fal fa-edit"></i></a></h5>
                <p class="card-text">Amount Received : रु <?= $model->amount_received ?></p>
                <p class="card-text"><small class="text-muted">Date of Receipt : <?= $model->date_of_receipt ?></small></p>
            </div>
        </div>
    <?php }
} ?>

<script>
//    window.addEventListener("pageshow", function (event) {
//        var historyTraversal = event.persisted ||
//                (typeof window.performance != "undefined" &&
//                        window.performance.navigation.type === 2);
//        if (historyTraversal) {
//            // Handle page restore.
//            window.location.reload();
//        }
//    });
</script>

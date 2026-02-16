<?php
$app = new \sakhi\components\App();

if ($_POST["STATUS"] == "TXN_SUCCESS") {
    $message = 'Transaction Success';
    $class = 'text-success';
} else {
    $message = "Transaction Failure";
    $class = "text-danger";
}

?>

<h1 class="text-center <?= $class ?>"><?= $message ?></h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="2">
                    Transaction Details
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Status </td>
                <td><?= $model->status_msg ?> </td>
            </tr>
            <tr>
                <td>Order ID </td>
                <td><?= $model->orderid ?> </td>
            </tr>
        </tbody>
    </table>
    <a href="/shg/application/form?shgid=<?= $model->shg_id ?>" class="btn btn-primary">Go Back to Home</a>

</div>
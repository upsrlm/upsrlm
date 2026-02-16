<?php
$app = new \sakhi\components\App();

?>

<div class="card">
    <div class="subheader" style="text-align: center">
        <h3 class="subheader-title">
            कृपया इस पेज को रीफ्रेश न करें
            (Please do not refresh this page)
        </h3>
    </div>
    <br />

    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="col-lg-12">
                        <h4>शुल्क का प्रकार : <?= $wada_model->paytype ?> </h4>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="col-md-12">
                        <h4>भुगतान किया जाने वाला शुल्क
                            : <?= $model->amount ?></h4>
                    </div>
                </div>

            </div>
            <div class="col-md-12 m-2">
                <form method='post' action='<?php echo $transactionURL; ?>' name='f1' id="paymentform">
                    <?php
                    foreach ($paytmParams as $name => $value) {
                        echo '<input type="hidden" name="' . $name . '" value="' . $value . '" readonly="true">';
                    }
                    ?>
                    <input type="hidden" name="CHECKSUMHASH" value="<?php echo $paytmChecksum ?>">
                    <br>
                    <div class="form-group text-center">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">शुल्क भुगतान जारी रखें
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
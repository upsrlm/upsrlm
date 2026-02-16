
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top table-condensed">
            <thead>
                <tr>
                    <th colspan="3">Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Agent Name</td>
                    <td><?= isset($model->user->name) ? $model->user->name : '' ?></td>
                </tr>
                <tr>
                    <td>Agent No</td>
                    <td><?= $model->upsrlm_user_mobile_no ?></td>
                </tr>
                <tr>
                    <td>From Calling No</td>
                    <td><?= $model->customernumber ?></td>
                </tr>
                <tr>
                    <td>Call Date</td>
                    <td><?= $model->api_request_datetime ?></td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
<hr>
<?php if ($model->recording_file) { ?>
    <figure>
        <figcaption>Listen Audio:</figcaption>
        <audio controls="" src='<?= $model->srvefile ?>' controlslist="nodownload" preload="none">
            Your browser does not support the
            <code>audio</code> element.
        </audio>
    </figure>
<?php } ?>
<style>
    audio::-webkit-media-controls-mute-button,
    audio::-webkit-media-controls-current-time-display,
    audio::-webkit-media-controls-time-remaining-display,
    audio::-webkit-media-controls-toggle-closed-captions-button
    {
        display:none !important;
    }
</style>
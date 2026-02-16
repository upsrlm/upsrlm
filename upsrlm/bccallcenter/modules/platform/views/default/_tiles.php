<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= isset($model->firstcall)?\Yii::$app->formatter->asDateTime(strtotime($model->firstcall), "php:H:i:s"):'' ?>
                    <small class="m-0 l-h-n">First Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= isset($model->lastcall)?\Yii::$app->formatter->asDateTime(strtotime($model->lastcall), "php:H:i:s"):'' ?>
                    <small class="m-0 l-h-n">Last Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->workhour ?>
                    <small class="m-0 l-h-n">Work Hours</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->todayctcclick ?>
                    <small class="m-0 l-h-n">CTC Click</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->todayagentreciviedcall ?>
                    <small class="m-0 l-h-n">Call Recivied</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->todaybothanswered ?>
                    <small class="m-0 l-h-n">Both Answered </small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->talkduration ?>
                    <small class="m-0 l-h-n">Talk Duration </small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->iverduration ?>
                    <small class="m-0 l-h-n">IVR Duration</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

</div>
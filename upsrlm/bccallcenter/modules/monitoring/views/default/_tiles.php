<div class="row">
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->completedcall() ?>
                    <small class="m-0 l-h-n">Overall Completed Calls</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->completedcall(true) ?>
                    <small class="m-0 l-h-n">Total Completed Call</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->callattempt(false, true) ?>
                    <small class="m-0 l-h-n">Overall Agent Call Recivied</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->callattempt(true, true) ?>
                    <small class="m-0 l-h-n">Agent Call Recivied </small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <!-- <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->ctcclick(false, true) ?>
                    <small class="m-0 l-h-n">Overall CTC Click</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div> -->
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4  d-block l-h-n m-0 fw-500">
                    <?= $model->ctcclick(true) ?>
                    <small class="m-0 l-h-n">Today CTC Click </small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>


    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->talkduration() ?>
                    <small class="m-0 l-h-n">Overall Call Duration</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->talkduration(true) ?>
                    <small class="m-0 l-h-n">Today Call Duration</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->calltime('first', true) ?>
                    <small class="m-0 l-h-n">First Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $model->calltime('last', true) ?>
                    <small class="m-0 l-h-n">Last Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
</div>
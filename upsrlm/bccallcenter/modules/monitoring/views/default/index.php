<?php

use yii\widgets\Pjax;

$this->title = 'Today Calling Progress';
?>

<div class="row">
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModelCtc->totalctcclick + $searchModelIbd->totalibdcall ?>
                    <small class="m-0 l-h-n">Total Calls</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModelCtc->totalctcclick ?>
                    <small class="m-0 l-h-n">Total CTC Click</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModelIbd->totalibdcall ?>
                    <small class="m-0 l-h-n">Total IBD Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= 0 ?>
                    <small class="m-0 l-h-n">Total Missed Call </small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3><a href="/monitoring/agent/progress">Outbound Agent Progress(CTC)</a></h3>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelCtc->totalagent ?>
                                    <small class="m-0 l-h-n">Total Agent</small>
                                </h3>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelCtc->totaldays ?>
                                    <small class="m-0 l-h-n">Total Days</small>
                                </h3>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelCtc->totalctcclick ?>
                                    <small class="m-0 l-h-n">Total CTC Click</small>
                                </h3>
                            </div>
                            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelCtc->totalagentcallrecived ?>
                                    <small class="m-0 l-h-n">Total Agent Call Recivied </small>
                                </h3>
                            </div>
                            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelCtc->totalivrduration ?>
                                    <small class="m-0 l-h-n">IVR Duration</small>
                                </h3>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelCtc->totalbothanswered ?>
                                    <small class="m-0 l-h-n">Both Answered</small>
                                </h3>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelCtc->totaltalkduration ?>
                                    <small class="m-0 l-h-n">Talk Duration</small>
                                </h3>
                            </div>
                            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelCtc->totalunanswered ?>
                                    <small class="m-0 l-h-n">Total Unanswered Call </small>
                                </h3>
                            </div>
                            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <!-- 
                    <div class="col-md-12">
                        <h3>Scneario Progress</h3>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3><a href="/monitoring/ibd">Inbound Agent Progress(IBD)</a></h3>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelIbd->totalagent ?>
                                    <small class="m-0 l-h-n">Total Agent</small>
                                </h3>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelIbd->totaldays ?>
                                    <small class="m-0 l-h-n">Total Days</small>
                                </h3>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelIbd->totalibdcall ?>
                                    <small class="m-0 l-h-n">Total IBD Call</small>
                                </h3>
                            </div>
                            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelIbd->totalothercall ?>
                                    <small class="m-0 l-h-n">Total Other Call </small>
                                </h3>
                            </div>
                            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelIbd->totalregistredcall ?>
                                    <small class="m-0 l-h-n">Total Registred Call</small>
                                </h3>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelIbd->totalbothanswered ?>
                                    <small class="m-0 l-h-n">Both Answered</small>
                                </h3>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelIbd->totaltalkduration ?>
                                    <small class="m-0 l-h-n">Talk Duration</small>
                                </h3>
                            </div>
                            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
                        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <?= $searchModelIbd->totalagentcallrecived ?>
                                    <small class="m-0 l-h-n">Total Scneario Button Click </small>
                                </h3>
                            </div>
                            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <h3>Agent Wise Call Recived</h3>
                    </div> -->
                </div>
            </div>
        </div>

    </div>


</div>
<section class="app_home_slider">
    <div class="container   ">
        <div class="row ">
            <div class="col-md-12" >
                <div class="owl-carousel owl-theme">
                    <!---first slide--->
                    <?php if ($clfid) { ?>
                        <div class="item">
                            <a href="/clf/default/view?clfid=<?= $clfid ?>"  >
                                <div class="app_slide">
                                    <img src="<?= $theme_base_url ?>/images/app/clf.png">
                                    <br/>CLF
                                </div>
                            </a>
                        </div>

                        <div class="item">
                            <a href="/clf/default/fundsrecived?clfid=<?= $clfid ?>">
                                <div class="app_slide">
                                    <img src="<?= $theme_base_url ?>/images/app/fund-recieve.png">
                                    <br/>धन प्राप्त
                                </div>
                            </a>
                        </div>


                        <div class="item">
                            <a href="/clf/default/addvo?clfid=<?= $clfid ?>">
                                <div class="app_slide">
                                    <img src="<?= $theme_base_url ?>/images/app/add.png">
                                    <br/>सम्बद्ध VO
                                </div>
                            </a>
                        </div>
                        <div class="item">
                            <a href="/clf/default/memberlist?clfid=<?= $clfid ?>">
                                <div class="app_slide">
                                    <img src="<?= $theme_base_url ?>/images/app/mem-list.png">
                                    <br/>CLF सदस्य
                                </div>
                            </a>
                        </div>
                        <!---first slide--->

                        <!---second slide--->
                        <div class="item">
                            <a href="/clf/default/fundsvo?clfid=<?= $clfid ?>" class="active">
                                <div class="app_slide">
                                    <img src="<?= $theme_base_url ?>/images/app/vo-funds.png">
                                      <br/>VO ऋण
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                    <!--            <div class="item">
                                    <a href="#">
                                        <div class="app_slide">
                                            <img src="assets/images/app/media.svg">
                                            <p>Media</p>
                                        </div>
                                    </a>
                                </div>
                    
                    
                                <div class="item">
                                    <a href="#">
                                        <div class="app_slide">
                                            <img src="assets/images/app/updates.svg">
                                            <p>Covid Updates</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="#">
                                        <div class="app_slide">
                                            <img src="assets/images/app/e-pass.svg">
                                            <p>E-pass</p>
                                        </div>
                                    </a>
                                </div>-->

                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->title = "About End Poverty";
?> 
<div>
    <div class="" style="padding-top: 40px;">
        <div class="box">
            <div class="box-content"> 
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card-box hm-intro-blk d-flex justify-content-around">
                            <p>
                                
                            </p>
                            <div class="devider-line"></div>
                            <p>
                                
                            </p>
                        </div>
                    </div>

                    <div class="col-xl-4">




                        <div class="card-box">


                            <h4 class="header-title m-t-0 m-b-30"><i class="mdi mdi-notification-clear-all m-r-5"></i>comming soon...... </h4>


                        </div>


                    </div><!-- end col -->
                </div>
                <!--        <div class="row">
                            <div class="col-xl-12">
                                <div class="slider">
                                    <div class="card-box p-4 hm-blk-rt">
                                        <div class=" single-item-cd-a">
                
                                            <div style="background-color: #726e60!important">
                                                <h2>comming soon...... </h2>
                                                <div class="d-flex justify-content-around">
                                                   
                                                </div>
                                            </div>
                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
            </div>    
        </div>
    </div>
</div>
<?php
$JS = <<<JS
        $(document).ready(function () {
                $('.single-item-cd-a').slick();
                $(".single-item-cd-glr").slick();
            });
        
        $('.carousel').carousel({
  interval: 2000
})
JS;
$this->registerJS($JS);
?>
<?php
$style = <<< CSS
.control-label{
 display:none;       
}
CSS;
$this->registerCss($style);
?>

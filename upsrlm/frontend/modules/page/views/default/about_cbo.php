<?php
$this->title = "About End Poverty";
?> 
<div>
    <div class="" style="padding-top: 40px;">
        <div class="box">
            <div class="box-content"> 
                <div class="row">
                    <div class="col-xl-1"> </div>
                    <div class="col-xl-10">
                        <h2>CBO Portal</h2>
                        <div class="card-box hm-intro-blk justify-content-around">
                            So far, approximately 4 lakh community based organizations (CBO) have been formed. Termed as the institutions of the poor, these CBOs may be viewed as (a) self-help groups (SHG) as collection of 10-20 families, and (b) federating groups represented by the SHGs at village and cluster levels. Formed at the level of gram panchayats, federation of 7 to 12 SHGs are called village organization (VO). At the next level, 5 to 15 VOs federated for a cluster of 10-20 Gram Panchayats are called cluster level federation (CLF). Both the federating entities, VO and CLF, are represented by the members of the SHGs. A NABARD projection indicates considering socio-economic demographies in rural Uttar Pradesh, UPSRLM has the potential to form more than one million SHGs. 
                            <br/><br/>
                            Dynamic data-points on the portal reports details of CBOs on the ground and those being formed on regular basis. There are two faces of the portal. The first that facilitates reporting of CBO level movements, activities and transactions. These reports are acquired from the primary sources; that is the 3 CBOs as indicated above. They are termed as demand-side reporting. Data acquisition takes place through mobile app designed for use by the CBOs and their individual members. 
                            <br/><br/>
                            The second face of the portal aims to enable a host of performing areas. These include, planning implementation of the field operations, tracking progress and monitoring process-workflow. Most importantly, the second face of the portal aids routine appraisal over the points of performance and quality thereof. 
                        </div>
                    </div>

                    <div class="col-xl-1"> </div>
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

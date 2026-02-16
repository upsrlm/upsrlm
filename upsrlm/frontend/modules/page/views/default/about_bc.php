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
                        <h2>BC Sakhi Portal</h2>
                        <div class="card-box hm-intro-blk justify-content-around">
                            Department of Rural Development (DoUD), Government of Uttar Pradesh (GoUP) has launched a scheme for appointing one Business Correspondent Sakhi (BC) in each of the State’s 58,000 Gram Panchayats (GP). Approx. 2.167 lakh BC applications received, UPSRLM has shortlisted 56,825 BC candidates for training. The trainings would be conducted by RSETI (Rural Self-employment Training Institute). The RSETI trainings aims to prepare BCs for mandatary examination and certification by Indian Institute for Banking & Finance (IIBF).
                            <br/><br/>
                            To anchor BC operations, UPSRLM has partnered with six RBI-authorised banks and financial institutions. The 75 districts of Uttar Pradesh has been divided in six operational areas. These partner banks and financial institutions are responsible for onboarding of BC operations in cluster of districts that they have identified for their operation. No two partner entity would operate in one common district. 
                            <br/><br/>
                            The BC portal of http://upsrlm.org is perceived to deliver few distinct mandates. First, identify, shortlist and finalise selection of BC candidates, support a centralised training agency conduct training and certification. For this mandate, the portal also envisages police verification of the BC candidates. The second key mandate is to facilitate selected BCs receive UPSRLM provisions and enable. The provisions include financial assistance for procuring handheld device for BC and overdraft amount for a settlement account, monthly honorarium for 6 months and 2 sets of uniforms.
                            <br/><br/>
                            The third and most important mandate of the portal is to enable access to transactional data received from the BC handheld device. 
                            <br/><br/>
                            The portal; for the program managers and apex decision making officials, aims to enable a range of web-services on reporting & tracking dashboard and analytics and info-graphs etc.
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

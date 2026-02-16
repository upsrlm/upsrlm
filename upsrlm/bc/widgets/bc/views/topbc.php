<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?>
<div class="services">
  <div class="container-fluid px-3 px-lg-5">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="section-heading">
          <h2>Top Performer <em>BC Sakhi</em></h2>
        </div>
      </div>
      <?php foreach ($top_20_bc as $bc) { ?>
        <div class="col-lg-3 col-xl-2 col-md-4 col-sm-6 col-6 mb-3 mx-lg-2">
          <div class="service-item  newsizeimg h-100">
          <a href="/report/topbc/bcview?bcid=<?= $bc->bc->id ?>" class="text-info">  <?= $bc->bc->profile_photo != null ? '<span class="profile-picture">
                                        <img width="100%"  src="' . Yii::$app->params['baseurl_bc_image'] . $bc->bc->profile_photo_url . '" data-src="' . Yii::$app->params['baseurl_bc_image'] . $bc->bc->profile_photo_url . '"  class="lozad" title="' . $bc->bc->name . '" style="cursor : pointer"/>
                                            </span> ' : '-' ?></a>
            <div class="down-content">
              <h4><a href="/report/topbc/bcview?bcid=<?= $bc->bc->id ?>" class="text-info"><?= isset($bc->bc->name) ? $bc->bc->name : '' ?></a></h4>
              <!-- <p>Commission Earned : <strong> <?= '<i class="fa fa-inr"></i> ' . common\helpers\Utility::numberIndiaStyle($bc->commission_amount) ?></strong></p>
              <span><?= isset($bc->bc) ? $bc->bc->district_name . ' / ' . $bc->bc->block_name . ' / ' . $bc->bc->gram_panchayat_name : '' ?></span> -->
            </div>

          </div>
        </div>
      <?php } ?>

    </div>
  </div>
</div>
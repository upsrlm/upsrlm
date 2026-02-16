<div class="card">
    <div class="col-md-12">
        <p><span class="formlabel">मांग आवेदन फोटो</span></p>
        <p>
            <?php
            $html = '<span id="' . $model->id . '">';
            $html .= $model->demand_aaplication_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px"  src="' . $model->demand_aaplication_photo_url . '" data-src="' . $model->demand_aaplication_photo_url . '"  class="lozad" title="Job Card" style="cursor : pointer"/>
                                        </span> ' : '';

            $html .= '</span>';
            echo $html;
            ?>  
        </p>
        <p><span class="formlabel">मांग आवेदन अपलोड तिथि : </span><?= date('Y-m-d G:i:s', $model->created_at) ?></p>

        <?php
        if ($model->master_roll_complete) {
            $html = '<p>';
            $html .= '<div><span class="formlabel">मास्टर रोल फोटो</span></div>';
            $html .= $model->master_roll_photo != null ? '<span class="profile-picture">
                                            <img width="220px" height="220px"  src="' . $model->master_roll_photo_url . '" data-src="' . $model->master_roll_photo_url . '"  class="lozad" title="Job Card" style="cursor : pointer"/>
                                            </span> ' : '';

            $html .= '<br><br>
                          <span class="formlabel">मास्टर रोल आईडी :</span> ' . $model->master_roll_id . '<br>
                          <span class="formlabel">मास्टर रोल अपलोड तिथि :</span> ' . $model->master_roll_photo_uploaddate . '                            
                                            ';
            $html .= '</p>';
            echo $html;
        }
        ?>
        <?php
        if ($model->work_detail_complete) {
            $html = '<p>';
            $html .= '                                            
<span class="formlabel">1). कार्य की तिथि:</span> ' . $model->work_detail_date . '<br>
<span class="formlabel">2) कुल कार्य दिवस :</span> ' . $model->workdaylabel . '<br>
<span class="formlabel">3) कार्य विवरण आईडी :</span> ' . $model->work_detail_id . '<br><br>
<span class="formlabel">कार्य विवरण अपलोड करने की तिथि :</span> ' . $model->work_detail_uploaddate . '
                                            ';

            $html .= '</p>';
            echo $html;
        }
        ?>
        <?php
        if ($model->fto_complete) {
            $html = '<p>';
            $html .= '                                            
<span class="formlabel">1). एफटीओ तिथि:</span> ' . $model->fto_date . '<br>
<span class="formlabel">2) एफटीओ आईडी :</span> ' . $model->fto_id . '<br>
<span class="formlabel">एफटीओ अपलोड करने की तिथि :</span> ' . $model->fto_uploaddate . '
                                            ';

            $html .= '</p>';
            echo $html;
        }
        ?>
    </div>
</div>    
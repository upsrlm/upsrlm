<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>
<?php if ($model->shg_confirm_funds_return_photo != null) { ?>
    <table class="table table-responsive">
        <tr>


            <th width="50%">कार्यवाही पुस्तिका की फोटो</th>
            <th width="50%"></th>
        </tr> 
        <tr>
            <td width="50%">
                <?= $model->shg_confirm_funds_return_photo != null ? '<span class="profile-picture">
                                        <img src="' . Yii::$app->params['app_url']['bc'] . $model->shg_confirm_funds_return_photo_url . '" data-src="' . Yii::$app->params['app_url']['bc'] . $model->shg_confirm_funds_return_photo_url . '"  class="img-responsive lozad" title="कार्यवाही पुस्तिका की फोटो" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
            </td> 

        </tr>
    </table>
<?php } ?>
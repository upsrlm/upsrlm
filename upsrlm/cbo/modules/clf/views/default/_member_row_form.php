<?php

use yii\helpers\Html;
echo '<tr class="items" width="100%">';
echo '<td>';
echo '</td>';
echo '<td>';
echo "<div class='form-group field-cboclfmembersform-$i-name'>";
echo "<div>";
echo Html::activeTextInput($item, "[$i]name", ['class'=>'form-control']);
echo "</div>";
echo '<div><div class="help-block"></div></div>';
echo "</div>";
echo '</td>';
echo '<td>';
echo "<div class='form-group field-cboclfmembersform-$i-mobile_no'>";
echo "<div>";
echo Html::activeTextInput($item, "[$i]mobile_no",['class'=>'form-control']);
echo "</div>";
echo '<div><div class="help-block"></div></div>';
echo "</div>";
echo '</td>';
echo '<td>';
echo "<div class='form-group field-cboclfmembersform-$i-role'>";
echo "<div>";
echo Html::activeDropDownList($item, "[$i]role", $item->member_role_option,['prompt'=>'Select Row']);
echo "</div>";
echo '<div><div class="help-block"></div></div>';
echo "</div>";
echo '</td>';
echo '<td>';
echo "<div class='form-group field-cboclfmembersform-$i-bank_operator''>";
echo "<div>";
echo Html::activeDropDownList($item, "[$i]bank_operator", [0=>'No','1'=>'Yes']);
echo "</div>";
echo '<div><div class="help-block"></div></div>';
echo "</div>";
echo '</td>';
echo "<td width='5%'></td>";

echo "</tr>";


exit;
?>
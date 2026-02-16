<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
?>

<div class="shg-form">
    <?php $form = ActiveForm::begin(['id' => 'form-vo', 'enableAjaxValidation' => false, 'enableClientValidation' => false]); ?>  
    <div class="row">
        <div class="panel-tag"> <strong>Guideline</strong> : सभी ब्लॉक मिशन मैनेजर (BMM) के लिए दिशा निर्देश :
            भी BMM के लिए यह स्पष्ट समझ रखना ज़रूरी है की ग्राम संगठन/ स्तरीय संकुलों से सम्बंधित सूचनाएं सम्बंधित फॉर्म में अंकित करने के लिए उन्हें किसी संदर्भित सूचनाओं का सहारा नहीं लेना है I बल्कि वे धरातल पर हर ग्राम संगठन में उन के पदाधिकारिओं के साथ बैठकर उनके लेखा खाता बही एवं अन्य रिकॉर्ड बुक के सापेक्ष इन सूचनाओं को दर्ज करेंगे I ग्राम संगठन एवं संकुल से सम्बंधित सूचनाएं सिर्फ प्राथमिक स्तर की हैं एवं इनके विस्तारित सूचना आहरण के कार्यवाही प्रस्तावित है I
            <ol type="1">
                <li>ग्राम संगठन एवं क्लस्टर स्तरीय संकुल से सम्बंधित दी जा रही सूचना को BMM के द्वारा स्व-सत्यापित माना जायेगा एवं किसी भी गलत तथ्य की जिम्मेदारी सम्बंधित BMM की होगी I </li>
                <li>सभी BMM से सुझाव यह है कि, सूचनाएं दर्ज करने से पहले इनका परिक्षण कर लें I आप सूचनाओं को दर्ज करने के बाद, उन्हें सेव (save) करें एवं आवश्यक पड़ने पर उन्हें एडिट (edit)/ उनमे बदलाव कर सकते हैं I मगर एकबार सूचनाओं को सबमिट (Submit) करने के पश्चात् उन्हें बदल नहीं पाएंगे I</li>  
                <li>सभी BMM के पास कस्टमर केयर एवं ग्राम्य विकास विभाग के कैंप कार्यालय में संदीप माझी जी (9415012006) का मोबाइल एवं व्हाट्सप्प नंबर उपलब्ध है I किसी भी अनिश्चय, असुविधा या अधिक जानकारी के लिए आप उन्हें संपर्क कर सकते हैं I  UPSRLM के राज्य स्तर कार्यालय से कार्य की प्रगति की जानकारी जिला एवं राज्यस्तरीय सभी प्रमुख अधिकारीओं को प्रतिदिन साझा की जाएगी I</li>
            </ol>
        </div>

        <div class="col-lg-6">
            <div class="row">

                <div class="col-lg-10">



                    <?php
                    echo $form->field($model, 'gram_panchayat_code', ['enableClientValidation' => true])->widget(kartik\select2\Select2::classname(), [
                        'data' => $model->gp_option,
                        'size' => Select2::MEDIUM,
                        'options' => ['placeholder' => 'Select GP', 'multiple' => FALSE],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label("Gram Panchayat<br/>ग्राम पंचायत का नाम");
                    ?>
                </div>  

            </div>
            <div class="row">
                <div class="col-lg-6">

                    <?= $form->field($model, 'name_of_vo', ['enableClientValidation' => true])->textInput(['maxlength' => true])->label("Name Of VO<br/>ग्राम संगठन का नाम") ?>
                </div> 
                <div class="col-lg-6">

                    <?= $form->field($model, 'nrlm_vo_code', ['enableClientValidation' => true])->textInput(['maxlength' => 30])->label("NRLM VO Code<br/>NRLM ग्राम संगठन का कोड") ?>
                </div>

            </div>
            <div class="row">

                <div class="col-lg-6">
                    <?php
                    echo $form->field($model, 'date_of_formation', ['enableClientValidation' => true])->widget(DatePicker::classname(), [
                        'value' => $model->date_of_formation,
                        'options' => ['placeholder' => 'Date Of Formation', 'class' => 'calculateday', 'readonly' => 'readonly'],
                        //'removeButton' => FALSE,
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'readonly' => 'readonly',
                            'format' => 'dd-mm-yyyy',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                        ],
                        'pluginEvents' => [
                            "changeDate" => "function(e) { "
                            . "}",
                        ]
                    ])->label("Date Of Formation<br/>ग्राम संगठन के गठन का तिथि");
                    ?>

                </div>

                <div class="col-lg-6">

                    <?= $form->field($model, 'no_of_shg_connected', ['enableClientValidation' => true])->textInput()->label("No of SHG connected<br/>सम्बद्ध स्वयं सहायता समूहों की संख्या") ?>

                </div>
            </div>

            <label>Bank details/ बैंक का विवरण</label>
            <div class="row">

                <div class="col-lg-6">
                    <?= $form->field($model, 'bank_account_no_of_the_vo', ['enableClientValidation' => true])->label("Bank account no. of the VO/ ग्राम संगठन के बैंक अकाउंट नंबर")->textInput() ?>
                </div>

                <div class="col-lg-6">

                    <?= $form->field($model, 'bank_id', ['enableClientValidation' => true])->label("Name Of Bank/ बैंक का नाम")->dropDownList($model->bank_option, ['prompt' => "Select Bank"]) ?>

                </div>
            </div>
            <div class="row">

                <div class="col-lg-6">
                    <?= $form->field($model, 'branch', ['enableClientValidation' => true])->label("Branch/ बैंक शाखा का नाम")->textInput() ?>
                </div>

                <div class="col-lg-6">

                    <?= $form->field($model, 'branch_code_or_ifsc', ['enableClientValidation' => true])->label("Branch Code Or IFSC/ ब्रांच कोड/ या IFSC कोड")->textInput() ?>

                </div>
            </div>
            <div class="row">

                <div class="col-lg-7">
                    <?php
                    echo $form->field($model, 'date_of_opening_the_bank_account', ['enableClientValidation' => true])->widget(DatePicker::classname(), [
                        'value' => $model->date_of_opening_the_bank_account,
                        'options' => ['placeholder' => 'Date of opening the bank account', 'class' => 'calculateday', 'readonly' => 'readonly'],
//                        'removeButton' => FALSE,
                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        'pluginOptions' => [
                            'readonly' => 'readonly',
                            'format' => 'dd-mm-yyyy',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                        ],
                        'pluginEvents' => [
                            "changeDate" => "function(e) { "
                            . "}",
                        ]
                    ])->label("Date Of Opening The Bank Account/ बैंक अकाउंट खोलने की तिथि");
                    ?>

                </div>


            </div>
            <?php
            echo $form->field($model, 'shgs_id')->widget(DepDrop::classname(), [
                'data' => $model->shgs_option,
                'options' => ['placeholder' => 'Select SHG', 'multiple' => TRUE],
                'pluginOptions' => [
                    'placeholder' => 'Select SHG',
                    'depends' => ['cbovoform-gram_panchayat_code'],
                    'url' => Url::to(['/ajax/getshg']),
                ],
            ])->label('Select SHG<br/>सभी संबद्ध समूहों को चुने');
            ?> 
            <label>Status of access to funds/ 
                ग्राम सगठन के द्वारा प्राप्त धनराशिओं का विवरण</label>

            <table class="table table-striped table-bordered table-responsive">
                <tr>
                    <th width="20%">Fund type<br>फंड्स के प्रकार</th>
                    <th>Get funds<br>धन प्राप्त हुआ</th>
                    <th>Date of receipt of last tranche<br>अद्यतन/ लेटेस्ट राशि प्राप्ति की तारीख</th>
                    <th width="14%">instalment, if any<br>कोई इंस्टॉलमेंट हो तो संकेत करें</th>
                    <th width="14%">Total Amount received<br>कुल प्राप्त धनराशि</th>
                    <th width="14%">Balance as on date<br>बैंक अकाउंट में दर्ज अद्यतन धनराशि</th></tr>
                 
                <?php
                if (isset($model->funds_model)) {
                    $fno = 1;
                    foreach ($model->funds_model as $i => $funds) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $form->field($funds, "[$i]fund_type")->hiddenInput(['value' => $funds->fund_type])->label('') ?>    
                                <?= $fno ?>. <?= $funds->type_name ?>
                            </td>
                            <td><?php echo $form->field($funds, "[$i]get_funds")->dropDownList([0 => 'No', '1' => 'Yes'])->label('') ?></td>
                            <td><?php
                                echo $form->field($funds, "[$i]date_of_receipt")->widget(DatePicker::classname(), [
                                    'value' => $funds->date_of_receipt,
                                    'options' => ['placeholder' => 'date of receipt', 'class' => 'calculateday', 'readonly' => 'readonly'],
                                    'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                                    'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                                    'pluginOptions' => [
                                        'readonly' => 'readonly',
                                        'format' => 'dd-mm-yyyy',
                                        'todayHighlight' => true,
                                        'autoclose' => true,
                                        'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                                    ],
                                    'pluginEvents' => [
                                        "changeDate" => "function(e) { "
                                        . "}",
                                    ]
                                ])->label('');
                                ?></td>
                            <td><?php echo $form->field($funds, "[$i]instalment_if_any")->textInput()->label('') ?></td>
                            <td><?php echo $form->field($funds, "[$i]total_amount_received")->textInput()->label('') ?></td>
                            <td><?php echo $form->field($funds, "[$i]balance_as_on_date")->textInput()->label('') ?></td>
                        </tr>
                        <?php
                        $fno++;
                    }
                }
                ?>
            </table>
            <br/>
        </div>
        <div class="col-lg-6">
            <label>Members/ ग्राम संगठन के सदस्यों के नाम</label>
            <table class="table table-striped table-bordered table-responsive" id="member">
                <tr>
                    <th>S No.</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th>Role</th>
                    <th>Bank Operator</th>
                    <td width="10%">Add row<i class='btn btn-sm addrow fal fa-plus-square'></i></td>
                </tr>
                <tr>
                    <th>क्रम.</th>
                    <th>सदस्य का नाम</th>
                    <th>मोबाइल नंबर</th>
                    <th>VO में भूमिका</th>
                    <th>क्या बैंक अकाउंट संचालक हैं?</th>
                    <td width="10%">नए सदस्य के लिए row जोड़ें<i class='btn btn-sm addrow fal fa-plus-square'></i></td>
                </tr>
                <?php
                if (isset($model->members_model)) {
                    foreach ($model->members_model as $i => $member) {
                        ?>
                        <tr class="items">
                            <th><?= $i + 1 ?><?php echo $form->field($member, "[$i]id")->hiddenInput(['value' => $member->id])->label('') ?>    </th>
                            <td><?php echo $form->field($member, "[$i]name")->textInput()->label('') ?></td>
                            <td><?php echo $form->field($member, "[$i]mobile_no")->textInput()->label('') ?></td>
                            <td><?php echo $form->field($member, "[$i]role")->dropDownList($model->member_role_option, ['prompt' => 'Select Role'])->label('') ?></td>
                            <td><?php echo $form->field($member, "[$i]bank_operator")->dropDownList([0 => 'No', '1' => 'Yes'])->label('') ?></td>
                            <td></td>
                        </tr>
                        <?php
                    }
                }
                ?>

            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group text-center">
                <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b', 'value' => 'save_b']) ?>
                <?= Html::submitButton('सबमिट (Submit)', ['class' => 'btn btn-small btn-info', 'name' => 'submit_b', 'id' => 'submit_b', 'value' => 'submit_b']) ?>   


            </div>
        </div>  
    </div>     
    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS
  $('#submit_b').click(function () {
                            var r = confirm('Are you sure you want to सबमिट (Submit)?एकबार सूचनाओं को सबमिट (Submit) करने के पश्चात् उन्हें बदल नहीं पाएंगे');
                            if (r == true) {
                                return true;
                            } else {
                                return false;
                            }
                        });
JS;
$this->registerJs($js);
?>
<?php
$js = <<<JS
    $(document).ready(function() {
        $(document).delegate(".deleterow","click",function(){
        if ($("#itemtable tr").length != 2) {
                $(this).parent().parent().remove();
            }
            else {
                alert('You can not delete first entry row');
            }
    });
        $(document).delegate(".addrow","click",function(){
        var cur_obj = this;
            $.ajax({
                url: '/vo/default/itemrow',
                success: function(data) {
                    $('#member tr:last').after(data);

                }
            });
    });
    
    });         
JS;
$this->registerJs($js);
?>
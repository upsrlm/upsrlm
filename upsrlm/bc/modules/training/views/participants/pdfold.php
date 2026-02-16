<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<br/>
<br/>
<h3 style="border-bottom:1px solid #880000;background-color: #D6DDE3">&nbsp;&nbsp;भाग 1: BC सखी प्रार्थी की विवरण </h3>
<table class="bpmTopnTail" style="border: none">
    <tbody>
        <tr class="oddrow" style="border: none">
            <td style="width: 80%;vertical-align:top">
                <div style="vertical-align: top;">
                    <p> <b>1. RSETI प्रशिक्षित एवं IIBF सर्टिफाइड BC सखी का नाम:</b> <?= $model->name ?><br/></p>
                    <p> <b>2. जिला:</b> <?= $model->district_name ?><br/></p>
                    <p><b>3. विकास खंड:</b> <?= $model->block_name ?><br/></p>
                    <p><b>4. ग्राम पंचायत:</b> <?= $model->gram_panchayat_name ?><br/></p>
                    <p><b>5. पता:</b> <?= $model->hamlet, ', ' . $model->village_name, ', ' . $model->gram_panchayat_name, ', ' . $model->block_name, ', ' . $model->district_name, '' ?></p>
                    <p> <b>6. मोबाइल नंबर:</b><?= $model->user->mobile_no ?> / <?= $model->mobile_number ?><br/></p>
                    <p> <b>7. आधार कार्ड का फोटो:</b> (ग्राम पंचायत के स्थानीय निवासी होने, पहचान पत्र एवं  जन्मतिथि के प्रमाण के तौर पर)</p>
                    <p><b>8. अभिभावक का नाम:</b> <?= $model->guardian_name ?></p>
                    <p> <b>9. मोबाइल नंबर:</b><?= $model->user->mobile_no ?> / <?= $model->mobile_number ?><br/></p>

                    <p>&nbsp;</p>
                    <p><b> स्व-घोषणा:</b> मैं यह स्व-प्रमाणित करती हूँ कि मेरे द्वारा दिए गए उपरोक्त सभी सूचनाएं सही है I</p>
                    <p>&nbsp;</p>
                    <p><b>हस्ताक्षर: </b></p>
                </div>
            </td>
            <td style="width:20%;vertical-align:top">

                <?= $model->user->profile_photo != null ? '<span class="profile-picture">
                                        <img width="100px" height="100px" src="' . $model->profile_photo_url . '" data-src="' . $model->profile_photo_url . '"  class="lozad" title="प्रार्थी का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<div style="width:150px;height:150px">प्रार्थी का फोटो</div>' ?> <br/>
                <?= $model->user->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="100px" height="150px" src="' . $model->aadhar_front_photo_url . '" data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="आधार कार्ड का सामने का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<div style="width:150px;height:100px">आधार कार्ड का सामने का फोटो</div>' ?> 
                <?= $model->user->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="100px" height="150px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="आधार कार्ड का पीछे का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<div style="width:150px;height:100px">आधार कार्ड का पीछे का फोटो</div>' ?>
            </td>
<!--        <tr>
            <td> <b> स्व-घोषणा:</b> मैं यह स्व-प्रमाणित करती हूँ कि मेरे द्वारा दिए गए उपरोक्त सभी सूचनाएं सही है I</td>
            <td>हस्ताक्षर: </td>
        </tr>-->
        </tr>
<!--        <tr class="oddrow" style="border: none">
            <td style="width: 80%;vertical-align:top">
                <div style="vertical-align: top;">
                   
                    <b> स्व-घोषणा:</b> मैं यह स्व-प्रमाणित करती हूँ कि मेरे द्वारा दिए गए उपरोक्त सभी सूचनाएं सही है I
                    <br/><br/>हस्ताक्षर:  
                </div>

            </td>
            <td style="width:20%;vertical-align:top">
        <?= $model->user->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="150px" height="150px" src="' . $model->aadhar_front_photo_url . '" data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="आधार कार्ड का सामने का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<div style="width:150px;height:150px">आधार कार्ड का सामने का फोटो</div>' ?> 
        <?= $model->user->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="150px" height="150px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="आधार कार्ड का पीछे का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<div style="width:150px;height:150px">आधार कार्ड का पीछे का फोटो</div>' ?>

            </td>
        </tr>-->

<!--        <tr class="oddrow" style="border: none">
            <td style="width: 80%" colspan="2">
                <b> स्व-घोषणा:</b> मैं यह स्व-प्रमाणित करती हूँ कि मेरे द्वारा दिए गए उपरोक्त सभी सूचनाएं सही है I

            </td>
        </tr>
        <tr class="oddrow" style="border: none">
            <td style="width: 80%"></td>
            <td style="width:20%">
                <br/>हस्ताक्षर:  
            </td>
        </tr>-->
    </tbody>
</table>
<p><b>Note:</b> पुलिस कर्मी के द्वारा स्वघोषणा पर प्रार्थी का हस्ताक्षर प्राप्त किया जायेगा I</p>

<h3 style="border-bottom:1px solid #880000;background-color: #D6DDE3;padding-top: 0px;margin-top: 0px">&nbsp;&nbsp;भाग 2: पुलिस विभाग के तैनात कर्मचारी के हस्ताक्षरित किये जाने के बाद सत्यापन पूर्ण होगा</h3>

<table class="bpmTopnTail">
    <tbody>
        <tr class="oddrow">
            <td style="width: 100%">
                “अधोहस्ताक्षरी ने आवेदित प्रार्थी का दिनांक ____________ को सत्यापन संपन्न किया गया I प्रार्थी के विरुद्ध कोई भी कानूनी मामला लंबित नहीं पाया गया I”<br/>
                <br/> थानाध्यक्ष का नाम : ______________________________________	हस्ताक्षर: ___________<br/><br/>
                थाना: _______________________________________________	मोबाइल नंबर: ___________<br/><br/>
                जी0 डी0 संख्या: ______________________________________ थाने की मुहर: ___________
            </td>  
        </tr>
    </tbody>
</table>
<br/>
<hr style="border-bottom: 1px dotted #ff0000;padding: 0px;margin: 0px"/>
<h3 style="border-bottom:1px solid #880000;background-color: #D6DDE3;">&nbsp;&nbsp;भाग 3: पावती/ प्राप्ति स्वीकृति (प्रार्थी BC सखी को यह पावती अपने पास रखना होगा)</h3>

<table class="bpmTopnTail">
    <tbody>
        <tr class="oddrow">
            <td style="width: 100%">
                <p>  श्रीमती/ सुश्री <u><?= $model->name ?></u>, अभिभावक <u><?= $model->guardian_name ?></u>, निवासी: <u><?= $model->hamlet, ', ' . $model->village_name, ', ' . $model->gram_panchayat_name, '' ?></u>,&nbsp;&nbsp;मोबाइल नंबर: <u><?= $model->user->mobile_no ?> / <?= $model->mobile_number ?></u>  का पुलिस द्वारा सत्यापन संपन्न किया गया  I <br/></p>
                <p><br/> दिनांक: __________________ 	प्राप्तकर्ता का नाम हस्ताक्षर : ________________________<br/><br/></p>
                <p>जी0 डी0 संख्या: ______________________________________ थाने की मुहर: ___________</p></td>

        </tr>
    </tbody>
</table>



<style>
    .bpmTopnTail ,table, tr, td {
        border: none;
        line-height: 1.4;
    } 
</style>

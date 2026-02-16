<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--<br/>
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
                                        <img width="100px" height="100px" src="' . $model->profile_photo_path . '"   title="प्रार्थी का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<div style="width:150px;height:150px">प्रार्थी का फोटो</div>' ?> <br/>
<?= $model->user->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="100px" height="150px" src="' . $model->aadhar_front_photo_path . '"   title="आधार कार्ड का सामने का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<div style="width:150px;height:100px">आधार कार्ड का सामने का फोटो</div>' ?> 
<?= $model->user->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="100px" height="150px" src="' . $model->aadhar_back_photo_path . '"   title="आधार कार्ड का पीछे का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<div style="width:150px;height:100px">आधार कार्ड का पीछे का फोटो</div>' ?>
            </td>
        </tr>
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
</table>-->
<h3 style="border-bottom:1px solid #880000;background-color: #D6DDE3">&nbsp;&nbsp;भाग 1: सी बी आर न0  </h3>
<table class="bpmTopnTail" style="border: none;width:100%">
    <tbody>
        <tr class="oddrow" style="border: none">
            <td style="width: 80%;vertical-align:top">
                <div style="vertical-align: top;">
                    <p> <b>1. आवेदक BC सखी का नाम:</b> <?= $model->name ?><br/></p>
                    <p> <b>2. पिता/ पति का नाम: श्री </b> <?= $model->guardian_name ?><br/></p>
                    <p><b>3. आयु (आवेदक):</b> <?= $model->age ?><br/></p>
                    <p><b>4. शैक्षिक योग्यता :</b> <?= $model->readingskills != null ? $model->readingskills->name_eng : '' ?><br/></p>

                </div>
            </td>
            <td style="width:20%;vertical-align:top">

                <?= $model->user->profile_photo != null ? '<span class="profile-picture">
                                        <img width="120px" height="120px" src="' . $model->profile_photo_path_for_pdf . '" data-src="' . $model->profile_photo_path_for_pdf . '"  class="lozad" title="प्रार्थी का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<div style="width:150px;height:150px">प्रार्थी का फोटो</div>' ?> <br/>

            </td>
        </tr>  
    </tbody>
</table>
<table class="bpmTopnTail" style="border: none">
    <tbody>
        <tr class="oddrow" style="border: none">
            <td style="width: 60%;vertical-align:top">
                <div style="vertical-align: top;">
                    <p><b>5. (अ) स्थायी पता, मोबाइल न0 सहित:</b> <?= $model->hamlet, ', ' . $model->village_name, ', ' . $model->gram_panchayat_name, ', ' . $model->block_name, ', ' . $model->district_name, '' ?> <?= $model->user->mobile_no ?> / <?= $model->mobile_number ?></p>
                    <p><b>5. (ब) अस्थायी पता, मोबाइल न0 सहित:</b><?= $model->hamlet, ', ' . $model->village_name, ', ' . $model->gram_panchayat_name, ', ' . $model->block_name, ', ' . $model->district_name, '' ?> <?= $model->user->mobile_no ?> / <?= $model->mobile_number ?></p>
                    <p><b>6. अपराधिक मामलों की विवरण:</b>      _ _ _ _ _ _ _ _  _ _ _ _ _ _ _ _ _ _ _ _
                        _ _ _ _ _ _ _ _  _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _  _ _ _ _ _ _ _ _ </p>
                </div>
            </td>
            <td style="width:20%;vertical-align:top">
                <?= $model->user->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="120px" height="150px" src="' . $model->aadhar_front_photo_path_for_pdf . '" data-src="' . $model->aadhar_front_photo_path_for_pdf . '"  class="lozad" title="आधार कार्ड का सामने का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<span style="width:150px;height:100px">आधार कार्ड का सामने का फोटो</span>' ?> 
            </td>
            <td style="width:20%;vertical-align:top">
                <?= $model->user->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="120px" height="150px" src="' . $model->aadhar_back_photo_path_for_pdf . '" data-src="' . $model->aadhar_back_photo_path_for_pdf . '"  class="lozad" title="आधार कार्ड का पीछे का फोटो" style="cursor : pointer"/>
                                        </span> ' : '<span style="width:150px;height:100px">आधार कार्ड का पीछे का फोटो</span>' ?>
            </td>
        </tr>  
    </tbody>
</table>
<hr style="border-bottom: 1px dotted #ff0000;padding: 0px;margin: 0px"/>
<table class="bpmTopnTail">
    <tbody>
        <tr class="oddrow">
            <td style="width: 100%">
                <p> उपरोक्त सी बी आर की जाँच मुझ अधोहस्ताक्षरी द्वारा अमल में लायी गयी तो मौक़े पर जाँच किया तो पड़ोसियों श्री/ श्रीमती/ कु0   <u><?= $model->name ?></u> पुत्र/ पुत्री  <u><?= $model->guardian_name ?></u>  निवासी: <u><?= $model->hamlet, ', ' . $model->village_name, ', ' . $model->gram_panchayat_name, '' ?></u> द्वारा ज्ञात हुआ कि आवेदक श्री/ श्रीमती/ कु0   <?= $model->name ?> की आम सोहरत मोहल्ला निवासियों में अच्छी है तथा आवेदक/ अवेदिका उपरोक्त पते का ही स्थायी निवासी हैं I आवेदक का 5(अ) अथवा 5(ब) ही स्थायी पता है I आवेदक माफिया गतिविधियों एवं संगठित अपराधों में लिप्त होना नहीं पाया गया I आवेदक का चरित्र एवं आचरण उत्तम है I चरित्र आख्या किए जाने की संस्तुति की जाती है/ नहीं की जाती है I </p>
            </td>
        </tr>
    </tbody>
</table>
<hr style="border-bottom: 1px dotted #ff0000;padding: 0px;margin: 0px"/>
<br/>
<table class="bpmTopnTail">
    <tbody>
        <tr >
            <td style="width: 100%;text-align: center;font-size:18px" colspan="2">
                <h1> आख्या सादर सेवा में प्रेषित हैI </h1>
            </td>    
        </tr>
        <tr class="oddrow">
            <td style="width: 50%">
                _________________________________________________________________________________________________________<br/><br/><br/>
                <h1>चौकी इंचार्ज अथवा बीट उ0 नि0 का नाम व पद <br/>
                    नाम की मोहर व हस्ताक्षर</h1>
            </td>
            <td style="width: 50%;text-align: right">
                _________________________________________________________________________________________________________<br/><br/><br/>
                <h1>बीट आरक्षी का नाम व पीएनओ <br/>
                    की मोहर व हस्ताक्षर</h1>
            </td>
        </tr>
    </tbody>
</table>
<hr style="border-bottom: 1px dotted #ff0000;padding: 0px;margin: 0px"/><br/><br/>
<table class="bpmTopnTail">
    <tbody>
        <tr class="oddrow">
            <td style="width: 100%" colspan="2">
                <p style="font-size:18px">मुझ हेड मोहर्रिर/ का0 मोहर्रिर द्वारा थाने पर उपलबद्ध आपराधिक रेजिस्टेरों का परिशीलन किया गया तो उपरोक्त आवेदक के विरुद्ध किसी भी आपराधिक रेजिस्टर में कोई भी आपराधिक मामला नहीं पाया गया I </p>
            </td>
        </tr>
        <tr class="oddrow">
            <td style="width: 50%;text-align: right"></td>
            <td style="width: 50%;text-align: right">
                __________________________________________________________________________<br/><br/><br/>
                <h1>हेड का0/ का0 मो0 का नाम व पीएनओ <br/>
                    की मोहर व हस्ताक्षर</h1>
            </td>
        </tr>
    </tbody>
</table><hr style="border-bottom: 1px dotted #ff0000;padding: 0px;margin: 0px"/><br/><br/>
<table class="bpmTopnTail">
    <tbody>
        <tr class="oddrow">
            <td style="width: 100%" colspan="2">
                <p style="font-size:18px"><br/> मैं जाँच कर्ता की आख्या से सहमत हूँ एवं आवेदक का चरित्र प्रमाण-पत्र निर्गत किए जाने की संस्तुति करता हूँ I </p>
            </td>

        </tr>
        <tr class="oddrow">
            <td style="width: 50%;text-align: right"></td>
            <td style="width: 50%;text-align: right">
                <p>__________________________________________________________________________<br/><br/><br/>
                <h1>प्रभारी निरीक्षक/ थानाध्यक्ष, <br/>
                    के नाम/ पदनाम/ पीएनओ की मोहर व हस्ताक्षर</h1> </p>
            </td>

        </tr>
    </tbody>
</table>
<pagebreak />
<hr style="border-bottom: 1px dotted #ff0000;padding: 0px;margin: 0px"/>
<h3 style="border-bottom:1px solid #880000;background-color: #D6DDE3;">&nbsp;&nbsp;भाग 2: पावती/ प्राप्ति स्वीकृति (प्रार्थी BC सखी को यह पावती अपने पास रखना होगा)</h3>

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

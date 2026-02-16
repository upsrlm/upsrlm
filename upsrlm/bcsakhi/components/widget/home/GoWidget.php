<?php

namespace bcsakhi\components\widget\home;

use yii\base\Widget;

// TimelinesWidget.php
class GoWidget extends Widget {

    public $model;

    public function init() {
        parent::init();
    }

    public function run() {
        GoWidgetAsset::register($this->getView());
        $this->model = [
            1 => [
                'time' => '09-Jun-20',
                'title' => '<b class="coloRed">Government Order No. 15/2020/184/38-6-2020-R-165/2020 dated 09th June, 2020 form the office of Principle Secretary, DoRD, Government of Uttar Pradesh pertaining to </b><br>selection of Banking Correspondent Sakhi under Uttar Pradesh State Rural Livelihood Mission',
                'ur' => ''
            ],
            2 => [
                'time' => '16-Dec-20',
                'title' => '<b class="coloRed">Government Order No. 565/38-6-2020-165LC/2020-TC-III dated 16th Dec, 2020 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to</b> <br>Shortlisted Banking Correspondent training and with certification',
                'ur' => ''
            ],
            3 => [
                'time' => '16-Dec-20',
                'title' => '<b class="coloRed">Government Order No. 555/38-6-20-165LC/2020-TC-III dated 16th Dec, 2020 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to</b><br>selection, training and Certification of Banking Correspondent Sakhi',
                'ur' => ''
            ],
            4 => [
                'time' => '01-Jan-21',
                'title' => '<b class="coloRed">Government Order No. 594/38-6-2020-165LC/2020-TC-I dated 1st Jan, 2021 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to</b> <br>district allotment after selection of banks / payment banks / fintech companies to anchor Banking Correspondent-Sakhi',
                'ur' => ''
            ],
            5 => [
                'time' => '16-Feb-21',
                'title' => '<b class="coloRed">Government Order No. 115/38-6-21-165LC/2020 dated 16th Feb, 2021 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to</b> <br>getting the verification done by the police before posting the candidates selected on the post of Banking Correspondent-Sakhi',
                'ur' => ''
            ],
            6 =>
            [
                'time' => '25-Feb-21',
                'title' => '<b class="coloRed">Government Order No. 111/38-6-2021-165LC/2020-TC-III dated 25th Feb, 2021 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to </b> <br>provision of funds for equipment and over-draft to Banking Correspondent Sakhi (Rs.75,000/Banking Correspondent Sakhi)',
                'ur' => ''
            ],
            7 => [
                'time' => '03-Mar-21',
                'title' => '<b class="coloRed">Government Order No. 4284/1258/AJEEVIKA/MF&FI/2020-21 dated 3rd march, 2021 form the office of Mission Director, Uttar Pradesh State Rural Livelihood Mission pertaining to</b> <br>provision of funds for equipment and over draft to Banking Correspondent Sakhi.',
                'ur' => ''
            ],
            8 => [
                'time' => '04-Mar-21',
                'title' => '<b class="coloRed">Government Order No. 153/38-6-21-165LC/2020-TC-III dated 04th Mar, 2020 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to </b> <br>training and Certification of Banking Correspondent Sakhi',
                'ur' => ''
            ],
            9 => [
                'time' => '04-Mar-21',
                'title' => '<b class="coloRed">Government Order No. 154/38-6-21-165LC/2020-TC-III dated 04th Mar, 2021 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to</b> <br>making shortlisted/selected candidates as compulsory members of SHG as Banking Correspondent-Sakhi',
                'ur' => ''
            ],
            10 => [
                'time' => '26-Nov-21',
                'title' => '<b class="coloRed">Government Order No. 651/38-6-2021-165LC/2020-TC-I dated 26th Nov, 2021 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to</b> <br>Proposed event and seminar in Prayagraj on 05.12.2021, accommodating approximately 2.00-2.50 lakh women members/beneficiaries from various programs, including Banking Correspondent Sakhi Scheme, self-help groups, Take Home Ration plant, Kanya Sumangala Yojana, and mass marriage scheme',
                'ur' => ''
            ],
            11 => [
                'time' => '10-Dec-21',
                'title' => '<b class="coloRed">Government Order No. 689/38-6-2021-165LC/2020-TC-I dated 10th Dec, 2021 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to </b>Guidelines regarding the proposed seminar with the members of self- help groups and beneficiaries of other programs in Prayagraj district on 21.12.2021',
                'ur' => ''
            ],
            12 => [
                'time' => '12-Dec-21',
                'title' => '<b class="coloRed">Government Order No. 692/38-6-2021-165LC/2020-TC-I dated 12th Dec, 2021 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to </b> <br>expenditure of funds (Rs. 22,43,61,400) for 1,16,000 Banking Correspondent-Sakhi Dress from the State Share available under the Mission.',
                'ur' => ''
            ],
            13 => [
                'time' => '07-Jan-22',
                'title' => "<b class='coloRed'>Government Order No. 08/38-6-2022-165LC/2020-TC-III dated 7th Jan, 2022 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to</b> <br>Workers' wages under the MNREGA (Mahatma Gandhi National Rural Employment Guarantee Act) scheme will be paid directly into their bank accounts through Banking Correspondent-Sakhi in the village, ensuring convenience, transparency, and accountability.",
                'ur' => ''
            ],
            14 => [
                'time' => '17-Feb-22',
                'title' => '<b class="coloRed">Government Order No. 38-6004(099)/2/2021 dated 17th Feb, 2022 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to </b> <br>expenditure of funds (Rs. 22,43,61,400) for 1,16,000 Banking Correspondent-Sakhi Dress from the State Share available under the Mission.',
                'ur' => ''
            ],
            15 => [
                'time' => '05-Aug-22',
                'title' => '<b class="coloRed">Government Order No. 338/38-6-2022-165LC/2020-TC-I dated 5th Aug, 2022 form the office of Additional Chief Secretary, Government of Uttar Pradesh pertaining to</b> <br>Banking Correspondent-Sakhi Technology Platform Monetization Proposal',
                'ur' => ''
            ],
//            16 => [
//                'time' => '',
//                'title' => '',
//                'ur' => ''
//            ],
//            17 => [
//                'time' => '',
//                'title' => '',
//                'ur' => ''
//            ],
        ];
        return $this->render('go', [
                    'model' => $this->model,
        ]);
    }
}

?>
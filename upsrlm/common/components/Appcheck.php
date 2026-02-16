<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use common\models\User;
use common\models\master\MasterRole;
use common\models\WebApplication;
use yii\helpers\Url;

class Appcheck extends \yii\base\Component {

    public $request;
    public $request_url;
    public $current_app;
    public $role;
    public $application;
    public $route;
    public $access = false;
    public $app_role_route = [
        MasterRole::ROLE_SUPER_ADMIN => [
        ],
        MasterRole::ROLE_ADMIN => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Call request', 'route' => '/call/request', 'visible' => 0],
                ['title' => 'Call request upsrlmstatus', 'route' => '/call/upsrlmstatus', 'visible' => 0],
                ['title' => 'Call request test', 'route' => '/call/multiple', 'visible' => 0],
                [
                    'title' => 'SRLM - BC Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Wise Status', 'route' => '/selection/application/district', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'Dublicate', 'route' => '/selection/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'Block Wise Status', 'route' => '/selection/application/block', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP Wise Status', 'route' => '/selection/application/grampanchayat', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP with No Registration', 'route' => '/selection/application/registration', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP with No Registration summary', 'route' => '/selection/application/districtgp', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP wise application report', 'route' => '/selection/application/downloadcsvgp', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Application - Dashboard Phase', 'route' => '/selection/dashboard/phase1', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application - Dashboard Phase', 'route' => '/selection/dashboard/phase1/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 2
                        ['title' => 'Application Phase2 - Dashboard', 'route' => '/selection/phase2/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase2', 'route' => '/selection/phase2/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase2', 'route' => '/selection/phase2/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase2', 'route' => '/selection/phase2/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase2/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase2/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase2', 'route' => '/selection/phase2/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase2', 'route' => '/selection/phase2/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase2', 'route' => '/selection/phase2/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase2', 'route' => '/selection/phase2/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase2', 'route' => '/selection/phase2/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application Form Validation  Phase2', 'route' => '/selection/phase2/application/validateform', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 3
                        ['title' => 'Application Phase2 - Dashboard', 'route' => '/selection/phase3/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase3/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase3/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase3/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase2', 'route' => '/selection/phase3/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase2', 'route' => '/selection/phase3/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase2', 'route' => '/selection/phase3/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase3/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase3/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase2', 'route' => '/selection/phase3/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase2', 'route' => '/selection/phase3/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase2', 'route' => '/selection/phase3/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase2', 'route' => '/selection/phase3/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase2', 'route' => '/selection/phase3/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application Form Validation  Phase2', 'route' => '/selection/phase3/application/validateform', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 4
                        ['title' => 'Application Phase4 - Dashboard', 'route' => '/selection/phase4/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase4', 'route' => '/selection/phase4/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase4', 'route' => '/selection/phase4/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase4', 'route' => '/selection/phase4/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase4/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase4/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase4', 'route' => '/selection/phase4/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase4', 'route' => '/selection/phase4/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase4', 'route' => '/selection/phase4/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase4', 'route' => '/selection/phase4/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase4', 'route' => '/selection/phase4/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application Form Validation  Phase4', 'route' => '/selection/phase4/application/validateform', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 5
                        ['title' => 'Application Phase4 - Dashboard', 'route' => '/selection/phase5/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase5/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase5/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase5/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase4', 'route' => '/selection/phase5/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase4', 'route' => '/selection/phase5/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase4', 'route' => '/selection/phase5/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase5/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase5/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase4', 'route' => '/selection/phase5/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase4', 'route' => '/selection/phase5/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase4', 'route' => '/selection/phase5/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase4', 'route' => '/selection/phase5/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase4', 'route' => '/selection/phase5/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application Form Validation  Phase4', 'route' => '/selection/phase5/application/validateform', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 6
                        ['title' => 'Application Phase6 - Dashboard', 'route' => '/selection/phase6/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase6', 'route' => '/selection/phase6/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase6', 'route' => '/selection/phase6/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase6', 'route' => '/selection/phase6/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase6', 'route' => '/selection/phase6/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase6', 'route' => '/selection/phase6/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase6', 'route' => '/selection/phase6/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase6', 'route' => '/selection/phase6/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase6', 'route' => '/selection/phase6/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase6', 'route' => '/selection/phase6/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase6', 'route' => '/selection/phase6/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application Form Validation  Phase4', 'route' => '/selection/phase6/application/validateform', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 7
                        ['title' => 'Application Phase7 - Dashboard', 'route' => '/selection/phase7/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase7', 'route' => '/selection/phase7/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase7', 'route' => '/selection/phase7/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase7', 'route' => '/selection/phase7/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase7', 'route' => '/selection/phase7/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase7', 'route' => '/selection/phase7/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase7', 'route' => '/selection/phase7/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase7', 'route' => '/selection/phase7/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase7', 'route' => '/selection/phase7/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase7', 'route' => '/selection/phase7/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase7', 'route' => '/selection/phase7/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application Form Validation  Phase7', 'route' => '/selection/phase7/application/validateform', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'BC Selection', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Report', 'route' => '/selection/dashboard/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List', 'route' => '/selection/data/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View', 'route' => '/selection/data/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application', 'route' => '/selection/data/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score', 'route' => '/selection/data/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graphs', 'route' => '/selection/dashboard/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Select', 'route' => '/selection/data/application/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP where Selection Completed', 'route' => '/selection/dashboard/report/selected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Missing BC', 'route' => '/selection/missing', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Missing BC', 'route' => '/selection/missing/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Map Missing BC', 'route' => '/selection/missing/map', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Comment Missing BC', 'route' => '/selection/missing/comment', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Map Missing BC View', 'route' => '/selection/missing/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Map Missing BC Download', 'route' => '/selection/missing/download', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Duplicacy GP Same', 'route' => '/selection/aadhardublicacy/gpsame', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Duplicacy GP not Same', 'route' => '/selection/aadhardublicacy/gpnotsame', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Currently Vacant GP', 'route' => '/selection/gp/vacant', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected/tblocked', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected/csvsupport', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected vacant GP', 'route' => '/selection/preselected/vacantgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected vacant GP stand by', 'route' => '/selection/preselected/standbybc', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Stand BY', 'route' => '/selection/preselected/standby', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Stand BY', 'route' => '/selection/preselected/standbydownload', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Stand BY', 'route' => '/selection/preselected/standbydownload2', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Stand BY 3', 'route' => '/selection/preselected/standbydownload3', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Stand BY 4', 'route' => '/selection/preselected/standbydownload4', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Stand BY 5', 'route' => '/selection/preselected/standbydownload5', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Stand BY 6', 'route' => '/selection/preselected/standbydownload6', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Stand BY 7', 'route' => '/selection/preselected/standbydownload7', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call1 update', 'route' => '/selection/preselected/call1update', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update BC Name', 'route' => '/selection/preselected/bcnameupdate', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update BC Age', 'route' => '/selection/preselected/ageupdate', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible List', 'route' => '/selection/preselected/ineligiblelist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/selection/preselected/ineligible', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/selection/preselected/resetbcphoto', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call trainees; get consent for training', 'route' => '/training/preselected/agree', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call trainees; get consent for training', 'route' => '/training/preselected/call', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'training agreed', 'route' => '/training/preselected/agreed', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'inbatch', 'route' => '/training/preselected/inbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Reset Agree', 'route' => '/training/preselected/reset', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add Batch training', 'route' => '/training/preselected/addbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update BC Name', 'route' => '/training/preselected/bcnameupdate', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/training/preselected/alreadycertified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update Training', 'route' => '/training/training/update', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Remove Training', 'route' => '/training/training/remove', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Conclude Training Batch', 'route' => '/training/training/conclude', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Un Conclude Training Batch', 'route' => '/training/training/unconclude', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Upload Group photo', 'route' => '/training/training/uploadgroupphoto', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwillinglist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling', 'route' => '/training/participants/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/training/preselected/ineligible', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/training/preselected/ineligibletemp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible List', 'route' => '/training/preselected/ineligiblelist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/confirm', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Preselected remaining BC Download CSV', 'route' => '/training/preselected/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked BC', 'route' => '/training/preselected/certifiedblocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Mobile In used', 'route' => '/training/preselected/mobileinuse', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Mobile In used download', 'route' => '/training/preselected/mobileinusedownload', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Add Mobile No', 'route' => '/training/preselected/addmobileno', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked BC Download CSV', 'route' => '/training/preselected/certifiedblockeddownload', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Stand BY', 'route' => '/selection/preselected/standbydownload1', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified PFMS without bank verification', 'route' => '/training/preselected/pfmswobankverification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified SHG GP change', 'route' => '/training/preselected/bcshggpchange', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/cdounwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/participants/cdounwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/upsrlmunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/participants/upsrlmunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/unwillingprogress', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Upload CSV BC BC Beneficiaries code replace file', 'route' => '/training/participants/importbcpfms', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/report/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/report/dashboard/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/report/partneragencies', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/report/partneragencies/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Onboarding', 'route' => '/report/partneragencies/onboarding', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PAN Card Status', 'route' => '/report/partneragencies/pancard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Handheld Machine provided', 'route' => '/report/partneragencies/handheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Paytm', 'route' => '/training/participants/paytm', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Bank Detail', 'route' => '/training/participants/onboarding', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Remove BC from training batch', 'route' => '/training/participants/remove', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Add score/update status', 'route' => '/training/participants/addscore', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Upload IIBF Certificate photo', 'route' => '/training/participants/uploadiibf', 'visible' => 0, 'icon' => 'fa fa-upload'],
                ['title' => 'Upload PVR', 'route' => '/training/participants/uploadpvr', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Delete Upload PVR', 'route' => '/training/participants/delpvr', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC Assin SHG', 'route' => '/training/participants/assignshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Return BMMU For SHG Add', 'route' => '/training/participants/returnforshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Verify BC/SHG Bank Account detail', 'route' => '/training/participants/verification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Verify BC/SHG Bank Account detail', 'route' => '/training/participants/veryfybcshgbank', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC SHG MAP PFMS', 'route' => '/training/participants/mappfms', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Downlaod Verified BC Bank Account detail', 'route' => '/training/participants/downloadbcbankcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Downlaod Verified BC Bank Account detail', 'route' => '/training/participants/downloadbcbankcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Downlaod For Support', 'route' => '/training/participants/csvsupport', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Return BC For BC Bank Account detail', 'route' => '/training/participants/returnbcbank', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PAN Card Status', 'route' => '/training/participants/pancard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Handheld Machine provided', 'route' => '/training/participants/handheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Add Beneficiaries code', 'route' => '/training/participants/beneficiaries', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Revert Bank Verification', 'route' => '/training/participants/revert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Re Map', 'route' => '/training/participants/remap', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Update Bank Detail SHG', 'route' => '/training/participants/updateshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PFMS & Payment', 'route' => '/training/participants/pfmspayment', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Update bc mobile no', 'route' => '/training/participants/updatemobileno', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Revert PFMS', 'route' => '/training/participants/beneficiariesrevert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Onboard batch CSV', 'route' => '/training/participants/importonboard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Import Pan Available CSV', 'route' => '/training/participants/importpan', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Import Hand Held Machine CSV', 'route' => '/training/participants/importhandheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Sample CSV', 'route' => '/training/participants/sample', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Download Import CSV', 'route' => '/training/participants/importfile', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Participant Change Batch', 'route' => '/training/participants/changebatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Ineligible', 'route' => '/training/participants/ineligible', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Revert BC SHG Mapping', 'route' => '/training/participants/shgrevert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Revert BC SHG funds transfer', 'route' => '/training/participants/mappfmsrevert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Add BC Beneficiaries code', 'route' => '/training/participants/bcbeneficiaries', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC-PFMS mapping', 'route' => '/training/participants/bcpfmsmapping', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Rever BC-PFMS mapping', 'route' => '/training/participants/bcbeneficiariesrevert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Blocke BC Form', 'route' => '/training/participants/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                [
                    'title' => 'Corona', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Corona Feedback', 'route' => '/corona', 'visible' => 1],
                        ['title' => 'Corona Feedback', 'route' => '/corona/default', 'visible' => 1],
                        ['title' => 'Corona Feedback', 'route' => '/corona/default/index', 'visible' => 0],
                        ['title' => 'Corona Feedback', 'route' => '/corona/default/csvdownload', 'visible' => 0],
                        ['title' => 'Corona Feedback report', 'route' => '/corona/report', 'visible' => 0],
                        ['title' => 'Corona Feedback report', 'route' => '/corona/report/index', 'visible' => 0],
                        ['title' => 'Corona Feedback graph', 'route' => '/corona/report/graph', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'MD', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Validation of Deliverables', 'route' => '/md/validation', 'visible' => 1],
                        ['title' => 'Validation of Deliverables', 'route' => '/md/validation/index', 'visible' => 1],
                        ['title' => 'Validation of Deliverables framwork', 'route' => '/md/validation/framework', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Partneragencies', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates', 'visible' => 1],
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates/index', 'visible' => 1],
                        ['title' => 'Add Field Associates', 'route' => '/partneragencies/associates/create', 'visible' => 1],
                        ['title' => 'View Field Associates', 'route' => '/partneragencies/associates/view', 'visible' => 1],
                        ['title' => 'Update Field Associates', 'route' => '/partneragencies/associates/update', 'visible' => 1],
                        ['title' => 'Remove Field Associates', 'route' => '/partneragencies/associates/remove', 'visible' => 1],
                        ['title' => 'Manage User', 'route' => '/partneragencies/user', 'visible' => 1],
                        ['title' => 'Manage User', 'route' => '/partneragencies/user/index', 'visible' => 1],
                        ['title' => 'Add User', 'route' => '/partneragencies/user/add', 'visible' => 1],
                        ['title' => 'Update User', 'route' => '/partneragencies/user/update', 'visible' => 1],
                        ['title' => 'Manage Add Corporate BC', 'route' => '/partneragencies/user/bankfipcorporatebc', 'visible' => 1],
                        ['title' => 'Add Corporate BC', 'route' => '/partneragencies/user/addcorporatebcs', 'visible' => 1],
                        ['title' => 'Update Corporate BC', 'route' => '/partneragencies/user/updatebankfipcorpratebc', 'visible' => 1],
                        ['title' => 'Block User', 'route' => '/partneragencies/user/block', 'visible' => 1],
                        ['title' => 'Resetpassword User', 'route' => '/partneragencies/user/resetpassword', 'visible' => 1],
                        ['title' => 'Switch User', 'route' => '/partneragencies/user/switch', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning/index', 'visible' => 1],
                        ['title' => 'Planning Weekly', 'route' => '/partneragencies/planning/weekly', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction/index', 'visible' => 1],
                        ['title' => 'BC Transaction w/o BC Id', 'route' => '/partneragencies/transaction/wobcid', 'visible' => 1],
                        ['title' => 'BC Transaction w/o BC Id', 'route' => '/partneragencies/transaction/wouniquebcid', 'visible' => 1],
                        ['title' => 'BC Transaction w/o BC Id download', 'route' => '/partneragencies/transaction/downloadwobcid', 'visible' => 1],
                        ['title' => 'BC Transaction Monthly', 'route' => '/partneragencies/transaction/report', 'visible' => 1],
                        ['title' => 'BC Transaction Monthly File Upload Report', 'route' => '/partneragencies/transaction/reportadmin', 'visible' => 1],
                        ['title' => 'BC Transaction Download', 'route' => '/partneragencies/transaction/dailydownload', 'visible' => 1],
                        ['title' => 'BC Transaction Bank report', 'route' => '/partneragencies/transaction/bankreport', 'visible' => 1],
                        ['title' => 'BC Transaction Sample CSV', 'route' => '/partneragencies/transaction/sample', 'visible' => 1],
                        ['title' => 'BC Transaction Import', 'route' => '/partneragencies/transaction/import', 'visible' => 1],
                        ['title' => 'BC Transaction Import', 'route' => '/partneragencies/transaction/import1', 'visible' => 1],
                        ['title' => 'BC Transaction Import file', 'route' => '/partneragencies/transaction/importfile', 'visible' => 1],
                        ['title' => 'BC Transaction Error file', 'route' => '/partneragencies/transaction/errorfile', 'visible' => 1],
                        ['title' => 'BC Transaction Error', 'route' => '/partneragencies/transaction/errordetail', 'visible' => 1],
                        ['title' => 'BC Transaction primary reports', 'route' => '/partneragencies/transaction/primaryreport', 'visible' => 1],
                        ['title' => 'BC Transaction secondary report', 'route' => '/partneragencies/transaction/secondaryreport', 'visible' => 1],
                        ['title' => 'Monthly Transaction', 'route' => '/partneragencies/transaction/monthly', 'visible' => 1],
                        ['title' => 'Weekly Transaction', 'route' => '/partneragencies/transaction/weekly', 'visible' => 1],
                        ['title' => 'Overall Performance BCS', 'route' => '/partneragencies/bc/overallperformance', 'visible' => 1],
                        ['title' => 'Daily Performance BCS', 'route' => '/partneragencies/bc/dailyperformance', 'visible' => 1],
                        ['title' => 'Monthly Performance BCS', 'route' => '/partneragencies/bc/monthlyperformance', 'visible' => 1],
                        ['title' => 'Weekly Performance BCS', 'route' => '/partneragencies/bc/weeklyperformance', 'visible' => 1],
                        ['title' => 'Over All Performance BCS download', 'route' => '/partneragencies/bc/downloadoverall', 'visible' => 1],
                        ['title' => 'GP IN', 'route' => '/partneragencies/gp/in', 'visible' => 1],
                        ['title' => 'GP OUT', 'route' => '/partneragencies/gp/out', 'visible' => 1],
                        ['title' => 'GP Onboard', 'route' => '/partneragencies/gp/onboarding', 'visible' => 1],
                    ],
                ],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/payment', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/upload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs download', 'route' => '/training/honorarium/downloadcsv', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Provided Saree Form to BCs', 'route' => '/training/saree/provided', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Provided Saree CSV UPload Form to BCs', 'route' => '/training/saree/upload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Sample CSV File', 'route' => '/training/saree/sample', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Saree view', 'route' => '/training/saree/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC SHG Fund return', 'route' => '/training/bc/loanrepaid', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC list', 'route' => '/training/bc/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Confirm Bank', 'route' => '/training/participants/confirmbank', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Add', 'route' => '/shg/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'verify', 'route' => '/shg/default/verify', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Member Verification BMMU', 'route' => '/shg/default/memberverificaton', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Update', 'route' => '/shg/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback Report', 'route' => '/shg/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Add', 'route' => '/vo/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'Urban', 'route' => '/vo/default/urban', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'Add Samuh Sakhi', 'route' => '/vo/default/samuhsakhi', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'Samuh Sakhi verifiction', 'route' => '/vo/default/verifysamuhsakhi', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'verify', 'route' => '/vo/default/verify', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Update', 'route' => '/vo/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Add Member', 'route' => '/vo/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                    [
                        'title' => 'CLF', 'route' => '#', 'visible' => 1,
                        'children' => [
                            ['title' => 'Dashboard', 'route' => '/clf/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                            ['title' => 'Dashboard', 'route' => '/clf/dashboard/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                            ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                            ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Add', 'route' => '/clf/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                            ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                            ['title' => 'Update', 'route' => '/clf/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                            ['title' => 'Return', 'route' => '/clf/default/verify', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Remove', 'route' => '/clf/default/remove', 'visible' => 0, 'icon' => 'fa fa-remove'],
                            ['title' => 'Add Member', 'route' => '/clf/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                            ['title' => 'One Time Populate', 'route' => '/clf/default/onetimep', 'visible' => 0, 'icon' => 'fa fa-eye'],
                            ['title' => 'Feedback', 'route' => '/clf/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Feedback', 'route' => '/clf/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Feedback', 'route' => '/clf/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Feedback', 'route' => '/clf/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Feedback Report', 'route' => '/clf/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ],
                    ],
                    [
                        'title' => 'BMMU Profile', 'route' => '#', 'visible' => 1,
                        'children' => [
                            ['title' => 'Update your profile', 'route' => '/profile/update', 'visible' => 1, 'icon' => 'fa fa-edit'],
                            ['title' => 'View your profile', 'route' => '/profile/view', 'visible' => 1, 'icon' => 'fa fa-eye'],
                        ],
                    ],
                    [
                        'title' => 'Report', 'route' => '#', 'visible' => 1,
                        'children' => [
                            ['title' => 'CBO Registration', 'route' => '/shg/report/registration', 'visible' => 1, 'icon' => 'fa fa-list'],
                            ['title' => 'CBO Registration', 'route' => '/shg/report/registrationblock', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Daily Activity SHG BMMU', 'route' => '/shg/report/daily', 'visible' => 1, 'icon' => 'fa fa-download'],
                            ['title' => 'Daily Activity SHG Verifier', 'route' => '/shg/report/dailyv', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ],
                    ],
                    [
                        'title' => 'BC', 'route' => '#', 'visible' => 0,
                        'children' => [
                            ['title' => 'BC No SHG', 'route' => '/bc/noshg', 'visible' => 1],
                            ['title' => 'BC No SHG', 'route' => '/bc/noshg/index', 'visible' => 0],
                            ['title' => 'BC No SHG', 'route' => '/bc/noshg/return', 'visible' => 0],
                            ['title' => 'BC Certified', 'route' => '/bc/certified', 'visible' => 1],
                            ['title' => 'BC Certified', 'route' => '/bc/certified/index', 'visible' => 0],
                            ['title' => 'Get GP', 'route' => '/bc/noshg/assignshg', 'visible' => 0],
                            ['title' => 'GP SHG', 'route' => '/bc/certified/shg', 'visible' => 0],
                            ['title' => 'GP SHG', 'route' => '/bc/certified/shg', 'visible' => 0],
                            ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 0],
                            ['title' => 'Certified View', 'route' => '/bc/certified/bankstatus', 'visible' => 0],
                        ],
                    ],
                    [
                        'title' => 'WADA', 'route' => '#', 'visible' => 0,
                        'children' => [
                            ['title' => 'WADA Samuh Sakhi list', 'route' => '/wada/samuhsakhi', 'visible' => 1],
                            ['title' => 'WADA Samuh Sakhi list', 'route' => '/wada/samuhsakhi/index', 'visible' => 0],
                            ['title' => 'WSS Band detail verify', 'route' => '/wada/samuhsakhi/veryfywadabank', 'visible' => 0],
                        ],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'Users', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-users',
                    'children' => [
                        ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'District Magistrate', 'route' => '/user/dm', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'DC NRLM', 'route' => '/user/dcnrlm', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Divisional Commissioner', 'route' => '/user/dc', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Verifiers', 'route' => '/user/yp', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'RSETI', 'route' => '/user/rsethis', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Bank/ FI partner agencies', 'route' => '/user/bankdu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'List', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-users', 'icon' => 'fa fa-users'],
                        ['title' => 'Add New user', 'route' => '/user/add', 'visible' => 1, 'icon' => 'fa fa-users', 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'Master', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-list',
                    'children' => [
                        ['title' => 'Block List', 'route' => '/master/block/index', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Block Update new block code', 'route' => '/master/block/addnewblockcode', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Gram Panchayat List', 'route' => '/master/grampanchayat', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Gram Panchayat List', 'route' => '/master/grampanchayat/index', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Gram Panchayat List', 'route' => '/master/grampanchayat/list', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Gram Panchayat List', 'route' => '/master/grampanchayat/markurban', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Gram Panchayat Urban', 'route' => '/master/grampanchayat/urban', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Gram Panchayat convert urban', 'route' => '/master/grampanchayat/converturban', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Gram Panchayat change bank', 'route' => '/master/grampanchayat/changebank', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Gram Panchayat add', 'route' => '/master/grampanchayat/create', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Village List', 'route' => '/master/master-village/index', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'ULB List', 'route' => '/master/master-ulb/index', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Ward List', 'route' => '/master/ward/index', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Partner Agency', 'route' => '/master/partneragencies', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Partner Agency', 'route' => '/master/partneragencies/index', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Division', 'route' => '/master/division', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Division', 'route' => '/master/division/index', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Safai Karmi', 'route' => '/master/safaikarmi', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Safai Karmi List', 'route' => '/master/safaikarmi/index', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Safai Karmi add', 'route' => '/master/safaikarmi/create', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                        ['title' => 'Safai Karmi update gp code', 'route' => '/master/safaikarmi/updategpcode', 'visible' => 1, 'icon' => 'fa fa-gloab'],
                    ],
                ],
                [
                    'title' => 'Front', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-list',
                    'children' => [
                        ['title' => 'Notice List', 'route' => '/front/notice', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Government Order List', 'route' => '/front/go', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Media coverage List', 'route' => '/front/mediacoverage', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Notice List', 'route' => '/front/notice/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Government Order List', 'route' => '/front/go/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Media coverage List', 'route' => '/front/mediacoverage/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Add Notice', 'route' => '/front/notice/create', 'visible' => 0, 'icon' => 'fa fa-plus'],
                        ['title' => 'Add Government Order', 'route' => '/front/go/create', 'visible' => 0, 'icon' => 'fa fa-plus'],
                        ['title' => 'Add Media coverage', 'route' => '/front/mediacoverage/create', 'visible' => 0, 'icon' => 'fa fa-plus'],
                        ['title' => 'Update Notice', 'route' => '/front/notice/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Update Government Order', 'route' => '/front/go/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Update Media coverage', 'route' => '/front/mediacoverage/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Notice view', 'route' => '/front/notice/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Government Order view', 'route' => '/front/go/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Media coverage view', 'route' => '/front/mediacoverage/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-list',
                    'children' => [
                        ['title' => 'Notification Template List', 'route' => '/bc/notificationtemplates', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Notification Template List', 'route' => '/bc/notificationtemplates/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Notification Log', 'route' => '/bc/notificationlog', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Notification Log', 'route' => '/bc/notificationlog/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Government Order List', 'route' => '/front/go/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Media coverage List', 'route' => '/front/mediacoverage/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Add Notice', 'route' => '/front/notice/create', 'visible' => 0, 'icon' => 'fa fa-plus'],
                        ['title' => 'Add Government Order', 'route' => '/front/go/create', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'Rishta', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BC SAKHI List', 'route' => '/rishta/bc', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC SAKHI List', 'route' => '/rishta/bc/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Web log list', 'route' => '/rishta/web/log', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Web log List', 'route' => '/rishta/web/log/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Shg list', 'route' => '/rishta/shg', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Shg List', 'route' => '/rishta/shg/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'SHG User', 'route' => '/rishta/shg/user', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Role Permission', 'route' => '/rishta/rolepermission', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Cloud Call center', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Cloud Tele Api Logs', 'route' => '/cloudtel/log', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Cloud Tele Api Logs', 'route' => '/cloudtel/log/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/cloudtel/log/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Telecalleraudio', 'route' => '/cloudtel/log/telecalleraudio', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/cloudtel/report/user', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Manage', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Manage', 'route' => '/user/index', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'New User add', 'route' => '/user/add', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'User update', 'route' => '/user/update', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'User update', 'route' => '/user/updatebmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'User update', 'route' => '/user/updatedmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Change role', 'route' => '/user/changerole', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'DMMU', 'route' => '/user/dmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'SMMU', 'route' => '/user/smmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verify', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verifyvalidate', 'visible' => 0, 'icon' => 'fa fa-users'],
                    ],
                ],
                ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback Report', 'route' => '/shg/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Chairperson verifiction', 'route' => '/shg/default/verifychairperson', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Secretary verifiction', 'route' => '/shg/default/verifysecretary', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Treasurer verifiction', 'route' => '/shg/default/verifytreasurer', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'VO List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO List', 'route' => '/vo/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO List', 'route' => '/vo/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO View', 'route' => '/vo/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Samuh Sakhi verifiction', 'route' => '/vo/default/verifysamuhsakhi', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CLF List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF View', 'route' => '/clf/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF member', 'route' => '/clf/default/member', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF make user', 'route' => '/clf/default/makeuser', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Certified', 'route' => '/bc/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified', 'route' => '/bc/certified/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register View', 'route' => '/bc/register/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Download', 'route' => '/bc/certified/csvdownload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Preselected Download', 'route' => '/bc/register/csvdownload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank status', 'route' => '/bc/certified/bankstatus', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC GP SHG List', 'route' => '/bc/default/shg', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling after certified', 'route' => '/bc/unwilling/certified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling/call', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling after certified action', 'route' => '/bc/unwilling/callcertified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Magnot Certified BC ', 'route' => '/bc/rsetis', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Magnot Certified BC ', 'route' => '/bc/rsetis/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add Magnot Certified BC ', 'route' => '/bc/rsetis/add', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update Magnot Certified BC ', 'route' => '/bc/rsetis/update', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC provided saree list to BCs', 'route' => '/bc/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC provided saree list to BCs', 'route' => '/bc/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Provided Saree Form to BCs', 'route' => '/bc/saree/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO User', 'route' => '/user/cbo', 'visible' => 1, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Rsetis', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Rsetis pendency', 'route' => '/rsetis/pendency', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis pendency', 'route' => '/rsetis/pendency/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'RSETIs District Unit', 'route' => '/rsetis/user', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'RSETIs District Unit', 'route' => '/rsetis/user/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis batch create', 'route' => '/rsetis/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis batch create', 'route' => '/rsetis/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Rishta', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BC SAKHI List', 'route' => '/rishta/bc', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC SAKHI List', 'route' => '/rishta/bc/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'SHG WSS', 'route' => '/rishta/shg/wss', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'SHG Office bearers', 'route' => '/rishta/shg/officebearers', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BLock', 'route' => '/ajaxbc/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajaxbc/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajaxbc/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BLock', 'route' => '/ajax/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajax/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajax/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_RISHTASUPPORT_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg//default/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback Report', 'route' => '/shg/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'VO List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO List', 'route' => '/vo/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO List', 'route' => '/vo/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Samuh Sakhi verifiction', 'route' => '/vo/default/verifysamuhsakhi', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CLF List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF member', 'route' => '/clf/default/member', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF make user', 'route' => '/clf/default/makeuser', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO User', 'route' => '/user/cbo', 'visible' => 1, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BLock', 'route' => '/ajaxbc/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajaxbc/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajaxbc/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BLock', 'route' => '/ajax/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajax/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajax/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAHELI_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/cbo/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/cbo/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'View', 'route' => '/cbo/shg/view/index', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/cbo/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/cbo/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'View', 'route' => '/cbo/vo/view/index', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                    [
                        'title' => 'CLF', 'route' => '#', 'visible' => 1,
                        'children' => [
                            ['title' => 'List', 'route' => '/cbo/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                            ['title' => 'List', 'route' => '/cbo/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'List', 'route' => '/cbo/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Add', 'route' => '/cbo/clf/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                            ['title' => 'View', 'route' => '/cbo/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                            ['title' => 'View', 'route' => '/cbo/clf/view/index', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ],
                    ],
                    [
                        'title' => 'BC', 'route' => '#', 'visible' => 0,
                        'children' => [
                            ['title' => 'BC No SHG', 'route' => '/cbo/bc/noshg', 'visible' => 1],
                            ['title' => 'BC No SHG', 'route' => '/cbo/bc/noshg/index', 'visible' => 0],
                            ['title' => 'BC No SHG', 'route' => '/cbo/bc/noshg/return', 'visible' => 0],
                            ['title' => 'BC Certified', 'route' => '/cbo/bc/certified', 'visible' => 1],
                            ['title' => 'BC Certified', 'route' => '/cbo/bc/certified/index', 'visible' => 0],
                            ['title' => 'Certified View', 'route' => '/cbo/bc/certified/view', 'visible' => 0],
                            ['title' => 'Certified View', 'route' => '/cbo/bc/certified/bankstatus', 'visible' => 0],
                        ],
                    ],
                ],
            ],
            WebApplication::WEB_APP_WADA_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/completecsv', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Wada Sakhi Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'WADA Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/user/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'User Add', 'route' => '/user/add', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'User Update', 'route' => '/user/update', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'user resetpassword ', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'user switch ', 'route' => '/user/switch', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'call', 'route' => '/shg/default/call', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/cst', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/cst/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/cst/call', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback Report', 'route' => '/shg/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Chairperson verifiction', 'route' => '/shg/default/verifychairperson', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Secretary verifiction', 'route' => '/shg/default/verifysecretary', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Treasurer verifiction', 'route' => '/shg/default/verifytreasurer', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Cloud Call center', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/report/log/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Telecalleraudio', 'route' => '/report/log/telecalleraudio', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_DBT_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/user/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'User Add', 'route' => '/user/add', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'User Update', 'route' => '/user/update', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'user resetpassword ', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ULTRA_POOR_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Hhs view', 'route' => '/data/survey/view', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs view', 'route' => '/data/survey/index', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report district', 'route' => '/report/hhs/district', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report block', 'route' => '/report/hhs/block', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report GP', 'route' => '/report/hhs/gp', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Agent progress', 'route' => '/report/agent/progress', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Agent progress detail', 'route' => '/report/agent/calldetail', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Call Audio', 'route' => '/report/agent/telecalleraudio', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/user/index', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'User Add', 'route' => '/user/add', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'User Update', 'route' => '/user/update', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'user resetpassword ', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'call', 'route' => '/shg/default/call', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Chairperson verifiction', 'route' => '/shg/default/verifychairperson', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Secretary verifiction', 'route' => '/shg/default/verifysecretary', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Treasurer verifiction', 'route' => '/shg/default/verifytreasurer', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Cloud Call center', 'route' => '#', 'visible' => 1,
                    'children' => [
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'view', 'route' => '/report/log/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Telecalleraudio', 'route' => '/report/log/telecalleraudio', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_DBT_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/user/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'User Add', 'route' => '/user/add', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'User Update', 'route' => '/user/update', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'user resetpassword ', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'call', 'route' => '/shg/default/call', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Cloud Call center', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'User Report', 'route' => '/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'call', 'route' => '/shg/default/call', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback Report', 'route' => '/shg/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Chairperson verifiction', 'route' => '/shg/default/verifychairperson', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Secretary verifiction', 'route' => '/shg/default/verifysecretary', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Treasurer verifiction', 'route' => '/shg/default/verifytreasurer', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Cloud Call center', 'route' => '#', 'visible' => 1,
                    'children' => [
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'view', 'route' => '/report/log/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Telecalleraudio', 'route' => '/report/log/telecalleraudio', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_DBT_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'call', 'route' => '/shg/default/call', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback Report', 'route' => '/shg/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Chairperson verifiction', 'route' => '/shg/default/verifychairperson', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Secretary verifiction', 'route' => '/shg/default/verifysecretary', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Treasurer verifiction', 'route' => '/shg/default/verifytreasurer', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Cloud Call center', 'route' => '#', 'visible' => 1,
                    'children' => [
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'view', 'route' => '/report/log/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Telecalleraudio', 'route' => '/report/log/telecalleraudio', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_DBT_CALL_CENTER_MANAGER => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/cst', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/cst/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/cst/call', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'call', 'route' => '/shg/default/call', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
////                        ['title' => 'Feedback', 'route' => '/shg/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
////                        ['title' => 'Feedback', 'route' => '/shg/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
////                        ['title' => 'Feedback Report', 'route' => '/shg/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Chairperson verifiction', 'route' => '/shg/default/verifychairperson', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Secretary verifiction', 'route' => '/shg/default/verifysecretary', 'visible' => 0, 'icon' => 'fa fa-eye'],
//                        ['title' => 'Treasurer verifiction', 'route' => '/shg/default/verifytreasurer', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Cloud Call center', 'route' => '#', 'visible' => 1,
                    'children' => [
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'view', 'route' => '/report/log/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Telecalleraudio', 'route' => '/report/log/telecalleraudio', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_DBT_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/user/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'User Add', 'route' => '/user/add', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'User Update', 'route' => '/user/update', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'user resetpassword ', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/cst', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/cst/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/cst/call', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'call', 'route' => '/shg/default/call', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Chairperson verifiction', 'route' => '/shg/default/verifychairperson', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Secretary verifiction', 'route' => '/shg/default/verifysecretary', 'visible' => 0, 'icon' => 'fa fa-eye'],
//                        ['title' => 'Treasurer verifiction', 'route' => '/shg/default/verifytreasurer', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Cloud Call center', 'route' => '#', 'visible' => 1,
                    'children' => [
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Cloud Tele Api Logs', 'route' => '/report/log/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'view', 'route' => '/report/log/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Telecalleraudio', 'route' => '/report/log/telecalleraudio', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'User Report', 'route' => '/report/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_DBT_CALL_CENTER_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
            ],
        ],
        MasterRole::ROLE_HR_ADMIN => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Manage', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Manage', 'route' => '/user/index', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'New User add', 'route' => '/user/add', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'User update', 'route' => '/user/update', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'User update', 'route' => '/user/updatebmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'User update', 'route' => '/user/updatedmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Change role', 'route' => '/user/changerole', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'DMMU', 'route' => '/user/dmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'SMMU', 'route' => '/user/smmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verify', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verifyvalidate', 'visible' => 0, 'icon' => 'fa fa-users'],
                    ],
                ],
                ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_JMD => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Manage', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Manage', 'route' => '/user/index', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'New User add', 'route' => '/user/add', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'User update', 'route' => '/user/update', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'User update', 'route' => '/user/updatebmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'User update', 'route' => '/user/updatedmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Change role', 'route' => '/user/changerole', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'DMMU', 'route' => '/user/dmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'SMMU', 'route' => '/user/smmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verify', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verifyvalidate', 'visible' => 0, 'icon' => 'fa fa-users'],
                    ],
                ],
                ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg//default/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CLF List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF member', 'route' => '/clf/default/member', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF make user', 'route' => '/clf/default/makeuser', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Certified', 'route' => '/bc/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified', 'route' => '/bc/certified/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Download', 'route' => '/bc/certified/csvdownload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC GP SHG List', 'route' => '/bc/default/shg', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_MD => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SRLM - BC Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Wise Status', 'route' => '/selection/application/district', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'Dublicate', 'route' => '/selection/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'Block Wise Status', 'route' => '/selection/application/block', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP Wise Status', 'route' => '/selection/application/grampanchayat', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP with No Registration', 'route' => '/selection/application/registration', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP with No Registration summary', 'route' => '/selection/application/districtgp', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP wise application report', 'route' => '/selection/application/downloadcsvgp', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Application - Dashboard Phase', 'route' => '/selection/dashboard/phase1', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application - Dashboard Phase', 'route' => '/selection/dashboard/phase1/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 2
                        ['title' => 'Application Phase2 - Dashboard', 'route' => '/selection/phase2/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase2', 'route' => '/selection/phase2/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase2', 'route' => '/selection/phase2/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase2', 'route' => '/selection/phase2/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase2/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase2/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase2', 'route' => '/selection/phase2/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase2', 'route' => '/selection/phase2/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase2', 'route' => '/selection/phase2/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase2', 'route' => '/selection/phase2/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase2', 'route' => '/selection/phase2/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 3
                        ['title' => 'Application Phase3 - Dashboard', 'route' => '/selection/phase3/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase3', 'route' => '/selection/phase3/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase3', 'route' => '/selection/phase3/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase3', 'route' => '/selection/phase3/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase3', 'route' => '/selection/phase3/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase3', 'route' => '/selection/phase3/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase3', 'route' => '/selection/phase3/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase3', 'route' => '/selection/phase3/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase3', 'route' => '/selection/phase3/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase3', 'route' => '/selection/phase3/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase3', 'route' => '/selection/phase3/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase3', 'route' => '/selection/phase3/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase3', 'route' => '/selection/phase3/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase3', 'route' => '/selection/phase3/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 4
                        ['title' => 'Application Phase4 - Dashboard', 'route' => '/selection/phase4/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase4', 'route' => '/selection/phase4/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase4', 'route' => '/selection/phase4/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase4', 'route' => '/selection/phase4/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase4/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase4/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase4', 'route' => '/selection/phase4/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase4', 'route' => '/selection/phase4/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase4', 'route' => '/selection/phase4/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase4', 'route' => '/selection/phase4/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase4', 'route' => '/selection/phase4/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 5
                        ['title' => 'Application Phase5 - Dashboard', 'route' => '/selection/phase5/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase5', 'route' => '/selection/phase5/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase5', 'route' => '/selection/phase5/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase5', 'route' => '/selection/phase5/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase5', 'route' => '/selection/phase5/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase5', 'route' => '/selection/phase5/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase5', 'route' => '/selection/phase5/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase5', 'route' => '/selection/phase5/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase5', 'route' => '/selection/phase5/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase5', 'route' => '/selection/phase5/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase5', 'route' => '/selection/phase5/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase5', 'route' => '/selection/phase5/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase5', 'route' => '/selection/phase5/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase5', 'route' => '/selection/phase5/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 6
                        ['title' => 'Application Phase6 - Dashboard', 'route' => '/selection/phase6/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase6', 'route' => '/selection/phase6/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase6', 'route' => '/selection/phase6/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase6', 'route' => '/selection/phase6/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase6', 'route' => '/selection/phase6/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase6', 'route' => '/selection/phase6/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase6', 'route' => '/selection/phase6/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase6', 'route' => '/selection/phase6/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase6', 'route' => '/selection/phase6/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase6', 'route' => '/selection/phase6/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase6', 'route' => '/selection/phase6/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 7
                        ['title' => 'Application Phase7 - Dashboard', 'route' => '/selection/phase7/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase7', 'route' => '/selection/phase7/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase7', 'route' => '/selection/phase7/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase7', 'route' => '/selection/phase7/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase7', 'route' => '/selection/phase7/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase7', 'route' => '/selection/phase7/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase7', 'route' => '/selection/phase7/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase7', 'route' => '/selection/phase7/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase7', 'route' => '/selection/phase7/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase7', 'route' => '/selection/phase7/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase7', 'route' => '/selection/phase7/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
//                [
//                    'title' => 'BC Selection', 'route' => '#', 'visible' => 1,
//                    'children' => [
//                        ['title' => 'Report', 'route' => '/selection/dashboard/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'BC Sakhi List', 'route' => '/selection/data/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'BC Sakhi View', 'route' => '/selection/data/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'Single application', 'route' => '/selection/data/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'Person Highest score', 'route' => '/selection/data/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Graphs', 'route' => '/selection/dashboard/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'Select', 'route' => '/selection/data/application/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'GP where Selection Completed', 'route' => '/selection/dashboard/report/selected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                    ],
//                ],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected vacant GP', 'route' => '/selection/preselected/vacantgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected vacant GP stand by', 'route' => '/selection/preselected/standbybc', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'inbatch', 'route' => '/training/preselected/inbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwillinglist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Preselected remaining BC Download CSV', 'route' => '/training/preselected/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/upsrlmunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/participants/upsrlmunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Paytm', 'route' => '/training/participants/paytm', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
                //['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC', 'route' => '/training/participants/assignshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Return BMMU For SHG Add', 'route' => '/training/participants/returnforshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Update Bank Detail SHG', 'route' => '/training/participants/updateshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Verify BC/SHG Bank Account detail', 'route' => '/training/participants/verification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PFMS & Payment', 'route' => '/training/participants/pfmspayment', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC-PFMS mapping', 'route' => '/training/participants/bcpfmsmapping', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                [
                    'title' => 'MD', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Validation of Deliverables', 'route' => '/md/validation', 'visible' => 1],
                        ['title' => 'Validation of Deliverables', 'route' => '/md/validation/index', 'visible' => 1],
                        ['title' => 'Validation of Deliverables framwork', 'route' => '/md/validation/framework', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Partneragencies', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates', 'visible' => 1],
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates/index', 'visible' => 1],
                        ['title' => 'View Field Associates', 'route' => '/partneragencies/associates/view', 'visible' => 1],
                        ['title' => 'Manage User', 'route' => '/partneragencies/user', 'visible' => 1],
                        ['title' => 'Manage User', 'route' => '/partneragencies/user/index', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning/index', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction/index', 'visible' => 1],
                        ['title' => 'BC Transaction Monthly', 'route' => '/partneragencies/transaction/report', 'visible' => 1],
                        ['title' => 'BC Transaction Monthly File Upload Report', 'route' => '/partneragencies/transaction/reportadmin', 'visible' => 1],
                        ['title' => 'BC Transaction Download', 'route' => '/partneragencies/transaction/dailydownload', 'visible' => 1],
                        ['title' => 'BC Transaction Error', 'route' => '/partneragencies/transaction/errordetail', 'visible' => 1],
                        ['title' => 'BC Transaction Bank report', 'route' => '/partneragencies/transaction/bankreport', 'visible' => 1],
                        //['title' => 'BC Transaction primary reports', 'route' => '/partneragencies/transaction/primaryreport', 'visible' => 1],
                        //['title' => 'BC Transaction secondary report', 'route' => '/partneragencies/transaction/secondaryreport', 'visible' => 1],
                        ['title' => 'Overall Performance BCS', 'route' => '/partneragencies/bc/overallperformance', 'visible' => 1],
                        ['title' => 'Daily Performance BCS', 'route' => '/partneragencies/bc/dailyperformance', 'visible' => 1],
                        ['title' => 'Monthly Performance BCS', 'route' => '/partneragencies/bc/monthlyperformance', 'visible' => 1],
                    ],
                ],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/payment', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs download', 'route' => '/training/honorarium/downloadcsv', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Sample CSV File', 'route' => '/training/saree/sample', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            //['title' => 'Saree view', 'route' => '/training/saree/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Urban', 'route' => '/vo/default/urban', 'visible' => 1, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registration', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registrationblock', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Daily Activity SHG BMMU', 'route' => '/shg/report/daily', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Daily Activity SHG Verifier', 'route' => '/shg/report/dailyv', 'visible' => 1, 'icon' => 'fa fa-download'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg', 'visible' => 1],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/index', 'visible' => 0],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/return', 'visible' => 0],
                        ['title' => 'BC Certified', 'route' => '/bc/certified', 'visible' => 1],
                        ['title' => 'BC Certified', 'route' => '/bc/certified/index', 'visible' => 0],
                        ['title' => 'GP SHG', 'route' => '/bc/certified/shg', 'visible' => 0],
                        ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 0],
                        ['title' => 'Certified View', 'route' => '/bc/certified/bankstatus', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'WADA', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'WADA Samuh Sakhi list', 'route' => '/wada/samuhsakhi', 'visible' => 1],
                        ['title' => 'WADA Samuh Sakhi list', 'route' => '/wada/samuhsakhi/index', 'visible' => 0],
//                        ['title' => 'WSS Band detail verify', 'route' => '/wada/samuhsakhi/veryfywadabank', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Manage', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Manage', 'route' => '/user/index', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'New User add', 'route' => '/user/add', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'User update', 'route' => '/user/update', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'User update', 'route' => '/user/updatebmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'User update', 'route' => '/user/updatedmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'Change role', 'route' => '/user/changerole', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'DMMU', 'route' => '/user/dmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'SMMU', 'route' => '/user/smmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verify', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verifyvalidate', 'visible' => 0, 'icon' => 'fa fa-users'],
                    ],
                ],
                ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg//default/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CLF List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF member', 'route' => '/clf/default/member', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF make user', 'route' => '/clf/default/makeuser', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Certified', 'route' => '/bc/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified', 'route' => '/bc/certified/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register View', 'route' => '/bc/register/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Download', 'route' => '/bc/certified/csvdownload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank status', 'route' => '/bc/certified/bankstatus', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC GP SHG List', 'route' => '/bc/default/shg', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC provided saree list to BCs', 'route' => '/bc/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC provided saree list to BCs', 'route' => '/bc/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Provided Saree Form to BCs', 'route' => '/bc/saree/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BLock', 'route' => '/ajaxbc/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajaxbc/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajaxbc/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BLock', 'route' => '/ajax/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajax/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajax/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_WADA_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1],
//                ['title' => 'Dashboard', 'route' => '/dashboard/default/completecsv', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Wada Sakhi Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'WADA Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ULTRA_POOR_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Hhs view', 'route' => '/data/survey/view', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs view', 'route' => '/data/survey/index', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report district', 'route' => '/report/hhs/district', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report block', 'route' => '/report/hhs/block', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report GP', 'route' => '/report/hhs/gp', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_MSC => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SRLM - BC Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Wise Status', 'route' => '/selection/application/district', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'Dublicate', 'route' => '/selection/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'Block Wise Status', 'route' => '/selection/application/block', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP Wise Status', 'route' => '/selection/application/grampanchayat', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP with No Registration', 'route' => '/selection/application/registration', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP with No Registration summary', 'route' => '/selection/application/districtgp', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP wise application report', 'route' => '/selection/application/downloadcsvgp', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Application - Dashboard Phase', 'route' => '/selection/dashboard/phase1', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application - Dashboard Phase', 'route' => '/selection/dashboard/phase1/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 2
                        ['title' => 'Application Phase2 - Dashboard', 'route' => '/selection/phase2/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase2', 'route' => '/selection/phase2/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase2', 'route' => '/selection/phase2/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase2', 'route' => '/selection/phase2/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase2/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase2/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase2', 'route' => '/selection/phase2/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase2', 'route' => '/selection/phase2/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase2', 'route' => '/selection/phase2/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase2', 'route' => '/selection/phase2/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase2', 'route' => '/selection/phase2/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 3
                        ['title' => 'Application Phase3 - Dashboard', 'route' => '/selection/phase3/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase3', 'route' => '/selection/phase3/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase3', 'route' => '/selection/phase3/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase3', 'route' => '/selection/phase3/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase3', 'route' => '/selection/phase3/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase3', 'route' => '/selection/phase3/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase3', 'route' => '/selection/phase3/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase3', 'route' => '/selection/phase3/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase3', 'route' => '/selection/phase3/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase3', 'route' => '/selection/phase3/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase3', 'route' => '/selection/phase3/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase3', 'route' => '/selection/phase3/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase3', 'route' => '/selection/phase3/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase3', 'route' => '/selection/phase3/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 4
                        ['title' => 'Application Phase4 - Dashboard', 'route' => '/selection/phase4/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase4', 'route' => '/selection/phase4/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase4', 'route' => '/selection/phase4/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase4', 'route' => '/selection/phase4/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase4/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase4/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase4', 'route' => '/selection/phase4/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase4', 'route' => '/selection/phase4/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase4', 'route' => '/selection/phase4/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase4', 'route' => '/selection/phase4/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase4', 'route' => '/selection/phase4/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 5
                        ['title' => 'Application Phase5 - Dashboard', 'route' => '/selection/phase5/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase5', 'route' => '/selection/phase5/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase5', 'route' => '/selection/phase5/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase5', 'route' => '/selection/phase5/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase5', 'route' => '/selection/phase5/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase5', 'route' => '/selection/phase5/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase5', 'route' => '/selection/phase5/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase5', 'route' => '/selection/phase5/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase5', 'route' => '/selection/phase5/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase5', 'route' => '/selection/phase5/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase5', 'route' => '/selection/phase5/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase5', 'route' => '/selection/phase5/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase5', 'route' => '/selection/phase5/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase5', 'route' => '/selection/phase5/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 6
                        ['title' => 'Application Phase6 - Dashboard', 'route' => '/selection/phase6/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase6', 'route' => '/selection/phase6/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase6', 'route' => '/selection/phase6/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase6', 'route' => '/selection/phase6/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase6', 'route' => '/selection/phase6/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase6', 'route' => '/selection/phase6/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase6', 'route' => '/selection/phase6/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase6', 'route' => '/selection/phase6/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase6', 'route' => '/selection/phase6/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase6', 'route' => '/selection/phase6/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase6', 'route' => '/selection/phase6/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 7
                        ['title' => 'Application Phase7 - Dashboard', 'route' => '/selection/phase7/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase7', 'route' => '/selection/phase7/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase7', 'route' => '/selection/phase7/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase7', 'route' => '/selection/phase7/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase7', 'route' => '/selection/phase7/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase7', 'route' => '/selection/phase7/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase7', 'route' => '/selection/phase7/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase7', 'route' => '/selection/phase7/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase7', 'route' => '/selection/phase7/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase7', 'route' => '/selection/phase7/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase7', 'route' => '/selection/phase7/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
//                [
//                    'title' => 'BC Selection', 'route' => '#', 'visible' => 1,
//                    'children' => [
//                        ['title' => 'Report', 'route' => '/selection/dashboard/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'BC Sakhi List', 'route' => '/selection/data/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'BC Sakhi View', 'route' => '/selection/data/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'Single application', 'route' => '/selection/data/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'Person Highest score', 'route' => '/selection/data/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Graphs', 'route' => '/selection/dashboard/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        //['title' => 'Select', 'route' => '/selection/data/application/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'GP where Selection Completed', 'route' => '/selection/dashboard/report/selected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                    ],
//                ],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected vacant GP', 'route' => '/selection/preselected/vacantgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected vacant GP stand by', 'route' => '/selection/preselected/standbybc', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'inbatch', 'route' => '/training/preselected/inbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwillinglist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Preselected remaining BC Download CSV', 'route' => '/training/preselected/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/upsrlmunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/participants/upsrlmunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Paytm', 'route' => '/training/participants/paytm', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
                //['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC', 'route' => '/training/participants/assignshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Return BMMU For SHG Add', 'route' => '/training/participants/returnforshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Update Bank Detail SHG', 'route' => '/training/participants/updateshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Verify BC/SHG Bank Account detail', 'route' => '/training/participants/verification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PFMS & Payment', 'route' => '/training/participants/pfmspayment', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC-PFMS mapping', 'route' => '/training/participants/bcpfmsmapping', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                [
                    'title' => 'MD', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Validation of Deliverables', 'route' => '/md/validation', 'visible' => 1],
                        ['title' => 'Validation of Deliverables', 'route' => '/md/validation/index', 'visible' => 1],
                        ['title' => 'Validation of Deliverables framwork', 'route' => '/md/validation/framework', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Partneragencies', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates', 'visible' => 1],
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates/index', 'visible' => 1],
                        ['title' => 'View Field Associates', 'route' => '/partneragencies/associates/view', 'visible' => 1],
                        ['title' => 'Manage User', 'route' => '/partneragencies/user', 'visible' => 1],
                        ['title' => 'Manage User', 'route' => '/partneragencies/user/index', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning/index', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction/index', 'visible' => 1],
                        ['title' => 'BC Transaction Monthly', 'route' => '/partneragencies/transaction/report', 'visible' => 1],
                        ['title' => 'BC Transaction Monthly File Upload Report', 'route' => '/partneragencies/transaction/reportadmin', 'visible' => 1],
                        ['title' => 'BC Transaction Download', 'route' => '/partneragencies/transaction/dailydownload', 'visible' => 1],
                        ['title' => 'BC Transaction Error', 'route' => '/partneragencies/transaction/errordetail', 'visible' => 1],
                        ['title' => 'BC Transaction Bank report', 'route' => '/partneragencies/transaction/bankreport', 'visible' => 1],
                        //['title' => 'BC Transaction primary reports', 'route' => '/partneragencies/transaction/primaryreport', 'visible' => 1],
                        //['title' => 'BC Transaction secondary report', 'route' => '/partneragencies/transaction/secondaryreport', 'visible' => 1],
                        ['title' => 'Overall Performance BCS', 'route' => '/partneragencies/bc/overallperformance', 'visible' => 1],
                        ['title' => 'Daily Performance BCS', 'route' => '/partneragencies/bc/dailyperformance', 'visible' => 1],
                        ['title' => 'Monthly Performance BCS', 'route' => '/partneragencies/bc/monthlyperformance', 'visible' => 1],
                    ],
                ],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/payment', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs download', 'route' => '/training/honorarium/downloadcsv', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Sample CSV File', 'route' => '/training/saree/sample', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            //['title' => 'Saree view', 'route' => '/training/saree/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Urban', 'route' => '/vo/default/urban', 'visible' => 1, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registration', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registrationblock', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Daily Activity SHG BMMU', 'route' => '/shg/report/daily', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Daily Activity SHG Verifier', 'route' => '/shg/report/dailyv', 'visible' => 1, 'icon' => 'fa fa-download'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg', 'visible' => 1],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/index', 'visible' => 0],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/return', 'visible' => 0],
                        ['title' => 'BC Certified', 'route' => '/bc/certified', 'visible' => 1],
                        ['title' => 'BC Certified', 'route' => '/bc/certified/index', 'visible' => 0],
                        ['title' => 'GP SHG', 'route' => '/bc/certified/shg', 'visible' => 0],
                        ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 0],
                        ['title' => 'Certified View', 'route' => '/bc/certified/bankstatus', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'WADA', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'WADA Samuh Sakhi list', 'route' => '/wada/samuhsakhi', 'visible' => 1],
                        ['title' => 'WADA Samuh Sakhi list', 'route' => '/wada/samuhsakhi/index', 'visible' => 0],
//                        ['title' => 'WSS Band detail verify', 'route' => '/wada/samuhsakhi/veryfywadabank', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Manage', 'route' => '/user', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'Manage', 'route' => '/user/index', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'New User add', 'route' => '/user/add', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'User update', 'route' => '/user/update', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'User update', 'route' => '/user/updatebmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'User update', 'route' => '/user/updatedmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'Change role', 'route' => '/user/changerole', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'DMMU', 'route' => '/user/dmmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        ['title' => 'SMMU', 'route' => '/user/smmu', 'visible' => 1, 'icon' => 'fa fa-users'],
                        //['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'User View', 'route' => '/user/view', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verify', 'visible' => 0, 'icon' => 'fa fa-users'],
                        ['title' => 'Verify', 'route' => '/user/verifyvalidate', 'visible' => 0, 'icon' => 'fa fa-users'],
                    ],
                ],
                ['title' => 'BMMU', 'route' => '/user/bmmu', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'Reset Password', 'route' => '/user/resetpassword', 'visible' => 0, 'icon' => 'fa fa-users'],
                ['title' => 'User Block', 'route' => '/user/block', 'visible' => 0, 'icon' => 'fa fa-users'],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg//default/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CLF List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF member', 'route' => '/clf/default/member', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF make user', 'route' => '/clf/default/makeuser', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Certified', 'route' => '/bc/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified', 'route' => '/bc/certified/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register View', 'route' => '/bc/register/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Download', 'route' => '/bc/certified/csvdownload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank status', 'route' => '/bc/certified/bankstatus', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC GP SHG List', 'route' => '/bc/default/shg', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC provided saree list to BCs', 'route' => '/bc/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC provided saree list to BCs', 'route' => '/bc/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Provided Saree Form to BCs', 'route' => '/bc/saree/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BLock', 'route' => '/ajaxbc/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajaxbc/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajaxbc/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BLock', 'route' => '/ajax/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajax/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajax/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_WADA_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1],
//                ['title' => 'Dashboard', 'route' => '/dashboard/default/completecsv', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Wada Sakhi Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'WADA Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ULTRA_POOR_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Hhs view', 'route' => '/data/survey/view', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs view', 'route' => '/data/survey/index', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report district', 'route' => '/report/hhs/district', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report block', 'route' => '/report/hhs/block', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report GP', 'route' => '/report/hhs/gp', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_BC_VIEWER => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SRLM - BC Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Wise Status', 'route' => '/selection/application/district', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'Dublicate', 'route' => '/selection/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'Block Wise Status', 'route' => '/selection/application/block', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP Wise Status', 'route' => '/selection/application/grampanchayat', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP with No Registration', 'route' => '/selection/application/registration', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP with No Registration summary', 'route' => '/selection/application/districtgp', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'GP wise application report', 'route' => '/selection/application/downloadcsvgp', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Application - Dashboard Phase', 'route' => '/selection/dashboard/phase1', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Application - Dashboard Phase', 'route' => '/selection/dashboard/phase1/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 2
                        ['title' => 'Application Phase2 - Dashboard', 'route' => '/selection/phase2/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase2', 'route' => '/selection/phase2/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase2', 'route' => '/selection/phase2/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase2', 'route' => '/selection/phase2/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase2', 'route' => '/selection/phase2/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase2/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase2', 'route' => '/selection/phase2/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase2', 'route' => '/selection/phase2/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase2', 'route' => '/selection/phase2/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase2', 'route' => '/selection/phase2/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase2', 'route' => '/selection/phase2/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase2', 'route' => '/selection/phase2/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 3
                        ['title' => 'Application Phase3 - Dashboard', 'route' => '/selection/phase3/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase3', 'route' => '/selection/phase3/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase3', 'route' => '/selection/phase3/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase3', 'route' => '/selection/phase3/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase3', 'route' => '/selection/phase3/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase3', 'route' => '/selection/phase3/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase3', 'route' => '/selection/phase3/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase3', 'route' => '/selection/phase3/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase3', 'route' => '/selection/phase3/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase3', 'route' => '/selection/phase3/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase3', 'route' => '/selection/phase3/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase3', 'route' => '/selection/phase3/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase3', 'route' => '/selection/phase3/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase3', 'route' => '/selection/phase3/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 4
                        ['title' => 'Application Phase4 - Dashboard', 'route' => '/selection/phase4/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase4', 'route' => '/selection/phase4/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase4', 'route' => '/selection/phase4/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase4', 'route' => '/selection/phase4/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase4', 'route' => '/selection/phase4/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase4/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase4', 'route' => '/selection/phase4/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase4', 'route' => '/selection/phase4/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase4', 'route' => '/selection/phase4/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase4', 'route' => '/selection/phase4/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase4', 'route' => '/selection/phase4/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase4', 'route' => '/selection/phase4/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 5
                        ['title' => 'Application Phase5 - Dashboard', 'route' => '/selection/phase5/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase5', 'route' => '/selection/phase5/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase5', 'route' => '/selection/phase5/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase5', 'route' => '/selection/phase5/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase5', 'route' => '/selection/phase5/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase5', 'route' => '/selection/phase5/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase5', 'route' => '/selection/phase5/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase5', 'route' => '/selection/phase5/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase5', 'route' => '/selection/phase5/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase5', 'route' => '/selection/phase5/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase5', 'route' => '/selection/phase5/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase5', 'route' => '/selection/phase5/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase5', 'route' => '/selection/phase5/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase5', 'route' => '/selection/phase5/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 6
                        ['title' => 'Application Phase6 - Dashboard', 'route' => '/selection/phase6/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase6', 'route' => '/selection/phase6/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase6', 'route' => '/selection/phase6/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase6', 'route' => '/selection/phase6/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase6', 'route' => '/selection/phase6/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase6', 'route' => '/selection/phase6/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase6', 'route' => '/selection/phase6/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase6', 'route' => '/selection/phase6/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase6', 'route' => '/selection/phase6/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase6', 'route' => '/selection/phase6/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase6', 'route' => '/selection/phase6/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase6', 'route' => '/selection/phase6/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        // phase 7
                        ['title' => 'Application Phase7 - Dashboard', 'route' => '/selection/phase7/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List Phase7', 'route' => '/selection/phase7/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View Phase7', 'route' => '/selection/phase7/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application Phase7', 'route' => '/selection/phase7/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score Phase7', 'route' => '/selection/phase7/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase7', 'route' => '/selection/phase7/application/district', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'District Phase7', 'route' => '/selection/phase7/application/districtgp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Block Phase7', 'route' => '/selection/phase7/application/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase7', 'route' => '/selection/phase7/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase7', 'route' => '/selection/phase7/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase7', 'route' => '/selection/phase7/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar dublicate  Phase7', 'route' => '/selection/phase7/application/dublicate', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'BC Selection', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Report', 'route' => '/selection/dashboard/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi List', 'route' => '/selection/data/application/list', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC Sakhi View', 'route' => '/selection/data/application/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Single application', 'route' => '/selection/data/application/singleapplication', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Person Highest score', 'route' => '/selection/data/application/highestscore', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graphs', 'route' => '/selection/dashboard/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Select', 'route' => '/selection/data/application/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP where Selection Completed', 'route' => '/selection/dashboard/report/selected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Missing BC', 'route' => '/selection/missing', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Missing BC', 'route' => '/selection/missing/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Map Missing BC', 'route' => '/selection/missing/map', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Comment Missing BC', 'route' => '/selection/missing/comment', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Map Missing BC View', 'route' => '/selection/missing/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Map Missing BC Download', 'route' => '/selection/missing/download', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Duplicacy GP Same', 'route' => '/selection/aadhardublicacy/gpsame', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Duplicacy GP not Same', 'route' => '/selection/aadhardublicacy/gpnotsame', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Currently Vacant GP', 'route' => '/selection/gp/vacant', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwillinglist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
                // ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC', 'route' => '/training/participants/assignshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Return BMMU For SHG Add', 'route' => '/training/participants/returnforshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Update Bank Detail SHG', 'route' => '/training/participants/updateshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Verify BC/SHG Bank Account detail', 'route' => '/training/participants/verification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PFMS & Payment', 'route' => '/training/participants/pfmspayment', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                [
                    'title' => 'MD', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Validation of Deliverables', 'route' => '/md/validation', 'visible' => 1],
                        ['title' => 'Validation of Deliverables', 'route' => '/md/validation/index', 'visible' => 1],
                        ['title' => 'Validation of Deliverables framwork', 'route' => '/md/validation/framework', 'visible' => 1],
                    ],
                ],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/payment', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC-PFMS mapping', 'route' => '/training/participants/bcpfmsmapping', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Saree view', 'route' => '/training/saree/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_DIRECTOR_RURAL_DD => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'BMMU Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Update your profile', 'route' => '/profile/update', 'visible' => 1, 'icon' => 'fa fa-edit'],
                        ['title' => 'View your profile', 'route' => '/profile/view', 'visible' => 1, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registration', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registrationblock', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Daily Activity SHG BMMU', 'route' => '/shg/report/daily', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Daily Activity SHG Verifier', 'route' => '/shg/report/dailyv', 'visible' => 1, 'icon' => 'fa fa-download'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_DM => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Urban', 'route' => '/vo/default/urban', 'visible' => 1, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'BMMU Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Update your profile', 'route' => '/profile/update', 'visible' => 1, 'icon' => 'fa fa-edit'],
                        ['title' => 'View your profile', 'route' => '/profile/view', 'visible' => 1, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registration', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registrationblock', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Daily Activity SHG BMMU', 'route' => '/shg/report/daily', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Daily Activity SHG Verifier', 'route' => '/shg/report/dailyv', 'visible' => 1, 'icon' => 'fa fa-download'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_DC_NRLM => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Partneragencies', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates', 'visible' => 1],
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates/index', 'visible' => 1],
                        ['title' => 'View Field Associates', 'route' => '/partneragencies/associates/view', 'visible' => 1],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
                //['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Upload PVR', 'route' => '/training/participants/uploadpvr', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Add Beneficiaries code', 'route' => '/training/participants/beneficiaries', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Add BC Beneficiaries code', 'route' => '/training/participants/bcbeneficiaries', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC-PFMS mapping', 'route' => '/training/participants/bcpfmsmapping', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Provided Saree Form to BCs', 'route' => '/training/saree/provided', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Provided Saree CSV UPload Form to BCs', 'route' => '/training/saree/upload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Sample CSV File', 'route' => '/training/saree/sample', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Saree view', 'route' => '/training/saree/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Upload CSV BC BC Beneficiaries code replace file', 'route' => '/training/participants/importbcpfms', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Urban', 'route' => '/vo/default/urban', 'visible' => 1, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'BMMU Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Update your profile', 'route' => '/profile/update', 'visible' => 1, 'icon' => 'fa fa-edit'],
                        ['title' => 'View your profile', 'route' => '/profile/view', 'visible' => 1, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registration', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registrationblock', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Daily Activity SHG BMMU', 'route' => '/shg/report/daily', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Daily Activity SHG Verifier', 'route' => '/shg/report/dailyv', 'visible' => 1, 'icon' => 'fa fa-download'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_CDO => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/cdounwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/participants/cdounwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
                //['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Upload PVR', 'route' => '/training/participants/uploadpvr', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Add Beneficiaries code', 'route' => '/training/participants/beneficiaries', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'BMMU Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Update your profile', 'route' => '/profile/update', 'visible' => 1, 'icon' => 'fa fa-edit'],
                        ['title' => 'View your profile', 'route' => '/profile/view', 'visible' => 1, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registration', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registrationblock', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Daily Activity SHG BMMU', 'route' => '/shg/report/daily', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Daily Activity SHG Verifier', 'route' => '/shg/report/dailyv', 'visible' => 1, 'icon' => 'fa fa-download'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_BDO => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_BMMU => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC View', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Add', 'route' => '/shg/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Update', 'route' => '/shg/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Member Verification BMMU', 'route' => '/shg/default/memberverificaton', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/vo/default/urban', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'Add', 'route' => '/vo/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'Add Samuh Sakhi', 'route' => '/vo/default/samuhsakhi', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Update', 'route' => '/vo/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Add Member', 'route' => '/vo/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Add', 'route' => '/clf/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Update', 'route' => '/clf/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Add Member', 'route' => '/clf/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'BMMU Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Update your profile', 'route' => '/profile/update', 'visible' => 1, 'icon' => 'fa fa-edit'],
                        ['title' => 'View your profile', 'route' => '/profile/view', 'visible' => 1, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg', 'visible' => 1],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/index', 'visible' => 0],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/return', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/bc/noshg/assignshg', 'visible' => 0],
                        ['title' => 'BC Certified', 'route' => '/bc/certified', 'visible' => 1],
                        ['title' => 'BC Certified', 'route' => '/bc/certified/index', 'visible' => 0],
                        ['title' => 'GP SHG', 'route' => '/bc/certified/shg', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'WADA', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'WADA Samuh Sakhi list', 'route' => '/wada/samuhsakhi', 'visible' => 1],
                        ['title' => 'WADA Samuh Sakhi list', 'route' => '/wada/samuhsakhi/index', 'visible' => 0],
                        ['title' => 'WSS Band detail verify', 'route' => '/wada/samuhsakhi/veryfywadabank', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_DMMU => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC View', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'verify', 'route' => '/shg/default/verify', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Update', 'route' => '/shg/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/vo/default/urban', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'verify', 'route' => '/vo/default/verify', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Update', 'route' => '/vo/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Add Member', 'route' => '/vo/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Add', 'route' => '/clf/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Update', 'route' => '/clf/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Add Member', 'route' => '/clf/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg', 'visible' => 1],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/index', 'visible' => 0],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/return', 'visible' => 0],
                        ['title' => 'BC Certified', 'route' => '/bc/certified', 'visible' => 1],
                        ['title' => 'BC Certified', 'route' => '/bc/certified/index', 'visible' => 0],
                        ['title' => 'GP SHG', 'route' => '/bc/certified/shg', 'visible' => 0],
                        ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 0],
                        ['title' => 'Certified View', 'route' => '/bc/certified/bankstatus', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'BMMU Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Update your profile', 'route' => '/profile/update', 'visible' => 1, 'icon' => 'fa fa-edit'],
                        ['title' => 'View your profile', 'route' => '/profile/view', 'visible' => 1, 'icon' => 'fa fa-eye'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_SMMU => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC View', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        //['title' => 'Add', 'route' => '/shg/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    //['title' => 'Update', 'route' => '/shg/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/vo/default/urban', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        //['title' => 'Add', 'route' => '/vo/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        //['title' => 'Update', 'route' => '/vo/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Add Member', 'route' => '/vo/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        //['title' => 'Add', 'route' => '/clf/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        //['title' => 'Update', 'route' => '/clf/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Add Member', 'route' => '/clf/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg', 'visible' => 1],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/index', 'visible' => 0],
                        ['title' => 'BC Certified', 'route' => '/bc/certified', 'visible' => 1],
                        ['title' => 'BC Certified', 'route' => '/bc/certified/index', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_WADA_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1],
//                ['title' => 'Dashboard', 'route' => '/dashboard/default/completecsv', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Wada Sakhi Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'WADA Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ULTRA_POOR_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Hhs view', 'route' => '/data/survey/view', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs view', 'route' => '/data/survey/index', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report district', 'route' => '/report/hhs/district', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report block', 'route' => '/report/hhs/block', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report GP', 'route' => '/report/hhs/gp', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Agent progress', 'route' => '/report/agent/progress', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Agent progress detail', 'route' => '/report/agent/calldetail', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Call Audio', 'route' => '/report/agent/telecalleraudio', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_YOUNG_PROFESSIONAL => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call1 update', 'route' => '/selection/preselected/call1update', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update BC Name', 'route' => '/selection/preselected/bcnameupdate', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'verify', 'route' => '/shg/default/verify', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'verify', 'route' => '/shg/verify', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Urban', 'route' => '/vo/default/urban', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'Samuh Sakhi verifiction', 'route' => '/vo/default/verifysamuhsakhi', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Update your profile', 'route' => '/profile/update', 'visible' => 1, 'icon' => 'fa fa-edit'],
                        ['title' => 'View your profile', 'route' => '/profile/view', 'visible' => 1, 'icon' => 'fa fa-eye'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_RISHTASUPPORT_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg//default/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback Report', 'route' => '/shg/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'VO List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO List', 'route' => '/vo/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO List', 'route' => '/vo/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Samuh Sakhi verifiction', 'route' => '/vo/default/verifysamuhsakhi', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CLF List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF member', 'route' => '/clf/default/member', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF make user', 'route' => '/clf/default/makeuser', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO User', 'route' => '/user/cbo', 'visible' => 1, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BLock', 'route' => '/ajaxbc/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajaxbc/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajaxbc/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BLock', 'route' => '/ajax/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajax/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajax/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_RSETIS_STATE_UNIT => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call trainees; get consent for training', 'route' => '/training/preselected/agree', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Reset Agree', 'route' => '/training/preselected/reset', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add Batch training', 'route' => '/training/preselected/addbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update BC Name', 'route' => '/training/preselected/bcnameupdate', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/training/preselected/alreadycertified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update Training', 'route' => '/training/training/update', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Remove Training', 'route' => '/training/training/remove', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Conclude Training Batch', 'route' => '/training/training/conclude', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Upload Group photo', 'route' => '/training/training/uploadgroupphoto', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'inbatch', 'route' => '/training/preselected/inbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwillinglist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/training/preselected/ineligible', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/training/preselected/ineligibletemp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible List', 'route' => '/training/preselected/ineligiblelist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/confirm', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Preselected remaining BC Download CSV', 'route' => '/training/preselected/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Remove BC from training batch', 'route' => '/training/participants/remove', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Add score/update status', 'route' => '/training/participants/addscore', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Upload IIBF Certificate photo', 'route' => '/training/participants/uploadiibf', 'visible' => 0, 'icon' => 'fa fa-upload'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Participant Change Batch', 'route' => '/training/participants/changebatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Ineligible', 'route' => '/training/participants/ineligible', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_RSETIS_DISTRICT_UNIT => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call trainees; get consent for training', 'route' => '/training/preselected/agree', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Reset Agree', 'route' => '/training/preselected/reset', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add Batch training', 'route' => '/training/preselected/addbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update BC Name', 'route' => '/training/preselected/bcnameupdate', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/training/preselected/alreadycertified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update Training', 'route' => '/training/training/update', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Remove Training', 'route' => '/training/training/remove', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Conclude Training Batch', 'route' => '/training/training/conclude', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Upload Group photo', 'route' => '/training/training/uploadgroupphoto', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'inbatch', 'route' => '/training/preselected/inbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwillinglist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/training/preselected/ineligible', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/training/preselected/ineligibletemp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible List', 'route' => '/training/preselected/ineligiblelist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/confirm', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Preselected remaining BC Download CSV', 'route' => '/training/preselected/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Remove BC from training batch', 'route' => '/training/participants/remove', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Add score/update status', 'route' => '/training/participants/addscore', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Upload IIBF Certificate photo', 'route' => '/training/participants/uploadiibf', 'visible' => 0, 'icon' => 'fa fa-upload'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Participant Change Batch', 'route' => '/training/participants/changebatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Ineligible', 'route' => '/training/participants/ineligible', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_RSETIS_BATCH_CREATOR => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Call request', 'route' => '/call/request', 'visible' => 0],
                ['title' => 'Call request upsrlmstatus', 'route' => '/call/upsrlmstatus', 'visible' => 0],
//                [
//                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
//                    'children' => [
//                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
//                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
//                    ],
//                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call trainees; get consent for training', 'route' => '/training/preselected/agree', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call trainees; get consent for training', 'route' => '/training/preselected/call', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Reset Agree', 'route' => '/training/preselected/reset', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add Batch training', 'route' => '/training/preselected/addbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update Training', 'route' => '/training/training/update', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwillinglist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/training/preselected/ineligible', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/training/preselected/ineligibletemp', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible List', 'route' => '/training/preselected/ineligiblelist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_RSETIS_NODAL_BANK => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'inbatch', 'route' => '/training/preselected/inbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwillinglist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_UPSRLM_RSETI_ANCHOR => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add training participants/ form batch', 'route' => '/training/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'inbatch', 'route' => '/training/preselected/inbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis Unwilling', 'route' => '/training/preselected/unwillinglist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible List', 'route' => '/training/preselected/ineligiblelist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Confirm Education Eligibility', 'route' => '/training/educationeligibility/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_BANK_DISTRICT_UNIT => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling', 'route' => '/training/participants/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Mobile In used', 'route' => '/training/preselected/mobileinuse', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Mobile In used download', 'route' => '/training/preselected/mobileinusedownload', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Add Mobile No', 'route' => '/training/preselected/addmobileno', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Bank Detail', 'route' => '/training/participants/onboarding', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PAN Card Status', 'route' => '/training/participants/pancard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Handheld Machine provided', 'route' => '/training/participants/handheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Update bc mobile no', 'route' => '/training/participants/updatemobileno', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Onboard batch CSV', 'route' => '/training/participants/importonboard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Import Pan Available CSV', 'route' => '/training/participants/importpan', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Import Hand Held Machine CSV', 'route' => '/training/participants/importhandheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Sample CSV', 'route' => '/training/participants/sample', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Download Import CSV', 'route' => '/training/participants/importfile', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Paytm', 'route' => '/training/participants/paytm', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                [
                    'title' => 'Partneragencies', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates', 'visible' => 1],
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates/index', 'visible' => 1],
                        ['title' => 'Add Field Associates', 'route' => '/partneragencies/associates/create', 'visible' => 1],
                        ['title' => 'Update Field Associates', 'route' => '/partneragencies/associates/update', 'visible' => 1],
                        ['title' => 'Remove Field Associates', 'route' => '/partneragencies/associates/remove', 'visible' => 1],
                        ['title' => 'View Field Associates', 'route' => '/partneragencies/associates/view', 'visible' => 1],
                        ['title' => 'Manage User', 'route' => '/partneragencies/user', 'visible' => 1],
                        ['title' => 'Manage User', 'route' => '/partneragencies/user/index', 'visible' => 1],
                        ['title' => 'Add User', 'route' => '/partneragencies/user/add', 'visible' => 1],
                        ['title' => 'Update User', 'route' => '/partneragencies/user/update', 'visible' => 1],
                        ['title' => 'Manage Add Corporate BC', 'route' => '/partneragencies/user/bankfipcorporatebc', 'visible' => 1],
                        ['title' => 'Add Corporate BC', 'route' => '/partneragencies/user/addcorporatebcs', 'visible' => 1],
                        ['title' => 'Update Corporate BC', 'route' => '/partneragencies/user/updatebankfipcorpratebc', 'visible' => 1],
                        ['title' => 'Block User', 'route' => '/partneragencies/user/block', 'visible' => 1],
                        ['title' => 'Resetpassword User', 'route' => '/partneragencies/user/resetpassword', 'visible' => 1],
                        ['title' => 'Switch User', 'route' => '/partneragencies/user/switch', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning/index', 'visible' => 1],
                        ['title' => 'Planning Weekly', 'route' => '/partneragencies/planning/weekly', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction/index', 'visible' => 1],
                        ['title' => 'BC Transaction w/o BC Id', 'route' => '/partneragencies/transaction/wobcid', 'visible' => 1],
                        ['title' => 'BC Transaction w/o BC Id', 'route' => '/partneragencies/transaction/wouniquebcid', 'visible' => 1],
                        ['title' => 'BC Transaction w/o BC Id download', 'route' => '/partneragencies/transaction/downloadwobcid', 'visible' => 1],
                        ['title' => 'BC Transaction Sample CSV', 'route' => '/partneragencies/transaction/sample', 'visible' => 1],
                        ['title' => 'BC Transaction Import', 'route' => '/partneragencies/transaction/import', 'visible' => 1],
                        ['title' => 'BC Transaction Import file', 'route' => '/partneragencies/transaction/importfile', 'visible' => 1],
                        ['title' => 'BC Transaction Error file', 'route' => '/partneragencies/transaction/errorfile', 'visible' => 1],
                        ['title' => 'BC Transaction Error', 'route' => '/partneragencies/transaction/errordetail', 'visible' => 1],
                        ['title' => 'BC Transaction Monthly', 'route' => '/partneragencies/transaction/report', 'visible' => 1],
                        ['title' => 'BC Transaction Download', 'route' => '/partneragencies/transaction/dailydownload', 'visible' => 1],
                        ['title' => 'BC Transaction Bank report', 'route' => '/partneragencies/transaction/bankreport', 'visible' => 1],
                        ['title' => 'BC Transaction primary reports', 'route' => '/partneragencies/transaction/primaryreport', 'visible' => 1],
                        ['title' => 'BC Transaction secondary report', 'route' => '/partneragencies/transaction/secondaryreport', 'visible' => 1],
                        ['title' => 'Overall Performance BCS', 'route' => '/partneragencies/bc/overallperformance', 'visible' => 1],
                        ['title' => 'Daily Performance BCS', 'route' => '/partneragencies/bc/dailyperformance', 'visible' => 1],
                        ['title' => 'Monthly Performance BCS', 'route' => '/partneragencies/bc/monthlyperformance', 'visible' => 1],
                        ['title' => 'Weekly Performance BCS', 'route' => '/partneragencies/bc/weeklyperformance', 'visible' => 1],
                        ['title' => 'GP IN', 'route' => '/partneragencies/gp/in', 'visible' => 1],
                        ['title' => 'GP OUT', 'route' => '/partneragencies/gp/out', 'visible' => 1],
                        ['title' => 'GP Onboard', 'route' => '/partneragencies/gp/onboarding', 'visible' => 1],
                        ['title' => 'Confirm Bank', 'route' => '/training/participants/confirmbank', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/report/partneragencies', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/report/partneragencies/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Onboarding', 'route' => '/report/partneragencies/onboarding', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PAN Card Status', 'route' => '/report/partneragencies/pancard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Handheld Machine provided', 'route' => '/report/partneragencies/handheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling', 'route' => '/training/participants/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Mobile In used', 'route' => '/training/preselected/mobileinuse', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Mobile In used download', 'route' => '/training/preselected/mobileinusedownload', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Add Mobile No', 'route' => '/training/preselected/addmobileno', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Partneragencies', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates', 'visible' => 1],
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates/index', 'visible' => 1],
                        ['title' => 'Add Field Associates', 'route' => '/partneragencies/associates/create', 'visible' => 1],
                        ['title' => 'View Field Associates', 'route' => '/partneragencies/associates/view', 'visible' => 1],
                        ['title' => 'Update Field Associates', 'route' => '/partneragencies/associates/update', 'visible' => 1],
                        ['title' => 'Remove Field Associates', 'route' => '/partneragencies/associates/remove', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning/index', 'visible' => 1],
                        ['title' => 'Planning Weekly', 'route' => '/partneragencies/planning/weekly', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction/index', 'visible' => 1],
                        ['title' => 'BC Transaction Sample CSV', 'route' => '/partneragencies/transaction/sample', 'visible' => 1],
                        ['title' => 'BC Transaction Monthly', 'route' => '/partneragencies/transaction/report', 'visible' => 1],
                        ['title' => 'BC Transaction Download', 'route' => '/partneragencies/transaction/dailydownload', 'visible' => 1],
                        ['title' => 'BC Transaction Bank report', 'route' => '/partneragencies/transaction/bankreport', 'visible' => 1],
                        ['title' => 'BC Transaction Error file', 'route' => '/partneragencies/transaction/errorfile', 'visible' => 1],
                        ['title' => 'BC Transaction Error', 'route' => '/partneragencies/transaction/errordetail', 'visible' => 1],
                        ['title' => 'BC Transaction Import file', 'route' => '/partneragencies/transaction/importfile', 'visible' => 1],
                        ['title' => 'Overall Performance BCS', 'route' => '/partneragencies/bc/overallperformance', 'visible' => 1],
                        ['title' => 'GP IN', 'route' => '/partneragencies/gp/in', 'visible' => 1],
                        ['title' => 'GP OUT', 'route' => '/partneragencies/gp/out', 'visible' => 1],
                        ['title' => 'Select GP', 'route' => '/partneragencies/gp/ajaxupdate', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/report/partneragencies', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/report/partneragencies/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Onboarding', 'route' => '/report/partneragencies/onboarding', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PAN Card Status', 'route' => '/report/partneragencies/pancard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Handheld Machine provided', 'route' => '/report/partneragencies/handheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Bank Detail', 'route' => '/training/participants/onboarding', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PAN Card Status', 'route' => '/training/participants/pancard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Handheld Machine provided', 'route' => '/training/participants/handheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Update bc mobile no', 'route' => '/training/participants/updatemobileno', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Onboard batch CSV', 'route' => '/training/participants/importonboard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Import Pan Available CSV', 'route' => '/training/participants/importpan', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Import Hand Held Machine CSV', 'route' => '/training/participants/importhandheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Sample CSV', 'route' => '/training/participants/sample', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Download Import CSV', 'route' => '/training/participants/importfile', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Confirm Bank', 'route' => '/training/participants/confirmbank', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_CORPORATE_BCS => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling', 'route' => '/training/participants/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Mobile In used', 'route' => '/training/preselected/mobileinuse', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Mobile In used download', 'route' => '/training/preselected/mobileinusedownload', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Add Mobile No', 'route' => '/training/preselected/addmobileno', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Partneragencies', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates', 'visible' => 1],
                        ['title' => 'Field Associates', 'route' => '/partneragencies/associates/index', 'visible' => 1],
                        ['title' => 'Add Field Associates', 'route' => '/partneragencies/associates/create', 'visible' => 1],
                        ['title' => 'View Field Associates', 'route' => '/partneragencies/associates/view', 'visible' => 1],
                        ['title' => 'Update Field Associates', 'route' => '/partneragencies/associates/update', 'visible' => 1],
                        ['title' => 'Remove Field Associates', 'route' => '/partneragencies/associates/remove', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning', 'visible' => 1],
                        ['title' => 'Planning', 'route' => '/partneragencies/planning/index', 'visible' => 1],
                        ['title' => 'Planning Weekly', 'route' => '/partneragencies/planning/weekly', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction', 'visible' => 1],
                        ['title' => 'BC Transaction', 'route' => '/partneragencies/transaction/index', 'visible' => 1],
                        ['title' => 'BC Transaction Sample CSV', 'route' => '/partneragencies/transaction/sample', 'visible' => 1],
                        ['title' => 'BC Transaction Monthly', 'route' => '/partneragencies/transaction/report', 'visible' => 1],
                        ['title' => 'BC Transaction Download', 'route' => '/partneragencies/transaction/dailydownload', 'visible' => 1],
                        ['title' => 'BC Transaction Bank report', 'route' => '/partneragencies/transaction/bankreport', 'visible' => 1],
                        ['title' => 'BC Transaction Error file', 'route' => '/partneragencies/transaction/errorfile', 'visible' => 1],
                        ['title' => 'BC Transaction Error', 'route' => '/partneragencies/transaction/errordetail', 'visible' => 1],
                        ['title' => 'BC Transaction Import file', 'route' => '/partneragencies/transaction/importfile', 'visible' => 1],
                        ['title' => 'Overall Performance BCS', 'route' => '/partneragencies/bc/overallperformance', 'visible' => 1],
                        ['title' => 'GP IN', 'route' => '/partneragencies/gp/in', 'visible' => 1],
                        ['title' => 'GP OUT', 'route' => '/partneragencies/gp/out', 'visible' => 1],
                        ['title' => 'Select GP', 'route' => '/partneragencies/gp/ajaxupdate', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/report/partneragencies', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/report/partneragencies/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Onboarding', 'route' => '/report/partneragencies/onboarding', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PAN Card Status', 'route' => '/report/partneragencies/pancard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Handheld Machine provided', 'route' => '/report/partneragencies/handheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Bank Detail', 'route' => '/training/participants/onboarding', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PAN Card Status', 'route' => '/training/participants/pancard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Handheld Machine provided', 'route' => '/training/participants/handheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Update bc mobile no', 'route' => '/training/participants/updatemobileno', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Onboard batch CSV', 'route' => '/training/participants/importonboard', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Import Pan Available CSV', 'route' => '/training/participants/importpan', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Import Hand Held Machine CSV', 'route' => '/training/participants/importhandheldmachine', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Sample CSV', 'route' => '/training/participants/sample', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Download Import CSV', 'route' => '/training/participants/importfile', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Confirm Bank', 'route' => '/training/participants/confirmbank', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_CBO_USER => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_WADA_ADMIN => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Dashboard', 'route' => '/clf/dashboard/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registration', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'CBO Registration', 'route' => '/shg/report/registrationblock', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Daily Activity SHG BMMU', 'route' => '/shg/report/daily', 'visible' => 1, 'icon' => 'fa fa-download'],
                        ['title' => 'Daily Activity SHG Verifier', 'route' => '/shg/report/dailyv', 'visible' => 1, 'icon' => 'fa fa-download'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg', 'visible' => 1],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/index', 'visible' => 0],
                        ['title' => 'BC No SHG', 'route' => '/bc/noshg/return', 'visible' => 0],
                        ['title' => 'BC Certified', 'route' => '/bc/certified', 'visible' => 1],
                        ['title' => 'BC Certified', 'route' => '/bc/certified/index', 'visible' => 0],
                        ['title' => 'GP SHG', 'route' => '/bc/certified/shg', 'visible' => 0],
                        ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 0],
                        ['title' => 'Certified View', 'route' => '/bc/certified/bankstatus', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_WADA_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1],
//                ['title' => 'Dashboard', 'route' => '/dashboard/default/completecsv', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Wada Sakhi Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'WADA Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_WADA_VIEWER => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_WADA_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'Wada Sakhi Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'WADA Application - Dashboard', 'route' => '/selection/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'WADA Application', 'route' => '/selection/application/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_BACKEND_OPERATOR => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SRLM - BC Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                    ],
                ],
                [
                    'title' => 'BC Selection', 'route' => '#', 'visible' => 1,
                    'children' => [
                    ],
                ],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call1 update', 'route' => '/selection/preselected/call1update', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update BC Name', 'route' => '/selection/preselected/bcnameupdate', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible List', 'route' => '/selection/preselected/ineligiblelist', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Ineligible', 'route' => '/selection/preselected/ineligible', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Call trainees; get consent for training', 'route' => '/training/preselected/agree', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Pre Selected', 'route' => '/training/preselected/alreadycertified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update Training', 'route' => '/training/training/update', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Remove Training', 'route' => '/training/training/remove', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Conclude Training Batch', 'route' => '/training/training/conclude', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Upload Group photo', 'route' => '/training/training/uploadgroupphoto', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC', 'route' => '/training/participants/assignshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Return BMMU For SHG Add', 'route' => '/training/participants/returnforshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Update Bank Detail SHG', 'route' => '/training/participants/updateshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Verify BC/SHG Bank Account detail', 'route' => '/training/participants/verification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PFMS Payment', 'route' => '/training/participants/pfmspayment', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                //['title' => 'Revert PFMS', 'route' => '/training/participants/beneficiariesrevert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Participant Change Batch', 'route' => '/training/participants/changebatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Urban', 'route' => '/shg/default/urban', 'visible' => 0, 'icon' => 'fa fa-list'],
                        //['title' => 'Add', 'route' => '/shg/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    //['title' => 'Update', 'route' => '/shg/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        //['title' => 'Add', 'route' => '/vo/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'View', 'route' => '/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        //['title' => 'Update', 'route' => '/vo/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Add Member', 'route' => '/vo/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        //['title' => 'Add', 'route' => '/clf/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                        ['title' => 'View', 'route' => '/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        //['title' => 'Update', 'route' => '/clf/default/update', 'visible' => 0, 'icon' => 'fa fa-edit'],
                        ['title' => 'Add Member', 'route' => '/clf/default/itemrow', 'visible' => 0, 'icon' => 'fa fa-plus'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'BC Certified', 'route' => '/bc/certified', 'visible' => 1],
                        ['title' => 'BC Certified', 'route' => '/bc/certified/index', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/bc/certified/assignshg', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg//default/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CLF List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF member', 'route' => '/clf/default/member', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF make user', 'route' => '/clf/default/makeuser', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Certified', 'route' => '/bc/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified', 'route' => '/bc/certified/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register View', 'route' => '/bc/register/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Download', 'route' => '/bc/certified/csvdownload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank status', 'route' => '/bc/certified/bankstatus', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC GP SHG List', 'route' => '/bc/default/shg', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Magnot Certified BC ', 'route' => '/bc/rsetis', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Magnot Certified BC ', 'route' => '/bc/rsetis/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Add Magnot Certified BC ', 'route' => '/bc/rsetis/add', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Update Magnot Certified BC ', 'route' => '/bc/rsetis/update', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BLock', 'route' => '/ajaxbc/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajaxbc/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajaxbc/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BLock', 'route' => '/ajax/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajax/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajax/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_SPM_FI_MF => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SRLM - BC Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'GP Phase2', 'route' => '/selection/phase2/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase2', 'route' => '/selection/phase2/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase2', 'route' => '/selection/phase2/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase2', 'route' => '/selection/phase3/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase2', 'route' => '/selection/phase3/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase2', 'route' => '/selection/phase3/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase4', 'route' => '/selection/phase4/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase4', 'route' => '/selection/phase4/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase4', 'route' => '/selection/phase4/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase5', 'route' => '/selection/phase5/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase5', 'route' => '/selection/phase5/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase5', 'route' => '/selection/phase5/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase6', 'route' => '/selection/phase6/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase6', 'route' => '/selection/phase6/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase6', 'route' => '/selection/phase6/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP Phase7', 'route' => '/selection/phase7/application/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP pdf Phase7', 'route' => '/selection/phase7/application/pdfgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP csv Phase7', 'route' => '/selection/phase7/application/csvgp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'BC Selection', 'route' => '#', 'visible' => 1,
                    'children' => [
                    ],
                ],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Unwillig', 'route' => '/training/certified/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Verify BC/SHG Bank Account detail', 'route' => '/training/participants/verification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Verify BC/SHG Bank Account detail', 'route' => '/training/participants/veryfybcshgbank', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC SHG MAP PFMS', 'route' => '/training/participants/mappfms', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Certified BC Assin SHG', 'route' => '/training/participants/assignshg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC provided saree list to BCs', 'route' => '/training/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Provided Saree Form to BCs', 'route' => '/training/saree/provided', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Provided Saree CSV UPload Form to BCs', 'route' => '/training/saree/upload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Sample CSV File', 'route' => '/training/saree/sample', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_SPM_FINANCE => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SRLM - BC Application', 'route' => '#', 'visible' => 1,
                    'children' => [
                    ],
                ],
                [
                    'title' => 'BC Selection', 'route' => '#', 'visible' => 1,
                    'children' => [
                    ],
                ],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Urban', 'route' => '/selection/preselected/urban', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadharduplicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified PFMS without bank verification', 'route' => '/training/preselected/pfmswobankverification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified SHG GP change', 'route' => '/training/preselected/bcshggpchange', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Blocked', 'route' => '/training/certified/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank Unwilling', 'route' => '/training/certified/bankunwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
//                ['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Revert BC SHG Mapping', 'route' => '/training/participants/shgrevert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC SHG MAP PFMS', 'route' => '/training/participants/mappfms', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Verify BC/SHG Bank Account detail', 'route' => '/training/participants/verification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Revert Bank Verification', 'route' => '/training/participants/revert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'PFMS & Payment', 'route' => '/training/participants/pfmspayment', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Revert BC SHG funds transfer', 'route' => '/training/participants/mappfmsrevert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Revert PFMS', 'route' => '/training/participants/beneficiariesrevert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC-PFMS mapping', 'route' => '/training/participants/bcpfmsmapping', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Rever BC-PFMS mapping', 'route' => '/training/participants/bcbeneficiariesrevert', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/payment', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs', 'route' => '/training/honorarium/upload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Honorarium payment to BCs download', 'route' => '/training/honorarium/downloadcsv', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Blocke BC Form', 'route' => '/training/participants/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_SUPPORT_UNIT => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'BMMU', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/dashboard/index', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Feedback', 'route' => '/shg/feedback/index', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/view', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback', 'route' => '/shg/feedback/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-list'],
//                        ['title' => 'Feedback Report', 'route' => '/shg/feedback/report', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Chairperson verifiction', 'route' => '/shg/default/verifychairperson', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Secretary verifiction', 'route' => '/shg/default/verifysecretary', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'Treasurer verifiction', 'route' => '/shg/default/verifytreasurer', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'VO List', 'route' => '/vo', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO List', 'route' => '/vo/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO List', 'route' => '/vo/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'VO View', 'route' => '/vo/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Samuh Sakhi verifiction', 'route' => '/vo/default/verifysamuhsakhi', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'CLF', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CLF List', 'route' => '/clf', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF List', 'route' => '/clf/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF View', 'route' => '/clf/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF member', 'route' => '/clf/default/member', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF make user', 'route' => '/clf/default/makeuser', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/index', 'visible' => 1, 'icon' => 'fa fa-globe'],
                        ['title' => 'CLF Feedback', 'route' => '/clf/feedback/view', 'visible' => 1, 'icon' => 'fa fa-globe'],
                    ],
                ],
                [
                    'title' => 'BC', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Certified', 'route' => '/bc/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified', 'route' => '/bc/certified/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified View', 'route' => '/bc/certified/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register', 'route' => '/bc/register/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Register View', 'route' => '/bc/register/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Download', 'route' => '/bc/certified/csvdownload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Preselected Download', 'route' => '/bc/register/csvdownload', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Certified Bank status', 'route' => '/bc/certified/bankstatus', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC GP SHG List', 'route' => '/bc/default/shg', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling list', 'route' => '/bc/unwilling/call', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling after certified', 'route' => '/bc/unwilling/certified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Unwilling after certified action', 'route' => '/bc/unwilling/callcertified', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC provided saree list to BCs', 'route' => '/bc/saree', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC provided saree list to BCs', 'route' => '/bc/saree/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Provided Saree Form to BCs', 'route' => '/bc/saree/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Honorarium payment to BCs', 'route' => '/bc/honorarium/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'User', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'CBO User', 'route' => '/user/cbo', 'visible' => 1, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'Rishta', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BC SAKHI List', 'route' => '/rishta/bc', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BC SAKHI List', 'route' => '/rishta/bc/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'SHG WSS', 'route' => '/rishta/shg/wss', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'SHG Office bearers', 'route' => '/rishta/shg/officebearers', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Rsetis', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Rsetis pendency', 'route' => '/rsetis/pendency', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis pendency', 'route' => '/rsetis/pendency/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'RSETIs District Unit', 'route' => '/rsetis/user', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'RSETIs District Unit', 'route' => '/rsetis/user/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis batch create', 'route' => '/rsetis/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Rsetis batch create', 'route' => '/rsetis/preselected/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BLock', 'route' => '/ajaxbc/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajaxbc/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajaxbc/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'BLock', 'route' => '/ajax/block', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'GP', 'route' => '/ajax/gp', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Village', 'route' => '/ajax/village', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_VIEWER => [
            WebApplication::WEB_APP_BC_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BC Shortlisted', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Pre Selected', 'route' => '/selection/preselected', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Graph', 'route' => '/selection/preselected/graph', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download list for verification', 'route' => '/selection/preselected/bcdata', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report CSV Download', 'route' => '/selection/preselected/reportcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Report PDF Download', 'route' => '/selection/preselected/reportpdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                [
                    'title' => 'RSETIs Training', 'route' => '#', 'visible' => 1, 'icon' => 'fa fa-dashboard',
                    'children' => [
                        ['title' => 'Dashboard', 'route' => '/training/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training e-calendar', 'route' => '/training/ecalendar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training List', 'route' => '/training/training/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Download CSV', 'route' => '/training/training/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'View Training', 'route' => '/training/training/view', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'PDF', 'route' => '/training/training/pdf', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Get Batch', 'route' => '/training/training/getbatch', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report', 'route' => '/training/report', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Training Report Download CSV', 'route' => '/training/report/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Blocked BC', 'route' => '/training/preselected/blocked', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'Aadhar Dublicacy', 'route' => '/training/preselected/aadhardualicacy', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
                ['title' => 'Progress MIS', 'route' => '/training/participants', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS', 'route' => '/training/participants/index', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Progress MIS Download CSV', 'route' => '/training/participants/downloadcsv', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Candidate Progress view', 'route' => '/training/participants/view', 'visible' => 0, 'icon' => 'fa fa-download'],
                //['title' => 'Candidate Detail view', 'route' => '/training/participants/detail', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Download PVR Form', 'route' => '/training/participants/pdf', 'visible' => 0, 'icon' => 'fa fa-download'],
                ['title' => 'Certified BC', 'route' => '/training/participants/certified', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Guideline', 'route' => '/training/usermanual', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC Notification', 'route' => '/training/participants/notification', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                ['title' => 'BC GP SHG', 'route' => '/training/participants/shg', 'visible' => 0, 'icon' => 'fa fa-dashboard'],
                [
                    'title' => 'MD', 'route' => '#', 'visible' => 0,
                    'children' => [
                    ],
                ],
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
        ],
        MasterRole::ROLE_FRONTIER_MARKET_ADMIN => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_SAHELI_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/cbo/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/cbo/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'View', 'route' => '/cbo/shg/view/index', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/cbo/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/cbo/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'View', 'route' => '/cbo/vo/view/index', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                    [
                        'title' => 'CLF', 'route' => '#', 'visible' => 1,
                        'children' => [
                            ['title' => 'List', 'route' => '/cbo/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                            ['title' => 'List', 'route' => '/cbo/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'List', 'route' => '/cbo/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Add', 'route' => '/cbo/clf/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                            ['title' => 'View', 'route' => '/cbo/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                            ['title' => 'View', 'route' => '/cbo/clf/view/index', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ],
                    ],
                    [
                        'title' => 'BC', 'route' => '#', 'visible' => 0,
                        'children' => [
                            ['title' => 'BC No SHG', 'route' => '/cbo/bc/noshg', 'visible' => 1],
                            ['title' => 'BC No SHG', 'route' => '/cbo/bc/noshg/index', 'visible' => 0],
                            ['title' => 'BC No SHG', 'route' => '/cbo/bc/noshg/return', 'visible' => 0],
                            ['title' => 'BC Certified', 'route' => '/cbo/bc/certified', 'visible' => 1],
                            ['title' => 'BC Certified', 'route' => '/cbo/bc/certified/index', 'visible' => 0],
                            ['title' => 'Certified View', 'route' => '/cbo/bc/certified/view', 'visible' => 0],
                            ['title' => 'Certified View', 'route' => '/cbo/bc/certified/bankstatus', 'visible' => 0],
                        ],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_SAHELI_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'Dashboard', 'route' => '', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'SHG', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/cbo/shg', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/shg/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/shg/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/cbo/shg/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'View', 'route' => '/cbo/shg/view/index', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                ],
                [
                    'title' => 'VO', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'List', 'route' => '/cbo/vo', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/vo/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'List', 'route' => '/cbo/vo/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'View', 'route' => '/cbo/vo/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ['title' => 'View', 'route' => '/cbo/vo/view/index', 'visible' => 0, 'icon' => 'fa fa-eye'],
                    ],
                    [
                        'title' => 'CLF', 'route' => '#', 'visible' => 1,
                        'children' => [
                            ['title' => 'List', 'route' => '/cbo/clf', 'visible' => 1, 'icon' => 'fa fa-list'],
                            ['title' => 'List', 'route' => '/cbo/clf/default', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'List', 'route' => '/cbo/clf/default/index', 'visible' => 0, 'icon' => 'fa fa-list'],
                            ['title' => 'Add', 'route' => '/cbo/clf/default/create', 'visible' => 1, 'icon' => 'fa fa-plus'],
                            ['title' => 'View', 'route' => '/cbo/clf/view', 'visible' => 0, 'icon' => 'fa fa-eye'],
                            ['title' => 'View', 'route' => '/cbo/clf/view/index', 'visible' => 0, 'icon' => 'fa fa-eye'],
                        ],
                    ],
                    [
                        'title' => 'BC', 'route' => '#', 'visible' => 0,
                        'children' => [
                            ['title' => 'BC No SHG', 'route' => '/cbo/bc/noshg', 'visible' => 1],
                            ['title' => 'BC No SHG', 'route' => '/cbo/bc/noshg/index', 'visible' => 0],
                            ['title' => 'BC No SHG', 'route' => '/cbo/bc/noshg/return', 'visible' => 0],
                            ['title' => 'BC Certified', 'route' => '/cbo/bc/certified', 'visible' => 1],
                            ['title' => 'BC Certified', 'route' => '/cbo/bc/certified/index', 'visible' => 0],
                            ['title' => 'Certified View', 'route' => '/cbo/bc/certified/view', 'visible' => 0],
                            ['title' => 'Certified View', 'route' => '/cbo/bc/certified/bankstatus', 'visible' => 0],
                        ],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_ULTRA_POOR_VIEWER => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_WADA_ID => [
            ],
            WebApplication::WEB_APP_ULTRA_POOR_ID => [
                ['title' => 'Dashboard', 'route' => '', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Dashboard', 'route' => '/dashboard/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                ['title' => 'Logout', 'route' => '/site/logout', 'visible' => 1, 'icon' => 'fa fa-log-out'],
                [
                    'title' => 'Report', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'Hhs view', 'route' => '/data/survey/view', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs view', 'route' => '/data/survey/index', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report district', 'route' => '/report/hhs/district', 'visible' => 1, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report block', 'route' => '/report/hhs/block', 'visible' => 0, 'icon' => 'fa fa-list'],
                        ['title' => 'Hhs report GP', 'route' => '/report/hhs/gp', 'visible' => 0, 'icon' => 'fa fa-list'],
                    ],
                ],
                [
                    'title' => 'debug', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'default', 'route' => '/debug/default/toolbar', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default/index', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'default', 'route' => '/debug/default', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                        ['title' => 'view', 'route' => '/debug/default/view', 'visible' => 1, 'icon' => 'fa fa-dashboard'],
                    ],
                ],
            ],
        ],
        MasterRole::ROLE_RBI => [
            WebApplication::WEB_APP_BC_ID => [
            ],
            WebApplication::WEB_APP_CBO_ID => [
            ],
            WebApplication::WEB_APP_ADMIN_ID => [
            ],
            WebApplication::WEB_APP_HR_ID => [
                ['title' => 'Dashboard', 'route' => '/dashboard', 'visible' => 1],
                ['title' => 'Dashboard', 'route' => '/', 'visible' => 0],
                ['title' => 'logout', 'route' => '/site/logout', 'visible' => 0],
                [
                    'title' => 'BMMU Contact', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'BMMU List', 'route' => '/bmmu', 'visible' => 1],
                        ['title' => 'BMMU List', 'route' => '/bmmu/index', 'visible' => 1],
                    ],
                ],
                [
                    'title' => 'Profile', 'route' => '#', 'visible' => 1,
                    'children' => [
                        ['title' => 'View Your Profile', 'route' => '/profile/view', 'visible' => 1],
                        ['title' => 'Update Your Profile', 'route' => '/profile/update', 'visible' => 1],
                        ['title' => 'Upload File', 'route' => '/profile/uploadfile', 'visible' => 0],
                    ],
                ],
                [
                    'title' => 'Ajax', 'route' => '#', 'visible' => 0,
                    'children' => [
                        ['title' => 'Get Block', 'route' => '/ajax/getblock', 'visible' => 0],
                        ['title' => 'Get Block', 'route' => '/ajax/block', 'visible' => 0],
                        ['title' => 'Get GP', 'route' => '/ajax/getgp', 'visible' => 0],
                        ['title' => 'Get village', 'route' => '/ajax/getvillage', 'visible' => 0],
                    ],
                ],
            ],
            WebApplication::WEB_APP_SAKHI_ID => [
            ],
            WebApplication::WEB_APP_SUPPORT_ID => [
            ],
            WebApplication::WEB_APP_WADA_ID => [
            ],
            WebApplication::WEB_APP_ULTRA_POOR_ID => [
            ],
        ],
    ];

    public function init() {
        // Keep original request parsing for backward compatibility
        $this->request = explode('?', Yii::$app->request->url);
        
        // Use pathInfo for routing comparison instead of full URL
        // pathInfo is relative to the app base path and is more suitable for route matching
        $pathInfo = Yii::$app->request->pathInfo;
        $this->request_url = '/' . rtrim($pathInfo, '/');
        if (empty($this->request_url) || $this->request_url === '/') {
            $this->request_url = '/';
        }
        
        if (!Yii::$app->user->isGuest) {
            $this->role = Yii::$app->user->identity->role;
        }
        parent::init();
    }

    public function access() {
        if (!isset(Yii::$app->user->identity) || Yii::$app->user->isGuest) {
            $currentApp = Yii::$app->params['current_app'] ?? null;
            $pathInfo = Yii::$app->request->pathInfo;

            if ($currentApp === 'admin') {
                // Allow the admin login page to render without bouncing to www.
                if ($pathInfo === 'site/login' || $pathInfo === 'site/captcha') {
                    return;
                }

                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['admin'] . '/site/login')->send();
            }

            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard/checksession')->send();
        }


        if (isset(Yii::$app->user->identity)) {
            if (Yii::$app->user->identity->status != User::STATUS_ACTIVE) {
                \Yii::$app->user->logout();
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home');
                exit;
            }

            if (in_array('changepassword', $this->request)) {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/changepassword');
                exit;
            }
        }
    }

    public function redirect() {

        if ($this->role == MasterRole::ROLE_DMMU) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_DC_NRLM) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_CDO) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_BMMU) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_ADMIN) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['admin']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_ULTRA_POOR_VIEWER) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['ultrapoor']);
            exit;
        }
//        if ($this->role == MasterRole::ROLE_SUPER_ADMIN) {
//            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo']);
//            exit;
//        }
        if ($this->role == MasterRole::ROLE_YOUNG_PROFESSIONAL) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_HR_ADMIN) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['hr']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_JMD) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['hr']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_MD) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            //return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo']);

            exit;
        }
        if ($this->role == MasterRole::ROLE_MSC) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            //return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo']);

            exit;
        }
        if ($this->role == MasterRole::ROLE_DM) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_DIVISIONAL_COMMISSIONER) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_RSETIS_STATE_UNIT) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_RSETIS_DISTRICT_UNIT) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/partneragencies');
            exit;
        }
        if ($this->role == MasterRole::ROLE_RSETIS_NODAL_BANK) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            //return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo'].'/shg/report/registration');
            exit;
        }
        if ($this->role == MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/partneragencies');
            //return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo'].'/shg/report/registration');
            exit;
        }
        if ($this->role == MasterRole::ROLE_CORPORATE_BCS) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/partneragencies');
            //return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo'].'/shg/report/registration');
            exit;
        }
        if ($this->role == MasterRole::ROLE_SMMU) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_BACKEND_OPERATOR) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_SPM_FI_MF) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_SPM_FINANCE) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/training/participants/pfmspayment');
            exit;
        }
        if ($this->role == MasterRole::ROLE_BC_VIEWER) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_CBO_USER) {
            if (Yii::$app->user->identity->dummy_column == '1') {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['sakhi'] . '/test');
                exit;
            }
            if (Yii::$app->user->identity->dummy_column == '0') {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www']);
                exit;
            }
        }
        if ($this->role == MasterRole::ROLE_SUPPORT_UNIT) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['support']);
            exit;
        }
        if ($this->role == MasterRole::ROLE_VIEWER) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/training/participants');
            exit;
        }
        if ($this->role == MasterRole::ROLE_UPSRLM_RSETI_ANCHOR) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc']);
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/training/participants');
            exit;
        }
        if ($this->role == MasterRole::ROLE_RSETIS_BATCH_CREATOR) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/training/preselected');

            exit;
        }
        if ($this->role == MasterRole::ROLE_FRONTIER_MARKET_ADMIN) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['saheli']);

            exit;
        }
        if ($this->role == MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['saheli']);

            exit;
        }
        if ($this->role == MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['dbtcallcenter']);

            exit;
        }
        if ($this->role == MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['dbtcallcenter'] . '/dashboard');

            exit;
        }
        if ($this->role == MasterRole::ROLE_WADA_ADMIN) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['wada']);

            exit;
        }
        if ($this->role == MasterRole::ROLE_WADA_VIEWER) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['wada']);

            exit;
        }
        if ($this->role == MasterRole::ROLE_DBT_CALL_CENTER_MANAGER) {
            //return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['callcenter'].'/shg/cst');
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bccallcenter'] . '/dashboard');

            exit;
        }
        if ($this->role == MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE) {
            // return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['callcenter'].'/shg/cst');
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bccallcenter'] . '/bc/certified/igrs');

            exit;
        }
        if ($this->role == MasterRole::ROLE_RBI) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/bc/ac194n');
            exit;
        }
    }

    public function checkaccess($application) {
        if (isset($this->app_role_route[$this->role][$application])) {
            $this->access = $this->element_search($this->app_role_route[$this->role][$application], $this->request_url);
        }
        return $this->access;
    }

    public function recursiveArraySearch($needle, $haystack) {
        foreach ($haystack as $key => $value) {
            if ($key === $needle) {
                return $value;
            } elseif (is_array($value)) {
                $result = $this->recursiveArraySearch($needle, $value);
                if ($result !== false) {
                    return $result;
                }
            }
        }

        return false;
    }

    public function element_search(array $array, $search, $mode = 'value', $return = false) {
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array)) as $key => $value) {
            if ($search === ${${"mode"}}) {
                return $return ? ${${"mode"}} : true;
            }
        }

        return false;
    }
}

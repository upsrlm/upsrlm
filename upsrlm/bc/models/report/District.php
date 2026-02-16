<?php

namespace bc\models\report;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\BcCumulativeReportDistrictSearch;
use bc\models\BcCumulativeReportDistrict;
use yii\helpers\ArrayHelper;

class District extends Model {

    const BASE_DATE = 'Base';
    const BASE_DATES = '2021-07-09';

    public $date_array = [];
    public $date_arrayl = [];
    public $master_partner_bank_id;
    public $district_code;
    public $return_array = [];
    public $district_option = [];
    public $bank_option = [];

    public function __construct($basic_properties = []) {
        $this->load(\Yii::$app->request->queryParams);
    }

    public function rules() {
        return [
            [['district_code', 'master_partner_bank_id'], 'safe'],
        ];
    }

    public function weekly($params = []) {
        $this->load($params);
        $date = new \DateTime('first Monday of this month');
        $thisMonth = $date->format('m');
        while ($date->format('m') === $thisMonth) {
            if (strtotime(self::BASE_DATES) < strtotime($date->format('Y-m-d'))) {
                array_push($this->date_array, $date->format('Y-m-d'));
            }
            $date->modify('next Monday');
        }
        $string = implode(' ,', $this->date_array);

        if (count($this->date_array) == 0) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE,
                self::BASE_DATE,
                self::BASE_DATE,
                self::BASE_DATE,
                self::BASE_DATE,
                self::BASE_DATE,
                self::BASE_DATE,
                self::BASE_DATE,
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);

            $this->return_array[1] = ['', 'Overall', '', BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $model->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 1) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])),
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);

            $this->return_array[1] = ['', 'Overall', '', BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $model->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 2) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])),
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);

            $this->return_array[1] = ['', 'Overall', '', BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $model->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 3) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])),
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = ['', 'Overall', '', BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 4) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])),
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = ['', 'Overall', '', BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $model->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 5) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])), date("M,j", strtotime($this->date_array[4])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])), date("M,j", strtotime($this->date_array[4])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])), date("M,j", strtotime($this->date_array[4])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])), date("M,j", strtotime($this->date_array[4])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])), date("M,j", strtotime($this->date_array[4])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])), date("M,j", strtotime($this->date_array[4])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])), date("M,j", strtotime($this->date_array[4])),
                self::BASE_DATE, date("M,j", strtotime($this->date_array[0])), date("M,j", strtotime($this->date_array[1])), date("M,j", strtotime($this->date_array[2])), date("M,j", strtotime($this->date_array[3])), date("M,j", strtotime($this->date_array[4])),
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $model->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
//         echo "<pre>";
//         print_r($this->return_array);exit;
        return $this;
    }

    public function weeklys($params = []) {
        $this->load($params);

        $this->date_array = $this->getMondaysInRange('2021-07-09', date('Y-m-d'));
        $this->date_arrayl = $this->getMondaysInRangeLabel('2021-07-09', date('Y-m-d'));
//        $this->date_array = $this->getMondaysInRange('2021-07-9', '2021-10-04');
//        $this->date_arrayl = $this->getMondaysInRangeLabel('2021-07-9', '2021-10-04');
        if (count($this->date_array) == 3) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = ['', 'Overall', '', BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 4) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = ['', 'Overall', '', BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'), BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 5) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 6) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel6 = new BcCumulativeReportDistrictSearch();
            $searchModel6->date = $this->date_array[5];
            $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 7) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel6 = new BcCumulativeReportDistrictSearch();
            $searchModel6->date = $this->date_array[5];
            $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel7 = new BcCumulativeReportDistrictSearch();
            $searchModel7->date = $this->date_array[6];
            $dataProvider7 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pvr : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->shg_assigned : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pfms_mapping : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 8) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel6 = new BcCumulativeReportDistrictSearch();
            $searchModel6->date = $this->date_array[5];
            $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel7 = new BcCumulativeReportDistrictSearch();
            $searchModel7->date = $this->date_array[6];
            $dataProvider7 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel8 = new BcCumulativeReportDistrictSearch();
            $searchModel8->date = $this->date_array[7];
            $dataProvider8 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pvr : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pvr : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->shg_assigned : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->shg_assigned : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pfms_mapping : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pfms_mapping : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 9) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel6 = new BcCumulativeReportDistrictSearch();
            $searchModel6->date = $this->date_array[5];
            $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel7 = new BcCumulativeReportDistrictSearch();
            $searchModel7->date = $this->date_array[6];
            $dataProvider7 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel8 = new BcCumulativeReportDistrictSearch();
            $searchModel8->date = $this->date_array[7];
            $dataProvider8 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel9 = new BcCumulativeReportDistrictSearch();
            $searchModel9->date = $this->date_array[8];
            $dataProvider9 = $searchModel9->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pvr : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pvr : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pvr : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->shg_assigned : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->shg_assigned : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->shg_assigned : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pfms_mapping : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pfms_mapping : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pfms_mapping : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 10) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel6 = new BcCumulativeReportDistrictSearch();
            $searchModel6->date = $this->date_array[5];
            $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel7 = new BcCumulativeReportDistrictSearch();
            $searchModel7->date = $this->date_array[6];
            $dataProvider7 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel8 = new BcCumulativeReportDistrictSearch();
            $searchModel8->date = $this->date_array[7];
            $dataProvider8 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel9 = new BcCumulativeReportDistrictSearch();
            $searchModel9->date = $this->date_array[8];
            $dataProvider9 = $searchModel9->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel10 = new BcCumulativeReportDistrictSearch();
            $searchModel10->date = $this->date_array[9];
            $dataProvider10 = $searchModel10->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pvr : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pvr : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pvr : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pvr : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->shg_assigned : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->shg_assigned : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->shg_assigned : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->shg_assigned : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pfms_mapping : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pfms_mapping : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pfms_mapping : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pfms_mapping : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 11) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel6 = new BcCumulativeReportDistrictSearch();
            $searchModel6->date = $this->date_array[5];
            $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel7 = new BcCumulativeReportDistrictSearch();
            $searchModel7->date = $this->date_array[6];
            $dataProvider7 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel8 = new BcCumulativeReportDistrictSearch();
            $searchModel8->date = $this->date_array[7];
            $dataProvider8 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel9 = new BcCumulativeReportDistrictSearch();
            $searchModel9->date = $this->date_array[8];
            $dataProvider9 = $searchModel9->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel10 = new BcCumulativeReportDistrictSearch();
            $searchModel10->date = $this->date_array[9];
            $dataProvider10 = $searchModel10->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel11 = new BcCumulativeReportDistrictSearch();
            $searchModel11->date = $this->date_array[10];
            $dataProvider11 = $searchModel11->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pvr : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pvr : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pvr : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pvr : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->pvr : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->shg_assigned : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->shg_assigned : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->shg_assigned : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->shg_assigned : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->shg_assigned : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pfms_mapping : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pfms_mapping : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pfms_mapping : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pfms_mapping : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->pfms_mapping : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 12) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel6 = new BcCumulativeReportDistrictSearch();
            $searchModel6->date = $this->date_array[5];
            $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel7 = new BcCumulativeReportDistrictSearch();
            $searchModel7->date = $this->date_array[6];
            $dataProvider7 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel8 = new BcCumulativeReportDistrictSearch();
            $searchModel8->date = $this->date_array[7];
            $dataProvider8 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel9 = new BcCumulativeReportDistrictSearch();
            $searchModel9->date = $this->date_array[8];
            $dataProvider9 = $searchModel9->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel10 = new BcCumulativeReportDistrictSearch();
            $searchModel10->date = $this->date_array[9];
            $dataProvider10 = $searchModel10->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel11 = new BcCumulativeReportDistrictSearch();
            $searchModel11->date = $this->date_array[10];
            $dataProvider11 = $searchModel11->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel12 = new BcCumulativeReportDistrictSearch();
            $searchModel12->date = $this->date_array[11];
            $dataProvider12 = $searchModel12->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pvr : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pvr : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pvr : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pvr : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->pvr : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->pvr : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->shg_assigned : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->shg_assigned : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->shg_assigned : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->shg_assigned : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->shg_assigned : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->shg_assigned : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pfms_mapping : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pfms_mapping : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pfms_mapping : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pfms_mapping : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->pfms_mapping : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->pfms_mapping : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
        if (count($this->date_array) == 13) {
            $this->return_array[0] = ['', '', '', '',
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11], $this->date_arrayl[12],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11], $this->date_arrayl[12],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11], $this->date_arrayl[12],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11], $this->date_arrayl[12],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11], $this->date_arrayl[12],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11], $this->date_arrayl[12],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11], $this->date_arrayl[12],
                self::BASE_DATE, $this->date_arrayl[0], $this->date_arrayl[1], $this->date_arrayl[2], $this->date_arrayl[3], $this->date_arrayl[4], $this->date_arrayl[5], $this->date_arrayl[6], $this->date_arrayl[7], $this->date_arrayl[8], $this->date_arrayl[9], $this->date_arrayl[10], $this->date_arrayl[11], $this->date_arrayl[12],
                '',
                ''
            ];
            $model = BcCumulativeReportDistrict::find()->orderBy("date DESC")->limit(1)->one();
            $searchModel = new BcCumulativeReportDistrictSearch();
            $searchModel->date = isset($model) ? $model->date : date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $models = $dataProvider->models;
            $searchModel0 = new BcCumulativeReportDistrictSearch();
            $searchModel0->date = self::BASE_DATES;
            $dataProvider0 = $searchModel0->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel1 = new BcCumulativeReportDistrictSearch();
            $searchModel1->date = $this->date_array[0];
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel2 = new BcCumulativeReportDistrictSearch();
            $searchModel2->date = $this->date_array[1];
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel3 = new BcCumulativeReportDistrictSearch();
            $searchModel3->date = $this->date_array[2];
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel4 = new BcCumulativeReportDistrictSearch();
            $searchModel4->date = $this->date_array[3];
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel5 = new BcCumulativeReportDistrictSearch();
            $searchModel5->date = $this->date_array[4];
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel6 = new BcCumulativeReportDistrictSearch();
            $searchModel6->date = $this->date_array[5];
            $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel7 = new BcCumulativeReportDistrictSearch();
            $searchModel7->date = $this->date_array[6];
            $dataProvider7 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel8 = new BcCumulativeReportDistrictSearch();
            $searchModel8->date = $this->date_array[7];
            $dataProvider8 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel9 = new BcCumulativeReportDistrictSearch();
            $searchModel9->date = $this->date_array[8];
            $dataProvider9 = $searchModel9->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel10 = new BcCumulativeReportDistrictSearch();
            $searchModel10->date = $this->date_array[9];
            $dataProvider10 = $searchModel10->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel11 = new BcCumulativeReportDistrictSearch();
            $searchModel11->date = $this->date_array[10];
            $dataProvider11 = $searchModel11->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel12 = new BcCumulativeReportDistrictSearch();
            $searchModel12->date = $this->date_array[11];
            $dataProvider12 = $searchModel12->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $searchModel13 = new BcCumulativeReportDistrictSearch();
            $searchModel13->date = $this->date_array[12];
            $dataProvider13 = $searchModel12->search(Yii::$app->request->queryParams, Yii::$app->user->identity);
            $this->return_array[1] = [
                '',
                'Overall',
                '',
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'certified_bc'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider13->models, 'pvr'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider13->models, 'shg_assigned'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider13->models, 'bc_shg_bank_verified'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider13->models, 'pfms_mapping'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider13->models, 'bc_support_fund_shg_transfer'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider13->models, 'bc_support_fund_shg_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider13->models, 'handheld_machine_provided'),
                BcCumulativeReportDistrict::getTotal($dataProvider0->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider1->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider2->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider3->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider4->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider5->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider6->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider7->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider8->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider9->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider10->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider11->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider12->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider13->models, 'handheld_machine_acknowledge'),
                BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'),
                ''
            ];
            $no = 2;
            $srlno = 1;
            $row = 0;
            foreach ($models as $model) {
                $this->return_array[$no] = [$srlno, $model->district_name, $model->partner_bank_name, $dataProvider0->models[$row]->certified_bc,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pvr : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pvr : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pvr : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pvr : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pvr : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pvr : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pvr : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pvr : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pvr : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pvr : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->pvr : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->pvr : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->pvr : 0,
                    isset($dataProvider13->models[$row]) ? $dataProvider13->models[$row]->pvr : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->shg_assigned : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->shg_assigned : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->shg_assigned : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->shg_assigned : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->shg_assigned : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->shg_assigned : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->shg_assigned : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->shg_assigned : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->shg_assigned : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->shg_assigned : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->shg_assigned : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->shg_assigned : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->shg_assigned : 0,
                    isset($dataProvider13->models[$row]) ? $dataProvider13->models[$row]->shg_assigned : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider13->models[$row]) ? $dataProvider13->models[$row]->bc_shg_bank_verified : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->pfms_mapping : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->pfms_mapping : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->pfms_mapping : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->pfms_mapping : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->pfms_mapping : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->pfms_mapping : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->pfms_mapping : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->pfms_mapping : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->pfms_mapping : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->pfms_mapping : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->pfms_mapping : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->pfms_mapping : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->pfms_mapping : 0,
                    isset($dataProvider13->models[$row]) ? $dataProvider13->models[$row]->pfms_mapping : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider13->models[$row]) ? $dataProvider13->models[$row]->bc_support_fund_shg_transfer : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider13->models[$row]) ? $dataProvider13->models[$row]->bc_support_fund_shg_acknowledge : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider13->models[$row]) ? $dataProvider13->models[$row]->handheld_machine_provided : 0,
                    isset($dataProvider0->models[$row]) ? $dataProvider0->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider1->models[$row]) ? $dataProvider1->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider2->models[$row]) ? $dataProvider2->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider3->models[$row]) ? $dataProvider3->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider4->models[$row]) ? $dataProvider4->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider5->models[$row]) ? $dataProvider5->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider6->models[$row]) ? $dataProvider6->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider7->models[$row]) ? $dataProvider7->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider8->models[$row]) ? $dataProvider8->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider9->models[$row]) ? $dataProvider9->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider10->models[$row]) ? $dataProvider10->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider11->models[$row]) ? $dataProvider11->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider12->models[$row]) ? $dataProvider12->models[$row]->handheld_machine_acknowledge : 0,
                    isset($dataProvider13->models[$row]) ? $dataProvider13->models[$row]->handheld_machine_acknowledge : 0,
                    $model->bc_bank_transaction,
                    $model->last_updated_on
                ];
                $no++;
                $srlno++;
                $row++;
            }
        }
//         echo "<pre>";
//         print_r($this->return_array);exit;
        return $this;
    }

    public function getMondaysInRange($dateFromString, $dateToString) {
        $dateFrom = new \DateTime($dateFromString);
        $dateTo = new \DateTime($dateToString);
        $dates = [];

        if ($dateFrom > $dateTo) {
            return $dates;
        }

        if (1 != $dateFrom->format('N')) {
            $dateFrom->modify('next monday');
        }

        while ($dateFrom <= $dateTo) {
            $dates[] = $dateFrom->format('Y-m-d');
            $dateFrom->modify('+1 week');
        }

        return $dates;
    }

    public function getMondaysInRangeLabel($dateFromString, $dateToString) {
        $dateFrom = new \DateTime($dateFromString);
        $dateTo = new \DateTime($dateToString);
        $dates = [];

        if ($dateFrom > $dateTo) {
            return $dates;
        }

        if (1 != $dateFrom->format('N')) {
            $dateFrom->modify('next monday');
        }

        while ($dateFrom <= $dateTo) {
            $dates[] = date("M,j", strtotime($dateFrom->format('Y-m-d')));
            $dateFrom->modify('+1 week');
        }

        return $dates;
    }

}

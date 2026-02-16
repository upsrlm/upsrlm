<?php

namespace bc\modules\training\models\report;

use Yii;
use yii\base\Model;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use yii\helpers\ArrayHelper;
use common\models\master\MasterRole;
use bc\modules\training\models\RsetisEcalendar;

/**
 * DashboardSearchForm for report
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ReportSearch extends Model {

    public $division_code;
    public $district_code;
    public $sub_district_code;
    public $block_code;
    public $village_code;
    public $gram_panchayat_code;
    public $status;
    public $change_type = "";
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $year_month_option = [];
    public $start_date;
    public $end_date;
    public $year_month_start_date;

    public function __construct($params) {
        $this->year_month_option = ['2021-01-01' => '2021 January', '2021-02-01' => '2021 February', '2021-03-01' => '2021 March', '2021-04-01' => '2021 April', '2021-05-01' => '2021 May', '2021-06-01' => '2021 June', '2021-07-01' => '2021 July', '2021-08-01' => '2021 August', '2021-09-01' => '2021 September', '2021-10-01' => '2021 October', '2021-11-01' => '2021 November', '2021-12-01' => '2021 December', '2022-01-01' => '2022 January', '2022-02-01' => '2022 February', '2022-03-01' => '2022 March', '2022-04-01' => '2022 April', '2022-05-01' => '2022 May', '2022-06-01' => '2022 June', '2022-07-01' => '2022 July', '2022-08-01' => '2022 August', '2022-09-01' => '2022 September', '2022-10-01' => '2022 October', '2022-11-01' => '2022 November', '2022-12-01' => '2022 December', '2023-01-01' => '2023 January', '2023-02-01' => '2023 February', '2023-03-01' => '2023 March', '2023-04-01' => '2023 April', '2023-05-01' => '2023 May', '2023-06-01' => '2023 June', '2023-07-01' => '2023 July', '2023-08-01' => '2023 August', '2023-09-01' => '2023 September', '2023-10-01' => '2023 October', '2023-11-01' => '2023 November', '2023-12-01' => '2023 December', '2024-01-01' => '2024 January', '2024-02-01' => '2024 February', '2024-03-01' => '2024 March', '2024-04-01' => '2024 April', '2024-05-01' => '2024 May', '2024-06-01' => '2024 June', '2024-07-01' => '2024 July', '2024-08-01' => '2024 August', '2024-09-01' => '2024 September', '2024-10-01' => '2024 October', '2024-11-01' => '2024 November', '2024-12-01' => '2024 December','2025-01-01' => '2025 January', '2025-02-01' => '2025 February', '2025-03-01' => '2025 March', '2025-04-01' => '2025 April', '2025-05-01' => '2025 May'];
        //$this->year_month_option = ['2021-01-01' => '2021 January', '2021-02-01' => '2021 February', '2021-03-01' => '2021 March', '2021-04-01' => '2021 April', '2021-05-01' => '2021 May', '2021-06-01' => '2021 June', '2021-07-01' => '2021 July', '2021-08-01' => '2021 August', '2021-09-01' => '2021 September', '2021-10-01' => '2021 October', '2021-11-01' => '2021 November', '2021-12-01' => '2021 December'];
        $this->load($params);
        if (!$this->year_month_start_date) {
            $date = new \DateTime('now');
            $date->modify('first day of this month');
            $this->year_month_start_date = $date->format('Y-m-d');
        }
        $this->district_option = GenralModel::districtoption();

        $this->block_option = GenralModel::blockoption($this);
        if ($this->block_code) {
            $this->gp_option = GenralModel::gpoption($this);
        }
        if ($this->block_code or $this->gram_panchayat_code) {
            $this->village_option = GenralModel::villageoption($this);
        }
        $this->end_date = \DateTime::createFromFormat("Y-m-d", $this->year_month_start_date)->format("Y-m-t");
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['district_code', 'sub_district_code', 'block_code', 'village_code', 'gram_panchayat_code'], 'safe'],
            [['start_date', 'end_date', 'year_month_start_date'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'division_code' => 'Division',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'village_code' => 'Village',
            'year_month_start_date' => 'Month'
        ];
    }

    public function ecalendar($user_model) {
        $events = [];
        $ecalendar_query = RsetisEcalendar::find();

        $this->end_date = \DateTime::createFromFormat("Y-m-d", $this->year_month_start_date)->format("Y-m-t");
        $ecalendar_query->andFilterWhere(['>=', 'date', $this->year_month_start_date]);
        $ecalendar_query->andFilterWhere(['<=', 'date', $this->end_date]);
//        $ecalendar_query->andFilterWhere(['>=', 'date', "2020-12-20"]);
//        $ecalendar_query->andFilterWhere(['<=', 'date', "2021-04-30"]);
        if ($user_model == NULL) {
            $ecalendar_query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN, MasterRole::ROLE_SPM_FI_MF])) {
                if ($this->district_code) {
                    $ecalendar_query->andWhere(['district_code' => $this->district_code]);
                } else {
                    $ecalendar_query->andWhere(['district_code' => 0]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_VIEWER, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                if ($this->district_code) {
                    $ecalendar_query->andWhere(['district_code' => $this->district_code]);
                } else {
                    $ecalendar_query->andWhere(['district_code' => 0]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                if ($this->district_code) {
                    $ecalendar_query->andWhere(['district_code' => $this->district_code]);
                } else {
                    $ecalendar_query->andWhere(['district_code' => 0]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                if ($this->district_code) {
                    $ecalendar_query->andWhere(['district_code' => $this->district_code]);
                } else {
                    $ecalendar_query->andWhere(['district_code' => 0]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                if ($this->district_code) {
                    $ecalendar_query->andWhere(['district_code' => $this->district_code]);
                } else {
                    $ecalendar_query->andWhere(['district_code' => 0]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                if ($this->district_code) {
                    $ecalendar_query->andWhere(['district_code' => $this->district_code]);
                } else {
                    $ecalendar_query->andWhere(['district_code' => 0]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                if ($this->district_code) {
                    $ecalendar_query->andWhere(['district_code' => $this->district_code]);
                } else {
                    $ecalendar_query->andWhere(['district_code' => 0]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $ecalendar_query->andWhere([RsetisEcalendar::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO])) {
                $ecalendar_query->andWhere([RsetisEcalendar::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $ecalendar_query->andWhere([RsetisEcalendar::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $ecalendar_query->andWhere([RsetisEcalendar::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $ecalendar_query->andWhere([RsetisEcalendar::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $ecalendar_query->andWhere([RsetisEcalendar::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $ecalendar_query->where('0=1');
            }
        }
        $ecalendar_models = $ecalendar_query->all();
        foreach ($ecalendar_models as $ecalendar) {
            $temp = new \yii2fullcalendar\models\Event();
            $temp->id = $ecalendar->id;
            $title = 'Total Training : ' . $ecalendar->total_training . '<br/>';
            $title .= 'Total Participant : ' . $ecalendar->total_participant . '';
            $temp->title = "$title";
            $temp->start = $ecalendar->date;
            $temp->end = $ecalendar->date;
            $temp->color = '#60C3FC';
            $temp->textColor = 'white';
            $district_code = '';
            if ($this->district_code) {
                $district_code = $this->district_code;
            }
            $url = "/training/training?RsetisCenterTrainingSearch[date]=" . $ecalendar->date . "&RsetisCenterTrainingSearch[district_code]=$district_code";
            $temp->url = \yii\helpers\Url::to([$url]);
            $events[] = $temp;
        }
        return $events;
    }
}

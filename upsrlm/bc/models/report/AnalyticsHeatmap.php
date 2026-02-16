<?php

namespace bc\models\report;

use Yii;
use common\models\master\MasterRole;
use yii\base\Model;
use bc\modules\selection\models\base\GenralModel;

/**
 * Report  
 */
class AnalyticsHeatmap extends Model {

    const LIGHT_RED = '#FFCCCB';
    const PINK = '#FFC0CB';
    const LIGHTGREEN = '#90EE90';
    const LIGHTBLUE = '#ADD8E6';
    const SKYBLUE = '#87CEEB';
    const LIGHT_BLACK = '#454545';
    const ORANGE_SALMON = '#C47451';
    const ASH_GRAY = '#666362';
    const SILVER = '#C0C0C0';
    const LIGHTGRAY = '#D3D3D3';
    const EARTH_GREEN = '#34A56F';
    const BROWN_SUGAR = '#E2A76F';
    const LIGHTYELLOW = '#FFFF00';
    const DARK_WHITE = '#FFFFFF';
    const LOCATION_TYPE_STATE = 1;
    const LOCATION_TYPE_DISTRICT = 2;

    public $all = 0;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $month_id;
    public $change_type;
    public $month_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $month_model;
    public $startYear='2021';
    public $month_deafault_value=0;

    public function __construct($params) {

        $this->load($params);
        $this->district_option = GenralModel::districtoption($this);
        if ($this->district_code) {
            $this->block_option = GenralModel::blockoption($this);
        }
        if ($this->block_code) {
            $this->gp_option = GenralModel::gpoption($this);
        }
    }

    public function rules() {
        return [
            [['district_code', 'block_code', 'month_id'], 'safe'],
        ];
    }

    public function search($params) {
        $query = (new \yii\db\Query())->from('block_bc_active_progress_monthly');
        $query->select(['id']);
        $this->load($params);
        $query->andFilterWhere([
            'block_bc_active_progress_monthly.district_code' => $this->district_code,
            'block_bc_active_progress_monthly.block_code' => $this->block_code,
        ]);

        $this->roleQuery($query);

        $model = $query->andWhere(['block_bc_active_progress_monthly.month_id' => $this->month_id])->sum('bc_active', \yii::$app->dbbc);
        return $model;
    }

    /**
     * get Alias of Geojson
     */
    public function getGeojson() {
        if ($this->district_code) {
            if ($this->block_code) {
                $block = \common\models\master\MasterBlock::find()->where(['block_code' => $this->block_code])->cache(7000)->limit(1)->one();
                if ($block) {
                    $block_file_path = Yii::$app->params['datapath'] . "/dashboard-geojson/blocks/block_" . $block->id . ".json";
                    if (file_exists($block_file_path)) {
                        return ['render' => 'renderFile', 'content' => $block_file_path];
                    }
                }
                return ['render' => 'render', 'content' => "@app/modules/page/views/heatmap/district/district-" . $this->district_code . '.json'];
            } else {
                return ['render' => 'render', 'content' => "@app/modules/page/views/heatmap/district/district-" . $this->district_code . '.json'];
            }
        }
        return ['render' => 'render', 'content' => "@app/modules/page/views/heatmap/geojson.json"];
    }

    /**
     * get Alias of Geojson
     */
    public function getParentgeojson() {
        if ($this->district_code) {
            if ($this->block_code) {

                $block = \common\models\master\MasterBlock::find()->where(['block_code' => $this->block_code])->cache(7000)->limit(1)->one();
                if ($block) {
                    $block_file_path = Yii::$app->params['datapath'] . "/dashboard-geojson/blocks/block_" . $block->id . ".json";
                    if (file_exists($block_file_path)) {
                        return ['render' => 'renderFile', 'content' => $block_file_path];
                    }
                }

                return ['render' => 'render', 'content' => "@app/modules/page/views/heatmap/district/district-" . $this->district_code . '.json'];
            }
            return ['render' => 'render', 'content' => "@app/modules/page/views/heatmap/geojson.json"];
        }
        return ['render' => 'render', 'content' => "@app/modules/page/views/heatmap/geojson.json"];
    }

    /**
     * Data for Heatmap
     */
    public function heatmapData($columns = []) {
        $query = (new \yii\db\Query())->from('block_bc_active_progress_monthly');
        $query->join('INNER JOIN', 'master_block', 'master_block.block_code = block_bc_active_progress_monthly.block_code');
        $group_by = ['block_bc_active_progress_monthly.district_code', "master_block.district_name"];
        $select_column = ['block_bc_active_progress_monthly.district_code as code', "master_block.district_name as name"];
        $query->andWhere(['block_bc_active_progress_monthly.month_id' => $this->month_id]);
        if ($this->district_code) {
            $query->andWhere(['block_bc_active_progress_monthly.district_code' => $this->district_code]);
            if ($this->block_code) {
                $query->andWhere(['block_bc_active_progress_monthly.block_code' => $this->block_code]);
                $group_by = ['block_bc_active_progress_monthly.district_code', 'block_bc_active_progress_monthly.block_code'];
                $select_column = ['block_bc_active_progress_monthly.district_code', 'block_bc_active_progress_monthly.block_code as code', "master_block.district_name", "master_block.block_name as name"];
                $query->orderBy(['block_bc_active_progress_monthly.block_code' => SORT_ASC]);
            } else {
                $group_by = ['block_bc_active_progress_monthly.district_code', "block_bc_active_progress_monthly.block_code"];
                $select_column = ['block_bc_active_progress_monthly.district_code', 'block_bc_active_progress_monthly.block_code as code', "master_block.district_name", "master_block.block_name as name"];
                $query->orderBy(['block_bc_active_progress_monthly.block_code' => SORT_ASC]);
            }
        }
        $this->roleQuery($query);

        $query->select(array_merge($group_by, $select_column, $columns));
        $query->groupBy($group_by);
        return \yii::$app->dbbc->createCommand($query->createCommand()->getRawSql())->queryAll();
    }

    public function roleQuery($query) {

        $user_model = \Yii::$app->user->identity;

        return $query;
    }

    public function heatmapChartGroupList() {
        return [
            'bc-active' => [
                'title' => 'BC Active',
                'charts' => [
                    [
                        'title' => 'GP/BC Active',
                        'tag' => 'bc_active_baseline',
                        'column_query' => 'sum(bc_active) as achived_sample,sum(no_of_gp) as total_sample'
                    ],
                ]
            ],
        ];
    }

    public function attributeLabels() {
        return [
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'month_id' => 'Month',
        ];
    }

    public function shadeof100colors() {

        return ["#000000", "#050500", "#0A0A00", "#0F0F00", "#141400", "#1A1A00", "#1F1F00", "#242400", "#292900", "#2E2E00", "#343400", "#393900", "#3E3E00", "#434300", "#484800", "#4E4E00", "#535300", "#585800", "#5D5D00", "#626200", "#686800", "#6D6D00", "#727200", "#777700", "#7C7C00", "#828200", "#878700", "#8C8C00", "#919100", "#969600", "#9C9C00", "#A1A100", "#A6A600", "#ABAB00", "#B0B000", "#B6B600", "#BBBB00", "#C0C000", "#C5C500", "#CACA00", "#D0D000", "#D5D500", "#DADA00", "#DFDF00", "#E4E400", "#EAEA00", "#EFEF00", "#F4F400", "#F9F900", "#FFFF00", "#F9FD05", "#F4FC0A", "#EFFB0F", "#EAFA14", "#E5F919", "#E0F81E", "#DBF723", "#D6F628", "#D1F52D", "#CCF432", "#C7F337", "#C2F23C", "#BDF142", "#B8F047", "#B3EF4C", "#AEEE51", "#A8ED56", "#A3EC5B", "#9EEB60", "#99EA65", "#94E96A", "#8FE86F", "#8AE774", "#85E679", "#80E57F", "#7BE484", "#76E389", "#71E28E", "#6CE193", "#67E098", "#62DF9D", "#5DDEA2", "#58DDA7", "#52DCAC", "#4DDBB1", "#48DAB6", "#43D9BB", "#3ED8C1", "#39D7C6", "#34D6CB", "#2FD5D0", "#2AD4D5", "#25D3DA", "#20D2DF", "#1BD1E4", "#16D0E9", "#11CFEE", "#0CCEF3", "#07CDF8", "#02CCFE", "#02CCFE"];
    }

    public function getDistrict() {
        return \common\models\master\MasterDistrict::find()->where(['district_code' => $this->district_code])->cache(70000)->limit(1)->one();
    }

    public function getBlock() {
        return \common\models\master\MasterBlock::find()->where(['block_code' => $this->block_code])->cache(70000)->limit(1)->one();
    }
}

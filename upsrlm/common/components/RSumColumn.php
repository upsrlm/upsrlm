<?php

namespace common\components;

use yii\grid\DataColumn;

class RSumColumn extends DataColumn {

    public function getDataCellValue($model, $key, $index) {

        $value = parent::getDataCellValue($model, $key, $index);
        if (is_numeric($value)) {
            $this->footer += $value;
        }

        return $value;
    }

}

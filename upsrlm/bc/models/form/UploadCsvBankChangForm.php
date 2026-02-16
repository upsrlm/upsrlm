<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\training\models\RsetisBatchParticipants;

ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 500);

class UploadCsvActionForm extends Model {

    public $csvfile;
    public $form;
    public $page_title;
    public $file_label;
    public $rows = [];
    public $sample_csv_url;
    public $error = false;
    public $fileid;
    public $label;
    public $master_partner_bank_id;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {

        return [
            [['form'], 'required'],
            [['csvfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
            [['fileid'], 'safe'],
            [['label'], 'string', 'max' => 125],
            [['master_partner_bank_id'], 'required'],
            
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'csvfile' => 'Select CSV file',
            'master_partner_bank_id' => 'Partner bank',
        );
    }

}

?>
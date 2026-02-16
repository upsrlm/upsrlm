<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcProvidedSaree;

/**
 * BcSareeDistributionForm is the model behind the BcProvidedSaree
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BcSareeDistributionForm extends \yii\base\Model {

    public $file_name;
    public $saree;
    public $distribution_date;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $sample_csv_url;
    public $fileid;
    public $bc_saree_model;
    public $rows = [];

    public function rules() {

        return [
            [['saree'], 'required'],
            [['distribution_date'], 'required'],
            [['distribution_date'], \common\validators\SareeDistributionDate::className()],
            ['file_name', 'required'],
            [['file_name'], 'file', 'skipOnEmpty' => true, 'extensions' => 'csv','checkExtensionByMimeType' => false, 'wrongExtension' => 'Only CSV file are allowed'],
            
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'saree' => 'Saree',
            'file_name' => 'Saree Distribution BC CSV file',
            'distribution_date' => 'Distribution Saree Date'
        );
    }

}

<?php

namespace cbo\models\sakhi\form;

use Yii;
use cbo\models\sakhi\RishtaShgProfile;

/**
 * This is the model class for table "rishta_shg_profile".
 *
 * @property int $idshg
 * @property int|null $cbo_shg_id
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $village_code
 * @property string|null $village_name
 * @property string $hamlet
 * @property string $name_of_shg
 * @property string|null $shg_code
 * @property string|null $date_of_formation
 * @property int $no_of_members
 * @property int|null $cbo_vo_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $dummy_column
 * @property int $status
 */
/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */

class DeleteRishtaShgProfileForm extends \yii\base\Model {

    public $id;
    public $name_of_shg;
    public $cbo_shg_id;
    public $no_of_members;
    public $date_of_formation;
    public $shg_profile_model;

    public function __construct($shg_profile_model = null) {
        $this->shg_profile_model = Yii::createObject([
                    'class' => RishtaShgProfile::className()
        ]);
        if ($shg_profile_model != null) {
            $this->shg_profile_model = $shg_profile_model;
            $this->name_of_shg = $this->shg_profile_model->name_of_shg;
            $this->cbo_shg_id = $this->shg_profile_model->cbo_shg_id;
            $this->no_of_members = $this->shg_profile_model->no_of_members;
            $this->date_of_formation = $this->shg_profile_model->date_of_formation;
        }
    }

    public function rules() {
        return [
            [['name_of_shg', 'no_of_members','date_of_formation'], 'required','message'=> "{attribute} खाली नहीं हो सकती।"],
            [['cbo_shg_id'], 'integer'],
            [['date_of_formation'], 'safe'],
            [['name_of_shg'], 'trim'],
            [['name_of_shg'], 'string', 'min'=>2 ,'max' => 150],
            ['no_of_members', 'integer', 'min' => 0, 'max' => 99,'message' =>"सदस्यों की संख्या 99 से अधिक नहीं होनी चाहिए।"],
            [['date_of_formation'], 'date', 'format' => 'php:Y-m-d']
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'cbo_shg_id' => 'SHG ID',
            'name_of_shg' => 'SHG का नाम',
            'no_of_members' => 'सदस्यों की संख्या',
            'date_of_formation' => 'गठन की तारीख',
        ];
    }


}

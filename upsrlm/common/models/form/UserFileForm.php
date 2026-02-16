<?php

namespace common\models\form;

use Yii;
use common\models\User;
use common\models\UserProfile;
use common\models\base\GenralModel;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\Expression;

/**
 * UserProfileForm is the model behind the UserProfile
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UserFileForm extends Model {

    public $user_id;
    public $file_type;
    public $image_file;
    public $file_type_option = ["1" => "Profile Photo", "2" => "Pan Card", "3" => "Aadhaar Card (front side)", "4" => "Aadhaar Card (back side)", "5" => "First Page of Bank Passbook", "6" => "Copy of offer letter", "7" => "Copy of service agreement", "8" => "Last Posting Order", "9" => "upload your photo id 1", "10" => "upload your photo id 2"];

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['image_file', 'user_id', 'file_type'], 'required'],
            [['user_id', 'file_type'], 'integer'],
            [['image_file'], 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024 * 1024 * 1],
            //[['image_file'], 'string', 'max' => 150],
            ['file_type_option', 'safe']
        ];
    }

}

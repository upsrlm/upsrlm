<?php

namespace sakhi\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use common\models\User;
use common\models\master\MasterRole;
use common\components\Appcheck;
use common\models\WebApplication;
use common\models\dynamicdb\cbo_detail\master\RishtaMasterPermission;
use common\models\dynamicdb\cbo_detail\CboMembers;
use common\models\dynamicdb\cbo_detail\RishtaRolePermission;

class App extends \yii\base\Component {

    public $check;
    public $user_permission_model;
    public $user_rishta_role = [];
    public $role_permission = [];

    public function checkAccess($module, $user_model = null, $action, $params = []) {


        $access = false;
        if ($user_model == null) {
            return $access;
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN])) {
                $access = true;
                return $access;
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER])) {

                switch ($module) {
                    case "bc":
                        $this->user_permission_model = \common\models\CboMemberProfile::find()->where(['user_id' => $user_model->id, 'srlm_bc_application_id' => $params['bcid'], 'bc' => 1])->one();
                        if (isset($this->user_permission_model)) {
                            $access = true;
                        }
                        if (isset($user_model->cboprofile) and $user_model->cboprofile->bc) {
                            $access = true;
                        }
                        return $access;
                        break;
                    case "shg":
                        if (isset($params['shgid']) and $params['shgid']) {
                            $this->user_rishta_role = [];
                            $this->user_permission_model = \common\models\CboMembers::find()->where(['user_id' => $user_model->id, 'cbo_id' => $params['shgid'], 'cbo_type' => CboMembers::CBO_TYPE_SHG, 'status' => 1])->one();

                            if (isset($this->user_permission_model)) {
                                if ($this->user_permission_model->shg_chairperson) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::shg_chairperson);
                                }
                                if ($this->user_permission_model->shg_secretary) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::shg_secretary);
                                }
                                if ($this->user_permission_model->shg_treasurer) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::shg_treasurer);
                                }
                                if ($this->user_permission_model->shg_member) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::shg_member);
                                }
                                if ($this->user_permission_model->shg_member) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::shg_member);
                                }
                                if ($this->user_permission_model->bc_sakhi) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::bc_sakhi);
                                }
                                if ($this->user_permission_model->samuh_sakhi) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::samuh_sakhi);
                                }
                                if ($this->user_permission_model->wada_sakhi) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::selected_wada_sakhi);
                                }
                                if ($this->user_permission_model->suggest_wada_sakhi) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::wada_sakhi);
                                }
                                if ($this->user_permission_model->accountant) {
                                    array_push($this->user_rishta_role, RishtaRolePermission::accountant);
                                }
                                $this->role_permission = ArrayHelper::getColumn(RishtaRolePermission::find()->where(['role' => $this->user_rishta_role, 'status' => 1])->all(), 'permission');

                                if ($action == '/shg/feedback/form' and in_array(RishtaMasterPermission::SHG_FEEDBACK, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/application/form' and in_array(RishtaMasterPermission::SHG_WADA_SAKHI_FORM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/application/form-next' and in_array(RishtaMasterPermission::SHG_WADA_SAKHI_FORM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/application/form-section' and in_array(RishtaMasterPermission::SHG_WADA_SAKHI_FORM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/application/makepayment' and in_array(RishtaMasterPermission::SHG_WADA_SAKHI_FORM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/application/saveimage' and in_array(RishtaMasterPermission::SHG_WADA_SAKHI_FORM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/application/view' and in_array(RishtaMasterPermission::SHG_WADA_SAKHI_FORM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/wss/bank' and in_array(RishtaMasterPermission::SHG_WADA_SAKHI_FORM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/bankaccount/index' and in_array(RishtaMasterPermission::SHG_BANK_DETAIL_VIEW, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/bankaccount/update' and in_array(RishtaMasterPermission::SHG_BANK_DETAIL_ADD_UPDATE_DELETE, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/bankaccount/remove' and in_array(RishtaMasterPermission::SHG_BANK_DETAIL_ADD_UPDATE_DELETE, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/bankaccount/bankpassbook' and in_array(RishtaMasterPermission::SHG_BANK_DETAIL_VIEW, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/index' and in_array(RishtaMasterPermission::SHG_MEMBER_VIEW, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/verifychairperson' and in_array(RishtaMasterPermission::SHG_MEMBER_MAKE_USER, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/verifysecretary' and in_array(RishtaMasterPermission::SHG_MEMBER_MAKE_USER, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/verifytreasurer' and in_array(RishtaMasterPermission::SHG_MEMBER_MAKE_USER, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/update' and in_array(RishtaMasterPermission::SHG_MEMBER_ADD_UPDATE_DELETE, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/remove' and in_array(RishtaMasterPermission::SHG_MEMBER_ADD_UPDATE_DELETE, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/officebearers' and in_array(RishtaMasterPermission::SHG_MEMBER_ADD_UPDATE_DELETE, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/suggestwadasakhi' and in_array(RishtaMasterPermission::SHG_SUGGEST_WADA_SAKHI, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/scheme' and in_array(RishtaMasterPermission::SHG_WADA_SCHEME_FROM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/householdmember' and in_array(RishtaMasterPermission::SHG_WADA_SCHEME_FROM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/householdmemberupdate' and in_array(RishtaMasterPermission::SHG_WADA_SCHEME_FROM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/householdmemberupdatecheck' and in_array(RishtaMasterPermission::SHG_WADA_SCHEME_FROM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/mgnregascheme' and in_array(RishtaMasterPermission::SHG_WADA_SCHEME_FROM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/bocw' and in_array(RishtaMasterPermission::SHG_WADA_SCHEME_FROM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/member/bocwform' and in_array(RishtaMasterPermission::SHG_WADA_SCHEME_FROM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/mgnrega/ackpayment' and in_array(RishtaMasterPermission::SHG_WADA_SCHEME_FROM, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/funds/index' and in_array(RishtaMasterPermission::SHG_FUNDS_VIEW, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/funds/fundlist' and in_array(RishtaMasterPermission::SHG_FUNDS_VIEW, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/funds/update' and in_array(RishtaMasterPermission::SHG_FUNDS_ADD_UPDATE_DELETE, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/profile/index' and in_array(RishtaMasterPermission::SHG_VIEW, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/profile/update' and in_array(RishtaMasterPermission::SHG_UPDATE, $this->role_permission)) {
                                    $access = true;
                                } elseif ($action == '/shg/profile/test') {
                                    $access = false;
                                } else {
                                    return $access;
                                }
                                return $access;
                            } else {
                                return $access;
                            }
                        } else {
                            return $access;
                        }
                        break;
                    case "vo":
                        $access = true;
                        return $access;
                        break;
                    case "clf":
                        $access = true;
                        return $access;
                        break;
                    case "notification":
                        $access = true;
                        return $access;
                        break;
                    case "page":
                        $access = true;
                        return $access;
                        break;
                    case "user":
                        $access = true;
                        return $access;
                        break;
                    default:
                }
            } else {
                return $access;
            }
        }
        return $access;
    }

}

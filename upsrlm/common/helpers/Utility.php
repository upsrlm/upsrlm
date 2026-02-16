<?php

namespace common\helpers;

use bc\models\master\MasterPartnerBank;
use common\models\master\MasterRole;

/**
 * Utility helper.
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Utility {

    /**
     * Wrapper for  security helper method.
     * @return string
     */
    public static function token($length = 10) {
        $sets = [
            'abcdefghjkmnpqrstuvwxyz',
            'ABCDEFGHJKMNPQRSTUVWXYZ',
            '23456789'
        ];
        $all = '';
        $code = '';
        foreach ($sets as $set) {
            $code .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $code .= $all[array_rand($all)];
        }

        $code = str_shuffle($code);

        return $code;
    }

    public static function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d') {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    public static function date_range_key($first, $last, $step = '+1 day', $output_format = 'Y-m-d') {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);
        $k = 1;
        while ($current <= $last) {

            $dates[$k] = date($output_format, $current);
            $current = strtotime($step, $current);
            $k++;
        }

        return $dates;
    }

    public static function date_range_key_value_date($first, $last, $step = '+1 day', $output_format = 'Y-m-d') {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[date($output_format, $current)] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    public static function getIndianCurrency(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else
                $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';

        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

    public static function getYear($pdate) {
        $date = DateTime::createFromFormat("Y-m-d", $pdate);
        return $date->format("Y");
    }

    public static function getMonth($pdate) {
        $date = DateTime::createFromFormat("Y-m-d", $pdate);
        return $date->format("m");
    }

    public static function getDay($pdate) {
        $date = DateTime::createFromFormat("Y-m-d", $pdate);
        return $date->format("d");
    }

    public static function getFirst_date_month($date) {
        $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
        return $first_date = date("Y-m-d", $first_date_find);
    }

    public static function getLast_date_month($date) {
        $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
        return $last_date = date("Y-m-d", $last_date_find);
    }

    public static function numberIndiaStyle($n, $d = 0) {
        $n = number_format($n, $d, '.', '');
        $n = strrev($n);

        if ($d)
            $d++;
        $d += 3;

        if (strlen($n) > $d)
            $n = substr($n, 0, $d) . ','
                    . implode(',', str_split(substr($n, $d), 2));

        return strrev($n);
    }

    public static function amountInLakhs($n) {

        if (!is_numeric($n))
            return "";

        $t = ($n / 100000);

        if ($t < 0)
            return ($t);
        else
            return $t;
    }

    public static function helthbgcolor($n) {
        $var = (int) filter_var($n, FILTER_SANITIZE_NUMBER_INT);
        $color = "#FF3800";
        if ($var >= 0 && $var <= 20) {
            $color = "#FF3800";
        } else if ($var >= 21 && $var <= 40) {
            $color = "#DC143C";
        } else if ($var >= 41 && $var <= 60) {
            $color = "#6495ED";
        } else if ($var >= 61 && $var <= 80) {
            $color = "#ff8a00";
        } else if ($var >= 81 && $var <= 99) {
            $color = "#ff8a00";
        } else {
            $color = "#00ff00";
        }
        return $color;
    }

    public static function daterange($first, $last, $step = '+1 day', $output_format = 'Y-m-d') {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    public static function convertModelErrorToString($model) {
        $returnMsg = "";
        /* @var $model Model */
        foreach ($model->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $returnMsg .= "" . $attribute . " - " . $error . "; ";
            }
        }
        return $returnMsg;
    }

    public static function convertMultimodelErrorToString($models) {
        $returnMsg = "";
        /* @var $model Model */
        if (!empty($models)) {
            foreach ($models as $model) {
                foreach ($model->getErrors() as $attribute => $errors) {
                    foreach ($errors as $error) {
                        $returnMsg .= "" . $attribute . " - " . $error . "; ";
                    }
                }
            }
        }
        return $returnMsg;
    }

    public static function percentageOf($number, $everything, $decimals = 1) {
        return round($number / $everything * 100, $decimals) . "%";
    }

    public static function DateFormatForDb($date) {

        $dbDateFormat = ($date != null and $date != '') ? \Yii::$app->formatter->asDatetime($date, "php:Y-m-d") : '';
        return $dbDateFormat;
    }

    public static function DateFormatForView($date) {

        $viewDateFormat = \Yii::$app->formatter->asDatetime($date, "php:d-m-Y");
        return $viewDateFormat;
    }

    public static function add_leading_zero($value, $threshold = 3) {
        if ($value != '') {
            return sprintf('%0' . $threshold . 's', $value);
        }
        return $value;
    }

    public static function generateNumericOTP($n) {

        $generator = "1357902468";
        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }

    public static function tbcdateformatdb($datetime) {
        $result = $datetime;
        list($date, $time) = explode(' ', $datetime);
        $date_arr = explode('-', $date);
        if (count($date_arr) == 3) {
            $result = $date_arr[2] . '-' . $date_arr[1] . '-' . $date_arr[0] . ' ' . $time;
        }
        return $result;
    }

    public static function dbdateddmmyy($date) {
        $result = '';
        $date_arr = explode('/', $date);
        if (count($date_arr) == 3) {
            $result = $date_arr[2] . '-' . $date_arr[1] . '-' . $date_arr[0];
        }
        return $result;
    }

    public static function seconds2hms($ss) {
        if ($ss == NULL) {
            $ss = 0;
        }
        $s = $ss % 60;
        $m = floor(($ss % 3600) / 60);
        $h = floor(($ss % 86400) / 3600);
        $d = floor(($ss % 2592000) / 86400);
        return "$d D : $h H : $m M : $s S";
    }

    public static function getAge($date) {

        $dob = new \DateTime($date);

        $now = new \DateTime();

        $difference = $now->diff($dob);

        $age = $difference->y;

        return $age;
    }

    public static function timetodecimalHours($time, $decimal = 0) {
        if ($time) {
            $hms = explode(":", $time);
            return round(($hms[0] + ($hms[1] / 60) + ($hms[2] / 3600)), $decimal);
        }
        return 0;
    }

    public static function decimalHourstotime($time) {
        if ($time) {
            return gmdate('H:i:s', floor($time * 3600));
            ;
        }
        return '00:00:00';
    }

    public static function mask($phone) {
        if (isset(\Yii::$app->user->identity->role)) {
            if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_MD, MasterRole::ROLE_MSC])) {
                return $phone;
            }
        }
        $times = strlen(trim(substr($phone, 2, 6)));
        $cross = '';
        for ($i = 0; $i < $times; $i++) {
            $cross .= 'x';
        }
        $result = str_replace(substr($phone, 2, 6), $cross, $phone);
        return $result;
    }

    public static function maskaadhar($ad) {
        if (isset(\Yii::$app->user->identity->role)) {
            if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_MD, MasterRole::ROLE_MSC])) {
                return rtrim(chunk_split($ad, 4, '-'), '-');
            }
        }
        $ad_length = strlen($ad);

        for ($i = 0; $i < $ad_length - 4; $i++) {
            $ad[$i] = 'X';
        }

        return rtrim(chunk_split($ad, 4, '-'), '-');
    }

    public static function daysBetween($dt1, $dt2) {
        try {
            return date_diff(
                            date_create($dt2),
                            date_create($dt1)
                    )->format('%a');
        } catch (\Exception $exc) {
            return 0;
        }
    }

    public static function validateDateFormat($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}

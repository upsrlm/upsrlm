<?php

namespace console\helpers;

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
}

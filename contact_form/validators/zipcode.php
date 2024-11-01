<?php

class validators_zipcode
{

    public function check($value)
    {
        $value = mb_convert_kana($value, "n", 'UTF-8');
        if ($value === '-') {
            return false;
        } else if (!preg_match("/(^\d{3}\-\d{4}$)/", $value)) {
            return '郵便番号の書式に誤りがあります';
        } else {
            return false;
        }
    }
}

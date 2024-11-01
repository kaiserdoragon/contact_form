<?php

class validators_email
{
    function check($value)
    {
        if (mb_strlen($value) > 0 && !preg_match("/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i", $value)) {
            return 'メールアドレスの書式に誤りがあります。';
        }else{
            return false;
        }
    }
}

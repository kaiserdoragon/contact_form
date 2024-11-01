<?php

class validators_match

{
    var $_param;

    function setParam($param)
    {

        $this->_param = $param;
    }

    function check($value)
    {
        if ($value != contactform::getInput($this->_param[0])) {
            return '確認項目と一致しません。';
        }

        return false;
    }
}

<?php

class validators_validator
{
    var $_param;

    function setParam($param)
    {
        $this->_param = $param;
    }


    function check($value)

    {var_dump($this->_param);

        if(!preg_match($this->_param[0],$value)){
            return $this->_param[1];
        }

        return false;

    }

}
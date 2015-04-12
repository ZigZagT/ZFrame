<?php
defined('_ZEXEC') or die;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Hold and proccess the error message from the official api.
 *
 * @author master
 */
class ErrorPackage
{
    public $errorCode;
    public $errorMsg;
    
    function __construct($errorCode, $errorMsg)
    {
        $this->errorCode = $errorCode;
        $this->errorMsg = $errorMsg;
    }
}

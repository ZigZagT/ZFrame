<?php
defined('_ZEXEC') or die;
class OfficialAPIException extends Exception
{
    /**
     * 
     * @param string $message [Optional]
     * @param int $code [Optional]
     * @param $previous [Optional]
     */
    function __construct($message, $code, $previous)
    {
        parent::__construct('Official API Exception'.$message, $code, $previous);
    }
}
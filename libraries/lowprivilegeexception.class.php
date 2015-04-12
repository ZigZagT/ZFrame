<?php
defined('_ZEXEC') or die;
class LowPrivilegeException extends Exception
{
    function __construct($privilegeMask)
    {
        parent::__construct("Low Privilege: current privilege code is ".PRIVILEGE_LEVEL.", required privilege mask is ".$privilegeMask.".");
    }
}

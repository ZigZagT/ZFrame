<?php
define("_ZEXEC", 1);
require_once 'base.php';

$login = new Login();
$login->secret = 'abcd1234';
$login->requirePath = 'simpleadmin.php';
$login->requireLoginSimple();

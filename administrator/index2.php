<?php
define("_ZEXEC", 1);
require_once 'base.php';

$loginNormal = new Login();
$loginNormal->secret = 'ztabcd1234';
$loginNormal->requirePath = 'admin.php';
$loginNormal->requireLoginSimple();
<?php
define("_ZEXEC", 1);
require_once 'base.php';
Log::addAccessLog();

header('Location: http://mad.daftme.com/c/index.html');
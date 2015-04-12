<?php
define("_ZEXEC", 1);
require_once 'base.php';
session_start();
Log::addAccessLog();

$course = new MadCourse();
$course->load($_REQUEST['collegeID'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['verification']);
echo $course->toJSON();
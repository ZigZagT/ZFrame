<?php
define("_ZEXEC", 1);
require_once 'base.php';
session_start();

$id = $_REQUEST['collegeID'];
$course = new MadCourse();
$data;
if (!empty($id)) {
    $data = $course->preload($id);
    echo base64_decode($data);
}
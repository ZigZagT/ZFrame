<?php
defined('_ZEXEC') or define("_ZEXEC", 1);
require_once 'base.php';
session_start();
$return = Base::call();
if (is_array($return) || is_object($return)) {
    echo json_encode($return);
} elseif (is_bool($return)) {
    echo json_encode(['status' => $return]);
} else {
    echo '{}';
}
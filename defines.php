<?php
defined('_ZEXEC') or die;
define('_ZDEFINE', 1);
define('ZPATH_ROOT', __DIR__);
define('ZPATH_LOG', ZPATH_ROOT . '/logs');
define('ZPATH_ACCESS_LOG', ZPATH_ROOT . '/logs/access.log');
define('ZPATH_ERROR_LOG', ZPATH_ROOT . '/logs/error.log');
define('ZPATH_RUNTIME_LOG', ZPATH_ROOT . '/logs/runtime.log');
define('CLASS_DIR', ZPATH_ROOT . '/libraries/');


define('ZPATH_IMAGE_FOLDER', ZPATH_ROOT . '/image');
//define('ZPATH_IMAGE_SERVER', 'http://image.sincegrown.com/wechat');
define('DB_ADDRESS', 'localhost');
define('DB_NAME', 'course');
define('DB_PREFIX', 'course_');
define('DB_USERNAME', 'course');
define('DB_PASSWORD', 'course');
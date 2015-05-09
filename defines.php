<?php

/* 
 * Copyright 2015 master.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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
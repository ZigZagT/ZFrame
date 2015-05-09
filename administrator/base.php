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

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    die('Your host needs to use PHP 5.4 or higher!');
}

if (!defined('_ZDEFINE')) {
    require_once __DIR__ . '/../defines.php';
}

set_include_path(get_include_path() . PATH_SEPARATOR . CLASS_DIR);
spl_autoload_extensions(".class.php");
spl_autoload_register();

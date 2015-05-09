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

define('_ZEXEC', 1);
if ($_SERVER['REMOTE_ADDR'] != '219.225.40.233')
    die;
require_once 'base.php';

$title = 'No log';
$file = null;
if ($_GET['errorlog'] == 'true')
{
    $title = 'Error Log';
    $file = fopen(ZPATH_ERROR_LOG, 'r') or die('Can not open file');
} 
if ($_GET['runtimelog'] == 'true')
{
    $title = 'Runtime Log';
    $file = fopen(ZPATH_RUNTIME_LOG, 'r') or die('Can not open file');
}
if ($_GET['accesslog'] == 'true')
{
    $title = 'Access Log';
    $file = fopen(ZPATH_ACCESS_LOG, 'r') or die('Can not open file');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?> Viewer</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="logtop">
            <button onclick="accesslog()">access log</button>
            <button onclick="errorlog()">error log</button>
            <button onclick="runtimelog()">runtime log</button>
            
            <a href="#logtop">top</a>
            <a href="#logbottom">bottom</a>
        </div>
        <h2><?php echo $title ?> Loading...</h2>
        <div>
            <?php
            while ($file != null && !feof($file))
            {
                echo '<pre>' . htmlspecialchars(fgets($file)) . '<br /></pre>';
            }
            fclose($file);
            ?>
        </div>
        <h2>Log End</h2>
        <div  id="logbottom">
            <button onclick="accesslog()">access log</button>
            <button onclick="errorlog()">error log</button>
            <button onclick="runtimelog()">runtime log</button>
            
            <a href="#logtop">top</a>
            <a href="#logbottom">bottom</a>
        </div>
    </body>
    <script type="text/javascript">
        var currentURL = window.location.href;
        if (currentURL.indexOf("?") >= 0)
        {
            currentURL = currentURL.substr(0, currentURL.indexOf("?"));
        }
        function accesslog()
        {
            window.location.href = currentURL + '?accesslog=true#logbottom';
        }
        function errorlog()
        {
            window.location.href = currentURL + '?errorlog=true#logbottom';
        }
        function runtimelog()
        {
            window.location.href = currentURL + '?runtimelog=true#logbottom';
        }
    </script>
</html>

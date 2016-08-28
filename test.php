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
defined('_ZEXEC') or define("_ZEXEC", 1);
require_once 'base.php';
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>test file transfer</title>
        <script src="library/jquery.js"></script>
    </head>
    <body>
        <label>file: </label>
        <input name="f" id="f" type="file">
        <button onclick="b()"></button>
        <div id="log"></div>
        <?php
        // put your code here
        ?>
    </body>
    <script>
        function b() {
            $("#log").html($("#f").val());
        }
    </script>
</html>

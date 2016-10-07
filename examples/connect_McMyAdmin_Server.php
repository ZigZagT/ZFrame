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

defined('ZEXEC') or define("ZEXEC", 1);
require_once '../base.php';
session_start();

if (!isset($_SESSION['MC']) || isset($_REQUEST['reset'])) {
    $_SESSION['MC'] = new McMyAdmin('http://mc.fuckcugb.com:8080/data.json');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connect McMyAdmin</title>
        <script src="../library/jquery.js"></script>
        <script src="../library/call.js"></script>
        <script>
            // Global Log Container.
            var log = $('#log');
            var interval;
            function fill() {
                var argsT = $('#fill input]').val().split(" ");
                if (argsT.length > 11) {
                    argsT.push(true);
                }
                exec('Fill', argsT, function (data) {
                    console.log('Fill: ');
                    console.log(data);
                    getMsg();
                }, 'MC', 'session', function (xhr, str) {
                    console.log('Fill Ajax Error:' + str);
                });
            }
            function action() {
                exec('init', [$('#action input[name=url]').val()], function () {
                    addMsg('Set URL successful.');
                }, 'McMyAdmin', 'static', function (xhr, str) {
                    console.log('Login Ajax Error:' + str);
                });
            }
            function login() {
                exec('Login', [$('#login input[name=username]').val(), $('#login input[name=password]').val()], function (data) {
                    if (data.success == true) {
                        addMsg('Login success.');
                        getMsg();
                    }
                    console.log('Login: ');
                    console.log(data);
                    if (interval) {
                        window.clearInterval(interval);
                    }
                    window.setInterval(getMsg, 3000);
                }, 'MC', 'session', function (xhr, str) {
                    console.log('Login Ajax Error:' + str);
                });
            }
            function chat() {
                exec('SendChat', [$('#chat textarea').val()], function (data) {
                    console.log('SendChat: ');
                    console.log(data);
                    getMsg();
                }, 'MC', 'session', function (xhr, str) {
                    console.log('SendChat Ajax Error:' + str);
                });
            }
            function getMsg() {
                exec('GetChat', [], function (data) {
                    if (Object.prototype.toString.call(data) === '[object Array]') {
                        data.forEach(function (obj) {
                            addMsg(obj.user + " " + obj.message);
                        });
                    } else {
                        addMsg('getMsg return value failed.')
                    }
                }, 'MC', 'session');
            }
            function addMsg(str) {
                var node = $('<p></p>');
                node.html(str);
                log.append((node));
                log[0].scrollTop = log[0].scrollHeight;
            }
        </script>
        <style>
            #log {
                background: #f3f3f3;
                height: 30em;
                overflow: scroll;
            }
        </style>
    </head>
    <body>
        <div id="action">
            <h2>Set Server Address:</h2>
            <label>Url:</label>
            <input type="text" name="url">
            <button onclick="action()">Set URL</button>
        </div>
        <div id="login">
            <h2>Login:</h2>
            <label>Username:</label>
            <input type="text" name="username">
            <label>Password:</label>
            <input type="password" name="password">
            <button onclick="login()">Login</button>
        </div>
        <div id="chat">
            <h2>Chat:</h2>
            <textarea value=""></textarea>
            <button onclick="chat()">Send</button>
        </div>
        <div id="fill">
            <h2>Fill:</h2>
            <span>/fill &nbsp;<input type="text"></span>
            <button onclick="fill()">Fill</button>
        </div>
        <div id="log"></div>
    </body>
    <script>
        $(document).ready(function () {
            log = $('#log')
        });
    </script>
</html>
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

if (!isset($_SESSION['MC'])) {
    $_SESSION['MC'] = new McMyAdminAPI('http://mc.fuckcugb.com/data.json');
}
$MC = &$_SESSION['MC'];
//$MC->isLogin = FALSE;
$MC->Login('admin', 'LiuZehui1995');

if (!isset($_REQUEST['ajax'])) {
    ?>
    <!DOCTYPE html>
    <!--
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    -->
    <html>
        <head>
            <meta charset="UTF-8">
            <title>FILL</title>
            <script src="libraries/jquery.js"></script>
            <script>
                function addMsg(data) {
                    var msg = $('#msg');
                    console.log(data);
                    data.forEach(function(obj) {
                        console.log(obj);
                        var node = $('<div></div>');
                        node.html(obj.user + " " + obj.message);
                        msg.append((node));
                    })
                }
                function sendMsg() {
                    val = $('#chat').val();
                    obj = {'ajax': 1, 'chat': val};
                    console.log(obj);
                    $.ajax({
                        dataType: "json",
                        url: '/test.php',
                        data: obj,
                        success: addMsg
                    });
                }
            </script>
        </head>
        <body>
            <div>
                <div>Chat:</div>
                <textarea id="chat" value=""></textarea>
                <button onclick="sendMsg()">Send</button>
            </div>
            <div id="msg"></div>
        </body>
    </html>
    <?php
} else {
    $MC->SendChat($_REQUEST['chat']);
    echo $MC->GetChat();
}
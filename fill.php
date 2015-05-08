<?php
defined('_ZEXEC') or define("_ZEXEC", 1);
require_once 'base.php';
session_start();

if (!isset($_SESSION['MC'])) {
    $_SESSION['MC'] = new McMyAdminAPI('http://mc.fuckcugb.com/data.json');
}
$MC = &$_SESSION['MC'];
// $MC->isLogin = FALSE;
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
            <script src="libraries/call.js"></script>
            <script>
                // Global Log Container.
                var log = $('#log');
                function addMsg(data) {
                    if (data) {
                        data.forEach(function (obj) {
                            var node = $('<p></p>');
                            node.html(obj.user + " " + obj.message);
                            log.append((node));
                        });
                    }
                }
                function sendMsg() {
                    val = $('#chat textarea').val();
                    ajax.data.class = null;
                    ajax.data.func =
                            con(addMsg);
                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        url: ajax.url,
                        data: JSON.stringify(ajax.data),
                        success: addMsg
                    });
                }
                function fill() {

                }
            </script>
        </head>
        <body>
            <div id="chat">
                <h2>Chat:</h2>
                <textarea value=""></textarea>
                <button onclick="sendMsg()">Send</button>
            </div>
            <div id="fill">
                <button onclick="fill()">Fill</button>
            </div>
            <div id="log"></div>
        </body>
        <script>
            $(document).ready(function () {

            });
        </script>
    </html>
    <?php
} else {
    switch (strtolower($_REQUEST['req'])) {
        case 'chat':
            $send = $MC->SendChat($_REQUEST['chat']);
            if (!$send) {
                $MC->isLogin = FALSE;
                $MC->Login('admin', 'LiuZehui1995');
                $send = $MC->SendChat($_REQUEST['chat']);
                if (!send) {
                    echo '{}';
                    die;
                }
            }
            break;
        default :
            break;
    }
    echo $MC->GetChat();
}
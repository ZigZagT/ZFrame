<?php
defined('_ZEXEC') or define("_ZEXEC", 1);
require_once 'base.php';
session_start();

if (!isset($_SESSION['MC'])) {
    $_SESSION['MC'] = new McMyAdminAPI('http://mc.fuckcugb.com/data.json');
}
$MC = &$_SESSION['MC'];
$MC->isLogin = FALSE;
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
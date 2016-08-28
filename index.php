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

// echo 'Hello ZFrame!';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!--meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' /-->
        <title><Home</title>

        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <script src="/librarie/js/jquery.js"></script>
        <script src="/librarie/js/marked.js"></script>
        <link rel="stylesheet" href="/librarie/css/base.css">
        <link rel="stylesheet" href="/librarie/css/blogarticle.css">
        <script src="/librarie/js/highlight.min.js"></script>
        <link rel="stylesheet" href="/librarie/css/highlight.min.css">
        <script src="/librarie/js/imagesloaded.min.js"></script>
        
        <script src="/librarie/js/call.js"></script>
        <script src="/librarie/js/utilities.js"></script>
        <script src="/librarie/js/debug.js"></script>
        
        <style>
            * {
                -webkit-tap-highlight-color: rgba(0,0,0,0); /* make transparent link selection, adjust last value opacity 0 to 1.0 */
                padding: 0;
                margin: 0;
            }

            body {
                -webkit-touch-callout: none;                /* prevent callout to copy image, etc when tap to hold */
                -webkit-text-size-adjust: none;             /* prevent webkit from resizing text to fit */
                -webkit-user-select: text;                  /* prevent copy paste, to allow, change 'none' to 'text' */
                /*background-image:linear-gradient(top, #A7A7A7 0%, #E4E4E4 51%);
                background-image:-webkit-linear-gradient(top, #A7A7A7 0%, #E4E4E4 51%);
                background-image:-ms-linear-gradient(top, #A7A7A7 0%, #E4E4E4 51%);
                background-image:-webkit-gradient(
                    linear,
                    left top,
                    left bottom,
                    color-stop(0, #A7A7A7),
                    color-stop(0.51, #E4E4E4)
                );*/
                font-family:'HelveticaNeue-Light', 'HelveticaNeue', Helvetica, Arial, sans-serif;
                font-size:12px;
                margin:0px;
                padding:0px;
            }

            /*[data-role = page] {
                background-image:linear-gradient(top, #A7A7A7 0%, #E4E4E4 51%);
                background-image:-webkit-linear-gradient(top, #A7A7A7 0%, #E4E4E4 51%);
                background-image:-ms-linear-gradient(top, #A7A7A7 0%, #E4E4E4 51%);
                background-image:-webkit-gradient(
                    linear,
                    left top,
                    left bottom,
                    color-stop(0, #A7A7A7),
                    color-stop(0.51, #E4E4E4)
                );
                background: red;
                background-attachment: scroll;
            }*/

            .fixedtophalf {
                position: fixed;
                height: 50%;
                /* There is a bug when setting the width value to anything except auto, and some samsung device will render some elements twice at a same placd. */
                width: 100%;
                bottom: 50%;
            }

            .fixedbottomhalf {
                position: fixed;
                height: 50%;
                width: 100%;
                top: 50%;
            }

            #log {
                -webkit-transform: translateZ(0px);
                -webkit-transform: translate3d(0,0,0);
                -webkit-perspective: 1000;
                -webkit-overflow-scrolling: touch;
                overflow-x: hidden;
                overflow-y: scroll;
            }

            .logline {
                background: rgba(255,255,255,0.4);
                margin: 0.5em;
                word-wrap: break-word;
            }

            #testbox {
                -webkit-transform: translateZ(0px);
                -webkit-transform: translate3d(0,0,0);
                -webkit-perspective: 1000;
                overflow-x: scroll;
                overflow-y: scroll;
                -webkit-overflow-scrolling: touch;
            }

            #testbox button {
                width: 98%;
                margin: 1%;
            }
        </style>
    </head>
    <body>
        <div id="form">
            登录名:
            <input type="text" id="uname" />
            验证码:
            <input type="text" id="ucode" />
            <img id="codeimg" onclick="methods.refresh_code()"/>
            <input type="hidden" id="pcid" />
            
            起始号吗:
            <input type="number" id="number_beg" />
            结束号码:
            <input type="number" id="number_end" />
            
            <button onclick="run()">run</button>
        </div>
        <div id="log"></div>
    </body>
    <script>
        function success(a) {
            console.log("success");
            console.log(a);
            b = JSON.parse(a);
            $("#msg").html(b.retcode + "<br>" + b.msg + "<br>" + b.data)
        }
        function error(a) {
            console.log("error");
            console.log(a);
            $("#msg").html(a.responseText)
        }
        
        var url = {
            prepare: "https://security.weibo.com/iforgot/loginname",
            get_code: "https://security.weibo.com/iforgot/ajcodeimage",
            post_loginname: "http://security.weibo.com/iforgot/ajloginname?entry=sso",
            verify_mobile: "http://security.weibo.com/iforgot/ajverifymobile"
            
        }
        var methods = {
            prepare: function(success, error) {
                browser_request(url.prepare, null, null, {"10023": [
                        "Host: security.weibo.com",
                        "Connection: keep-alive",
                        "Cache-Control: max-age=0",
                        "Upgrade-Insecure-Requests: 1",
                        "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36",
                        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
                        "DNT: 1",
                        "Accept-Encoding: gzip, deflate, sdch, br",
                        "Accept-Language: zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4"
                ]}, false, function(data) {
                    debug.printLine("prepare success");
                    if($.isFunction(success)) {
                        success();
                    }
                }, function() {
                    if($.isFunction(error)) {
                        debug.printLine("prepare failed");
                        error();
                    }
                });
                
            },
            refresh_code: function(success, error) {
                debug.printLine("refresh code...");
                browser_request(url.get_code, null, null, {"10023": [
                        "Host: security.weibo.com",
                        "Connection: keep-alive",
                        "Accept: */*",
                        "Origin: https://security.weibo.com",
                        "X-Requested-With: XMLHttpRequest",
                        "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36",
                        "DNT: 1",
                        "Referer: https://security.weibo.com/iforgot/loginname",
                        "Accept-Encoding: gzip, deflate, br",
                        "Accept-Encoding: gzip, deflate, sdch, br",
                        "Accept-Language: zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4"
                ]}, false, function(data) {
                    debug.printLine("get code...");
                    var json = JSON.parse(data);
                    if(json.retcode == 100000){
                        $("#codeimg").attr("src",json.data.image);
                        debug.printImg(json.data.image, "get code image " + json.data.pcid + ": ");
                        $("#pcid").val(json.data.pcid);
                        if($.isFunction(success)) {
                            success();
                        }
                    } else {
                        printLine("refresh code failed: " + json.msg);
                        if($.isFunction(error)) {
                            error();
                        }
                    }
                }, function() {
                    if($.isFunction(error)) {
                        error();
                    }
                });
            },
            post_loginname: function(success, error) {
                post_str = $.param({
                    loginname: $("#uname").val(),
                    pcid: $("#pcid").val(),
                    pincode: $("#ucode").val(),
                    entry: "sso"
                });
                debug.printLine("post loginname: <br>" + post_str);
                browser_request(url.post_loginname, null, post_str, {"10023": [
                        "Host: security.weibo.com",
                        "Connection: keep-alive",
                        "Accept: */*",
                        "Origin: https://security.weibo.com",
                        "X-Requested-With: XMLHttpRequest",
                        "Content-Type: application/x-www-form-urlencoded",
                        "DNT: 1",
                        "Referer: https://security.weibo.com/iforgot/loginname",
                        "Accept-Encoding: gzip",
                        "Accept-Language: zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4"
//                        "Host: security.weibo.com",
//                        "Connection: keep-alive",
//                        "Content-Length: 102",
//                        "Accept: */*",
//                        "Origin: https://security.weibo.com",
//                        "X-Requested-With: XMLHttpRequest",
//                        "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36",
//                        "Content-Type: application/x-www-form-urlencoded",
//                        "DNT: 1",
//                        "Referer: https://security.weibo.com/iforgot/loginname?entry=sso",
//                        "Accept-Encoding: gzip, deflate, br",
//                        "Accept-Language: zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4"
                ]}, false, function(data) {
                    debug.printLine("data received: " + data)
                    var json = JSON.parse(data);
                    if(json.retcode == 100000){
                        debug.printLine("post loginname success: " + data);
                        if($.isFunction(success)) {
                            success();
                            return;
                        }
                    }else if(json.retcode == 100038){
                        debug.printLine('用户名不存在');
                    } else if(json.retcode == 100037){
                        debug.printLine('请输入正确的验证码')
                    }else {
                        debug.printLine("post login failed: " + json.msg)
                    }
                    if($.isFunction(error)) {
                        error();
                    }
                }, function() {
                console.log("post login name failed");
                    if($.isFunction(error)) {
                        error();
                    }
                });
            },
            enable_verify_mobile: function(success, error) {
                
            },
            verify_mobile: function(success, error) {
                
            },
            try_number: function(number, success, error) {
                var rand = "bff4d7d972255d3d4f30e454b1d7a20a";
                post_str = $.param({
                    country: 86,
                    mobile: number,
                    rand: rand,
                });
                browser_request(url.verify_mobile, null, post_str, {"10023": [
                        "Host: security.weibo.com",
                        "Connection: keep-alive",
                        "Accept: */*",
                        "Origin: https://security.weibo.com",
                        "X-Requested-With: XMLHttpRequest",
                        "Content-Type: application/x-www-form-urlencoded",
                        "DNT: 1",
                        "Referer: https://security.weibo.com/iforgot/verifymobile?rand=" + rand,
                        "Accept-Encoding: gzip",
                        "Accept-Language: zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4"
                ]}, false, function(data) {
                    var json = JSON.parse(data);
                    if(json.retcode == 100000){
                        debug.printLine("mobil success: " + data);
                        if($.isFunction(success)) {
                            success();
                            return;
                        }
                    }else if(json.retcode == 100038){
                        debug.printLine('用户名不存在');
                    } else if(json.retcode == 100037){
                        debug.printLine('请输入正确的验证码')
                    }else {
                        debug.printLine("verify mobile failed: " + json.retcode + "" + json.msg)
                    }
                    if($.isFunction(error)) {
                        error();
                    }
                }, function() {
                    if($.isFunction(error)) {
                        error();
                    }
                });
            }
        }
        function run() {
            methods.post_loginname();
            //methods.try_number($("#number_beg").val());
        }
            
        debug.init();
        methods.prepare(methods.refresh_code);
//        methods.refresh_code()();
    </script>
</html>
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
require_once 'base.php';
session_start();

$res = Base::curl_request('https://blog.daftme.com/api/pac/users/1/content/raw', NULL, NULL, [CURLOPT_TIMEOUT => 0]);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>test</title>
        <script src="library/js/jquery.js"></script>
        <script type="application/javascript" src="http://jsonip.appspot.com/?callback=getip"> </script>

    </head>
    <body>
        <label for="url">url: </label>
        <input id="url" type="text" />
        <label for="url">host: </label>
        <input id="host" type="text" />
        <button onclick="b()">go</button>
        <div id="log"></div>

    </body>
    <script>
        var defaultdns = "255.255.255.255";
        function dnsResolve(host) {
            return defaultdns;
        }
        function isInNet(addr, ip, mask) {
            var reg = /\./;
            addr = addr.split(".");
            ip = ip.split(".");
            mask = mask.split(".");

            for (var i = 0; i < 4; ++i) {
                if (addr[i] & mask[i] != ip[i] & mask[i]) {
                    return false;
                }
            }
            return true;
        }
    </script>
    <script>
<?php echo $res; ?>
    function b() {
        $("#log").html(FindProxyForURL($("#url").val(), $("#host").val()));
    }
    </script>
</html>

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
require_once '../base.php';

if ($_GET['clearaccesslog'] == 'true') // && $_POST['clearlog'] == 'true')
{
    echo Log::clearAccessLog();
}
if ($_GET['clearerrorlog'] == 'true') // && $_POST['clearlog'] == 'true')
{
    echo Log::clearErrorLog();
}
if ($_GET['clearruntimelog'] == 'true') // && $_POST['clearlog'] == 'true')
{
    echo Log::clearRuntimeLog();
}
if ($_GET['initdb'] == 'true')
{
    $db = new DatabaseController();
    $prefix = DB_PREFIX;
    $appid = 'wx2752af5d77161767';
    $appsecret = '0ccc03d7e6a66d4c242669a7a4c85e54';
    $privilege_level = '0001';
    $token = 'mtimeacef12349edi8w6ejvw3ft32g';
    $timeZone = 'UTC+08:00';

    $sql = <<< EOSQL
DROP TABLE IF EXISTS {$prefix}config;
CREATE TABLE {$prefix}config (
name VARCHAR(63) NOT NULL PRIMARY KEY,
value VARCHAR(255) DEFAULT NULL,
update_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
expired INT(11) unsigned DEFAULT NULL,
extra VARCHAR(511) DEFAULT NULL
);
INSERT INTO {$prefix}config (name, value) value("appid", "{$appid}");
INSERT INTO {$prefix}config (name, value) value("appsecret", "{$appsecret}");
INSERT INTO {$prefix}config (name, value) value("privilege_level", "{$privilege_level}");
INSERT INTO {$prefix}config (name, value) value("token", "{$token}");
INSERT INTO {$prefix}config (name, value) value("time_zone", "{$timeZone}");
INSERT INTO {$prefix}config (name, expired) value("access_token", 0);

DROP TABLE IF EXISTS {$prefix}received_message;
CREATE TABLE {$prefix}received_message (
message_id BIGINT NOT NULL PRIMARY KEY,
to_user_name VARCHAR(255) NOT NULL,
from_user_name VARCHAR(255) NOT NULL,
create_time TIMESTAMP NOT NULL,
message_type VARCHAR(63) NOT NULL,
whole_xml_pac VARCHAR(10000) DEFAULT NULL,
expired int(11) unsigned DEFAULT NULL,
extra varchar(511) DEFAULT NULL
);

DROP TABLE IF EXISTS {$prefix}auto_reply;
CREATE TABLE {$prefix}auto_reply (
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
receive_message_type VARCHAR(63) NOT NULL DEFAULT "text",
reply_message_type VARCHAR(63) NOT NULL DEFAULT "text",
keyword_in_xml VARCHAR(10000) NOT NULL,
reply_in_xml VARCHAR(10000) NOT NULL,
update_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
expired int(11) unsigned DEFAULT NULL,
is_enabled int(1) unsigned DEFAULT 1
);
EOSQL;

    $row = $db->exec($sql);
    if ($row === false)
    {
        Log::addErrorLog("database initialize failed. SQL: $sql");
        echo ("process failed");
    } else
    {
        echo ("process success, $row rows affected");
        Log::addRuntimeLog("database initialized. SQL: $sql");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>God View</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="/global/js/jquery-1.11.2.js"></script>
        <script>
        </script>
    </head>
    <body>
        <div>
            <button onclick="backToHome()">Home</button><br>
            <button onclick="clearAccesslog()">clear access log</button><br>
            <button onclick="clearErrorlog()">clear error log</button><br>
            <button onclick="clearRuntimeLog()">clear runtime log</button><br>
            <button onclick="initDB()">initialize database</button><br>
            <button onclick="editAutoReply()">Edit Auto Reply</button>
        </div>
        <hr>
        <?php
        if ($_GET['editautoreply'] == 'true')
        {
            if (isset($_POST['addAutoReply']) && $_POST['addAutoReply'] == 1)
            {
                $db = new DatabaseController();
                $receivedMsg = new WechatMessage(array(
                    'MsgType' => $_POST['receivedType']
                ));
                $echoStr = 'Add auto reply record successful.';
                $strlenEcho = "";
                switch ($receivedMsg->MsgType)
                {
                    case 'text':
                        $receivedMsg->Content = $_POST['receivedContent'];
                        $length = strlen($_POST['replyContent']);
                        $strlenEcho = " Text length is {$length}。";
                        break;
                    case 'event':
                        $receivedMsg->Event = $_POST['eventType'];
                        $receivedMsg->EventKey = $_POST['eventKey'];
                    default:
                        break;
                }
                $replyMsg = new WechatMessage(array(
                    'MsgType' => 'text',
                    'Content' => $_POST['replyContent']
                ));

                if ($receivedMsg->MsgType == 'text' && strlen($replyMsg->Content) > 2047)
                {
                    $echoStr = 'Add auto reply record failed. Text too large.'.$strlenEcho;
                } else
                {
                    $echoStr .= $strlenEcho;
                    $db->setAutoReply($receivedMsg, $replyMsg);
                }
                ?>
                <h4><?php echo $echoStr; ?></h4>
            <?php }
            ?>
            <div>
                <h3>Auto Reply Editor</h3>
                <div>
                    Insert auto reply match...
                    <form action="#" method="post" target="_self">
                        received type:<select name="receivedType" onclick="select(this, event)">
                            <option value="text" selected="selected" onclick="divText()">text</option>
                            <option value="event" onclick="divEvent()">event</option>
                        </select>
                        <br>
                        <div id="text">
                            received content:<textarea name="receivedContent"></textarea>
                        </div>
                        <div id="event" hidden="hidden">
                            event type:
                            <select name="eventType">
                                <option value="subscribe" selected="selected">subscribe</option>
                                <option value="unsubscribe">unsubscribe</option>
                                <option value="SCAN">SCAN</option>
                                <option value="CLICK">CLICK</option>
                                <option value="VIEW">VIEW</option>
                            </select>
                            event key:
                            <textarea name="eventKey"></textarea>
                        </div>
                        <br>
                        reply content:<textarea name="replyContent"></textarea>
                        <input type="hidden" name="addAutoReply" value="1">
                        <br>
                        <input type="submit" value="Submit">
                    </form>
                    <script>
                        var text = document.getElementById("text");
                        var event = document.getElementById("event");
                        function divText()
                        {
                            text.removeAttribute("hidden");
                            event.setAttribute("hidden", "hidden");
                        }
                        function divEvent()
                        {
                            event.removeAttribute("hidden");
                            text.setAttribute("hidden", "hidden");
                        }
                        function select(element, e)
                        {
                            if (element.selectedIndex == 0)
                            {
                                divText();
                            }
                            else if (element.selectedIndex == 1)
                            {
                                divEvent();
                            }
                        }
                    </script>
                </div>
            </div>
        <?php } ?>
    </body>
    <script type="text/javascript">
        var currentURL = window.location.href;
        if (currentURL.indexOf("?") >= 0)
        {
            currentURL = currentURL.substr(0, currentURL.indexOf("?"));
        }
        function backToHome()
        {
            window.location.href = currentURL;
        }
        function clearAccesslog()
        {
            window.location.href = currentURL + '?clearaccesslog=true';
        }
        function clearErrorlog()
        {
            window.location.href = currentURL + '?clearerrorlog=true';
        }
        function clearRuntimeLog()
        {
            window.location.href = currentURL + '?clearruntimelog=true';
        }
        function initDB()
        {
            window.location.href = currentURL + '?initdb=true';
        }
        function editAutoReply()
        {
            window.location.href = currentURL + '?editautoreply=true';
        }
    </script>
</html>

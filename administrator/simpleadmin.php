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
require_once 'base.php';
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
        <?php
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
    </body>
</html>

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
$_SERVER['REMOTE_ADDR'] == '127.0.0.1' or die;
?>

<form action="http://mad.daftme.com/load.php" method="POST">
    <input type="hidden" name="collegeID" value="CUGB">
    <p><label>Username: </label><input type="text" name="username" value=""></p>
    <p><label>Password: </label><input type="password" name="password" value=""></p>
    <p><label>Are You Not Robot: </label><input type="text" name="verification">
        <img src="http://mad.daftme.com/preload.php?_=<?php echo time();?>&collegeID=CUGB"></p>
    <input type="submit" value="submit">
</form>
<pre>
    <?php
    echo $_SERVER['REMOTE_ADDR']
    ?>
</pre>
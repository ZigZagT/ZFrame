<?php
session_start();
if ($_SERVER['REMOTE_ADDR'] != '219.225.40.233')
    die;
?>
<img src="http://mad.daftme.com/preload.php?_=1428910480627&collegeID=CUGB">
<form action="http://mad.daftme.com/load.php" method="POST">
    <input type="text" name="verification">
    <input type="hidden" name="collegeID" value="CUGB">
    <input type="hidden" name="username" value="1004135223">
    <input type="hidden" name="password" value="101314">
    <input type="submit" value="submit">
</form>
<pre>
    <?php
    echo $_SESSION["remote_cookie"];
    echo "\n";
    echo $_SERVER['REMOTE_ADDR']
    ?>
</pre>
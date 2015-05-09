# TFrame
<h1>Basic PHP Framework</h1>
<h6>Licensed under the Apache License, Version 2.0 (the "License")<h6>

<p>You should add following code at the beginning of every entry file:</p>
<p><b>Note:&nbsp;</b>You should modify the path of <i>base.php</i> to make sure it included.</p>
<pre>
&lt;?php
defined('_ZEXEC') or define("_ZEXEC", 1);
require_once 'base.php';
session_start();
</pre>
<p>And use these as the beginning of every normal file:</p>
<pre>
&lt;?php
defined('_ZEXEC') or die;
</pre>
<hr>
<p>Write your own startup code in startup.php, and this will be auto included in base.php.</p>
<p>Modify <i>defines.php</i> for PATH variable and Database connection.</p>

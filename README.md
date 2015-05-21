# ZFrame
<h2>Basic PHP Framework</h2>
<h6>Licensed under the Apache License, Version 2.0<h6>

<p>You should add following lines at the beginning of every entry file:</p>
<p><b>Note:&nbsp;</b>You should modify the path of <i>base.php</i> to make sure it included.</p>
<pre>
&lt;?php
defined('_ZEXEC') or define("_ZEXEC", 1);
require_once 'base.php';
session_start();
</pre>
<p>And use this as the beginning of other files:</p>
<pre>
&lt;?php
defined('_ZEXEC') or die;
</pre>
<hr>
<p>Write your own startup code in startup.php, and this will be included in the end of base.php.</p>
<p>Modify <i>defines.php</i> for PATH variable and Database connection.</p>

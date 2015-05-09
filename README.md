# TFrame
Basic PHP Framework

<p>You should add following code at the beginning of every entry file:</p>
<p><b>Note:&nbsp;</b>you should modify the path of <i>base.php</i> to make sure it included.
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

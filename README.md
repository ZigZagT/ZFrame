# TFrame
Basic PHP Framework

<p>You should add fowing code at the begining of every entry file:</p>
<pre>
&lt;?php
defined('_ZEXEC') or define("_ZEXEC", 1);
require_once 'base.php';
session_start();
</pre>
<p>And use these as the begining of every normal file:</p>
<pre>
&lt;?php
defined('_ZEXEC') or die;
</pre>
<hr>
<p>Write your own startup code in startup.php, and this will be auto included in base.php.</p>

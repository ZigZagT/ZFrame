# ZFrame
## Basic PHP Framework
###### Licensed under the Apache License, Version 2.0<h6>

#### You should add following lines at the beginning of every entry file:

**Note:** You should modify the path of <i>base.php</i> to make sure it included.
```php
<?php
defined('_ZEXEC') or define("_ZEXEC", 1);
require_once 'base.php';
session_start();
```

#### And use this as the beginning of other files:
```php
<?php
defined('_ZEXEC') or die;
```
======
Write your own startup code in startup.php, and this will be included in the end of base.php.
Modify `defines.php` for PATH variable and Database connection.

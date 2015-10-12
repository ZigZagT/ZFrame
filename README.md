# ZFrame -- *Basic PHP Framework*

#### Quick Start:
* Add following lines to the beginning of each *entry* file:  
  **Note:** Change the path of `base.php` to make sure it included.  
  ```php
  <?php
  defined('_ZEXEC') or define("_ZEXEC", 1);
  require_once 'base.php';
  session_start();
  ```
  
* And for other files, use:
```php
<?php
defined('_ZEXEC') or die;
```

=======
#### Easy Extend:
Write your own startup code in `startup.php`. This file would be included at the end of `base.php`.

======
Database information is saved in `defines.php`. Change these lines for your own use.

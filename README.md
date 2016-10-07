# ZFrame

*A complete toolset for both back-end && front-end development*  
*前端与后端集成的开发工具集*

## Basic Requirement
- PHP 5.6 and later
- ECMAScript 6 support
- (optional) PDO extensions for Mysql/MariaDB

## Quick Start:
### Back-end
- Add following lines to the beginning of each **entry** file:  
  **Modify the path of `base.php` to make sure it included.**
    ```php
    <?php
    defined('ZEXEC') or define("ZEXEC", 1);
    require_once 'base.php';
    session_start();
    ```

- And for other files not desired to be **entry**:
    ```php
    <?php
    defined('ZEXEC') or die;
    ```

- Modify `defines.php` to include your database connection pass like this:
    ```php
    define('ZDB_HOST', 'localhost');
    define('ZDB_DBNAME', 'z_database');
    define('ZDB_TABLE_PREFIX', 'z_');
    define('ZDB_USERNAME', 'username');
    define('ZDB_PASSWORD', 'password');
    ```
- Add custom startup code in `startup.php`. This file would be included at the end of `base.php`.

### front-end
- To use ZFrame, include this script:
    ```html
    <script type="module" src="library/js/ZFrame.js"></script>
    ```
    and then, import ZFrame into custom code:
    ```javascript
    import "ZFrame";
    ```

### Using thirdparty modules
#### Back-end
ZFrame use default `spl_autoload()` function to load modules. To use this, modules should be added into `library/thirdparty` with lowercase filename and end with `.class.php` extension. Every `.class.php` file should contains a php class whose class name matches the filename. Class name match is case-insensitive. And creating an instance of the class will make the whole file included via `spl_autoload()`.
#### front-end
Place the `.js` file into `library/js/thirdparty`, and use `ZFrame.import(filename)` to include them.


=========

Documentation can be generated using ApiGen with setting file `apigen.neon`.

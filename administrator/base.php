<?php
defined('_ZEXEC') or die;

if (version_compare(PHP_VERSION, '5.4.0', '<'))
{
    die('Your host needs to use PHP 5.4 or higher!');
}

if (!defined('_ZDEFINE'))
{
    require_once __DIR__.'/../defines.php';
}

set_include_path(get_include_path() . PATH_SEPARATOR . CLASS_DIR);
spl_autoload_extensions(".class.php");
spl_autoload_register();
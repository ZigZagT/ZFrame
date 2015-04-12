<?php

defined('_ZEXEC') or die;
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    die('Your host needs to use PHP 5.4 or higher!');
}
if (!defined('_ZDEFINE')) {
    require_once __DIR__ . '/defines.php';
}

set_include_path(get_include_path() . PATH_SEPARATOR . CLASS_DIR);
spl_autoload_extensions(".class.php");
spl_autoload_register(spl_autoload);

function is_associative_array(array $array) {
    return array_keys($arr) !== range(0, count($arr) - 1);
}

class Base {
    public static function curl_request($url, $postData, $cookie, array $options = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        if (isset($postData) && !empty($postData)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        if (isset($cookie) && !empty($cookie)) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if (isset($options) && !empty($options)) {
            curl_setopt_array($ch, $options);
        }
        $result = curl_exec($ch);
        curl_close($ch);

        //$timecount = microtime(1) - $time1;
        //Log::addRuntimeLog("curl close, time count:{$timecount}");

        if ($result === FALSE) {
            Log::addErrorLog("curl_request failed, \$url is $url");
            return FALSE;
        }
        return $result;
    }
}

require_once 'startup.php';

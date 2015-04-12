<?php

defined('_ZEXEC') or die;

class Log {

    private static function getCurrentTime() {
        $currentTime = date("Y-n-j, G:i:s, D, e: ");
        return $currentTime;
    }

    public static function addAccessLog() {
        $query = $_SERVER["QUERY_STRING"];
        $currentTime = Log::getCurrentTime();
        $logfile = fopen(ZPATH_ACCESS_LOG, 'a') or die('add access log, can not add access log file');
        $log = "\n============================================\n";
        $log .= $currentTime . "get: " . $query . ", post: ";
        $log .= $GLOBALS['HTTP_RAW_POST_DATA'];
        if (1) {
            $log .= PHP_EOL . 'post query:'.PHP_EOL;
            foreach ($_POST as $name => $value) {
                $log .= $name.'=>'.$value.PHP_EOL;
            }
            /*$log .= PHP_EOL . 'server string:'.PHP_EOL;
            foreach ($_SERVER as $name => $value) {
                $log .= $name.'=>'.$value.PHP_EOL;
            }*/
            $log .= PHP_EOL . 'request string:'.PHP_EOL;
            foreach ($_REQUEST as $name => $value) {
                $log .= $name.'=>'.$value.PHP_EOL;
            }
        }
        $log = $log . "From: " . $_SERVER['REMOTE_ADDR'] . ', ' . $_SERVER["HTTP_USER_AGENT"];
        $log = $log . PHP_EOL;
        fwrite($logfile, $log);
        fclose($logfile);
    }

    public static function addErrorLog($message) {
        $currentTime = Log::getCurrentTime();
        ;
        $logfile = fopen(ZPATH_ERROR_LOG, 'a') or die('add error log, can not open error log file');
        $log = $currentTime . $message . PHP_EOL;
        fwrite($logfile, $log);
        fclose($logfile);
    }

    public static function addRuntimeLog($message) {
        $currentTime = Log::getCurrentTime();
        ;
        $logfile = fopen(ZPATH_RUNTIME_LOG, 'a') or die('add runtime log, can not open runtime log file');
        $log = $currentTime . $message . PHP_EOL;
        fwrite($logfile, $log);
        fclose($logfile);
    }

    public static function clearAccessLog() {
        $logfile = fopen(ZPATH_ACCESS_LOG, 'w+') or die("clear access log, can not open access log file");
        $clearmessage = 'log clear at ' . Log::getCurrentTime();
        fwrite($logfile, $clearmessage . PHP_EOL);
        fclose($logfile);
        return $clearmessage;
    }

    public static function clearErrorLog() {
        $logfile = fopen(ZPATH_ERROR_LOG, 'w+') or die("clear error log, can not open error log file");
        $clearmessage = 'log clear at ' . Log::getCurrentTime();
        fwrite($logfile, $clearmessage . PHP_EOL);
        fclose($logfile);
        return $clearmessage;
    }

    public static function clearRuntimeLog() {
        $logfile = fopen(ZPATH_RUNTIME_LOG, 'w+') or die("clear runtime log, can not open runtime log file");
        $clearmessage = 'log clear at ' . Log::getCurrentTime();
        fwrite($logfile, $clearmessage . PHP_EOL);
        fclose($logfile);
        return $clearmessage;
    }

}

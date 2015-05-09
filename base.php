<?php

/*
 * Copyright 2015 master.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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

function is_associative_array(array $arr) {
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
        $error = curl_error($ch);
        curl_close($ch);

        //$timecount = microtime(1) - $time1;
        //Log::addRuntimeLog("curl close, time count:{$timecount}");

        if ($result === FALSE) {

            Log::addErrorLog("curl_request failed. {$error}. \$url is $url");
            return FALSE;
        }
        return $result;
    }

    public static function browser_request($url, $get, $post, $options) {
        $charset = "UTF-8";
        $useURL = $url;
        $cookieURL = $url;
        $accept = "";
        $matches = array();
        if (preg_match('/(\S+):\/\/([^\/:]+)(:\d*)?([^# ]*)/', $url, $matches)) {
            $cookieURL = $matches[2];
            $accept = $matches[4];
        } elseif (preg_match('/([^\/:]+)(:\d*)?([^# ]*)/', $url, $matches)) {
            $cookieURL = $matches[1];
            $accept = $matches[3];
        }
        $proccessHeader = function($ch, $header_line) use(&$charset, &$cookieURL) {
            $matches = array();
            if ($charset && preg_match_all('/charset=(.*)/i', $header_line, $matches)) {
                $charset = trim(array_pop($matches[1]));
            }
            if ($charset && preg_match_all('/Content-Type:\s*image[^;]*/i', $header_line, $matches)) {
                $charset = NULL;
            }
            if (preg_match("/set\-cookie:([^\r\n]*)/i", $header_line, $matches)) {
                $_SESSION["browser_cookie_{$cookieURL}"] = $matches[1];
            }
            return strlen($header_line);
        };
        $ch = curl_init();
        if (isset($get) && !empty($get)) {
            $useURL .= "?{$get}";
        }
        curl_setopt($ch, CURLOPT_URL, $useURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        if (isset($post) && !empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if (isset($_SESSION["browser_cookie_{$cookieURL}"])) {
            curl_setopt($ch, CURLOPT_COOKIE, $_SESSION["browser_cookie_{$cookieURL}"]);
        }
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, $proccessHeader);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36");
        if (preg_match('/.*\.json$/i', $accept)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json, text/javascript, */* ; q=0.01']);
        }
        if (isset($options) && !empty($options)) {
            curl_setopt_array($ch, $options);
        }
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($result === FALSE) {
            return FALSE;
        }
        if ($charset) {
            $body = trim((iconv($charset, "UTF-8//IGNORE", $result)));
            return $body;
        } else {
            return $result;
        }
    }

    /**
     * Receives and excutes the data section in Global Ajax Template. See call.js<br>
     * If the <i>$data</i> is not specified, this method will get data from <i>php://input</i>, and call this method itself with <i>$data</i> specified.<br>
     * If the <i>$data</i> is specified, the method will call the function.<br>
     * If the <i>$data</i> is empty/null/false, simply return FALSE.<br>
     * @param object/array $data <i>[Optional] Require an OBJECT like {class_flag: 1, class: 'foo',func: 'bar', args: [1, 2]}. See call.js.
     * @return mixed Returns the return value of the callback. Returns TRUE if there are multiple functions to be called. Returns FALSE on failed.
     */
    public static function call($data) {
        if (isset($data)) {
            if (!is_associative_array($data)) {         // make sure that $data is associative array.
                return FALSE;
            } elseif (!$data['func']) {                   // if $data['func'] is false, means everything goes well an nothing to do.
                return TRUE;
            }
            if ($data['class']) {
                if ($data['class_flag'] === 1 || strtolower($data['class_flag']) === 'session') {      // class_flag === 1, means this class is saved in $_SESSION.
                    return call_user_func_array(array($_SESSION[$data['class']], $data['func']), $data['args']);
                } elseif ($data['class_flag'] === 2 || strtolower($data['class_flag']) === 'static') { // class_flag === 2, means the func is an static method.
                    return call_user_func_array(array($data['class'], $data['func']), $data['args']);
                }
            } else {
                return call_user_func_array($data['func'], $data['args']);
            }
            return FALSE;
        } else {
            if ($json = json_decode(file_get_contents('php://input'), true)) {
                if (!is_associative_array($json)) {
                    foreach ($json as $each) {
                        Base::call($each);
                    }
                    return TRUE;
                } else {
                    return Base::call($json);
                }
            }
        }
    }

}

include_once 'startup.php';

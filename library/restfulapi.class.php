<?php

/*
 * Copyright 2016 master.
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

/**
 * Description of restfulapi
 *
 * @author master
 */
class RESTfulAPI {
    // Read and write
    public $status = "";
    public $result = NULL;
    public $msg = "";
    
    // Read only
    public $request;
    public $input;
    public $method;
    
    private $api_location = array();
    private $current = 0;
    private $has_generate_output = false;
    
    public function __construct() {
        $this->status = HTTPStatus::Status_Not_Implemented;
        $this->result = NULL;
        $this->proccess_request();
    }
    
    public function __destruct() {
//        if (!$this->has_generate_output) {
//            $this->generate_output();
//        }
    }
    
    public function reset() {
        $this->current = 0;
    }
    public function next() {
        if ($this->current < count($this->api_location)) {
            return $this->api_location[$this->current++];
        } else {
            return FALSE;
        }
    }
    public function generate_output() {
        $this->has_generate_output = TRUE;
        $res = [
            "status" => $this->status,
            "code" => HTTPStatus::status_code_of($this->status),
            "msg" => $this->msg,
            //"request" => $this->api_location,
            "result" => &$this->result
        ];
        header("Content-Type: application/json");
        http_response_code($res["code"]);
        echo json_encode($res);
    }
    
    private function proccess_request() {
        // $str is a slash (/) prefixed string if not empty.
        $str = $_GET['__api_location'];
        if(isset($str) && !empty($str) && is_string($str)) {
            $this->api_location = explode('/', $str);
            // remove the empty string before the prefixed slash.
            array_shift($this->api_location);
        }
        
        $this->request = $_REQUEST;
        unset($this->request['__api_location']);
        $this->input = file_get_contents('php://input');
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
}

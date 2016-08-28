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

function PHPCall() {
    
    // '/call.php?&ajax=1' is recommended.
    this.url = '/call.php';
    
    // data can also be an indexed array(NOT OBJECT) contains multiple function call.
    this.data = {
        // Variable name of an instance of class saved in session => 1 or 'session', class name with static method => 2 or 'static'.
        // REQUIRED when class name is specified.
        class_flag: 'session',
        // Class name or null when not required.
        class: null,
        // Function name or null when not required. When null, args will be ignored.
        func: null,
        // ARRAY(may be empty) contains required function. (Some function with single argument may want an array.)
        args: []
    };
}
PHPCall.prototype.Call = function(success_callback, error_callback) {
    // console.log('connect start');
    $.ajax({
        type: 'POST',
        dataType: "json",
        url: this.url,
        data: JSON.stringify(this.data),
        contentType: 'application/json; charset=utf-8',
        success: success_callback,
        error: error_callback
    });
    // console.log('Ajas Request: ' + ajax_object);
}
PHPCall.prototype.Exec = function(func_name, args, class_name, class_flag, success_callback, error_callback) {
    if (func_name !== undefined && args !== undefined && success_callback !== undefined) {
        this.data.func = func_name;
        this.data.args = args;
    } else {
        return false;
    }
    if (class_name) {
        if (class_flag) {
            this.data.class = class_name;
            this.data.class_flag = class_flag;
        } else {
            return false;
        }
    }
    this.Call(success_callback, error_callback);
}

//PHPCall.url = '/call.php';
//PHPCall.data = {
//    class_flag: 'session',
//    class: null,
//    func: null,
//    args: []
//};
//PHPCall.Exec = PHPCall.prototype.Exec;
//PHPCall.Call = PHPCall.prototype.Call;

PHPCall.Call = function(success_callback, error_callback) {
    var temp_call = new PHPCall();
    temp_call.Call(success_callback, error_callback);
}
PHPCall.Exec = function(func_name, args, class_name, class_flag, success_callback, error_callback) {
    var temp_call = new PHPCall();
    temp_call.Exec(func_name, args, class_name, class_flag, success_callback, error_callback);
}
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


// REQUERE call.js

var curlopt = {
    httpheader: 10023
}
function curl_request(url, postData, cookie, options, success, error) {
    //var obj = new PHPCall();
    if (typeof postData != 'string') {
        postData = JSON.stringify(postData);
    }
    PHPCall.Exec("curl_request", [url, postData, cookie, options], "Base", "static", success, error);
}
function browser_request(url, get, post, options, resetCookie, success, error) {
    //var obj = new PHPCall();
    if (typeof post != 'string') {
        postData = JSON.stringify(post);
    }
    if (typeof get != 'string') {
        postData = JSON.stringify(get);
    }
    var reset = resetCookie === true ? true : false;
    PHPCall.Exec("browser_request", [url, get, post, options, reset], "Base", "static", success, error);
}
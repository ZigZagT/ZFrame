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

"use strict";

let ZFrame;

(function(){
    let block_logger_level = 0;
    let global_logger_level = 0;

    class Logger {
        constructor(level = global_logger_level) {
            this.log_print_metadata = true;
            this.log_level = level;
        }
        log(level, ...message) {
            if (level <= this.log_level) {
                console.log(...message);
                return [...message];
            }
        }
        error(...message) {
            if (this.log_print_metadata) {
                this.log(0, "ZFrame Error:");
            }
            return this.log(0, ...message);
        }
        warning(...message) {
            if (this.log_print_metadata) {
                this.log(1, "ZFrame Warning:");
            }
            return this.log(1, ...message);
        }
        notify(...message) {
            if (this.log_print_metadata) {
                this.log(2, "ZFrame Notify:");
            }
            return this.log(2, ...message);
        }
        debug(...message) {
            if (this.log_print_metadata) {
                this.log(3, "ZFrame Debug:");
            }
            return this.log(3, ...message);
        }
    };

    let block_logger = new Logger(block_logger_level);

    let getScriptURL = (function() {
        let scripts = document.getElementsByTagName('script');
        let index = scripts.length - 1;
        let myScript = scripts[index];
        block_logger.debug("current script: " + myScript.src);
        return function() { return myScript.src; };
    })();

    let getScriptDir = (()=>{
        let script = getScriptURL();
        let match = /(.*\/)[^/]*/;
        let res = match.exec(script);
        block_logger.debug("current script dir: " + res[1]);
        return ()=>{return res[1];};
    })();

    let load_script = (path) => {
        return new Promise((resolve, reject) => {
            block_logger.debug("loading script: " + path);
            let head = document.getElementsByTagName('head')[0];
            let script= document.createElement('script');
            script.type= 'text/javascript';
            script.onload = resolve;
            script.src= path;
            head.appendChild(script);
            block_logger.debug("script loading: " + path);
        });
    };
    let test_script_exist = (path) => {
        return new Promise((resolve, reject)=>{
            let http = new XMLHttpRequest();
            http.open('HEAD', path);
            http.onreadystatechange = function() {
                if (this.readyState == this.DONE) {
                    if (this.status == 404) {
                        block_logger.debug("script not exists: " + path);
                        resolve(false);
                    } else {
                        block_logger.debug("script exists: " + path);
                        resolve(true);
                    }
                }
            };
            http.send();
        });
    };

    let re1 = /^htt(p|ps):/;
    let re2 = /\//;
    let re3 = /\.min\.js$/;
    let re4 = /\.js$/;
    let findScript = (name) => {
        return new Promise((resolve, reject)=>{
            if (re1.test(name) || re2.test(name)) {
                resolve(name);
            }
            if (re3.test(name) || re4.test(name)) {
                let counter = 0;
                for (let path of [getScriptDir() + name, getScriptDir() + "thirdparty/" + name]) {
                    test_script_exist(path).then((r)=>{
                        ++counter;
                        if (r) {
                            resolve(path);
                        } else if (counter == 2) {
                            reject("cannot find script: " + name);
                        }
                    });
                }
            }
            let try_path = [
                getScriptDir() + name + ".min.js",
                getScriptDir() + "thirdparty/" + name + ".min.js",
                getScriptDir() + name + ".js",
                getScriptDir() + "thirdparty/" + name + ".js"
            ];
            let counter = 0;
            for (let path of try_path) {
                test_script_exist(path).then((r)=>{
                    ++counter;
                    if (r) {
                        resolve(path);
                    } else if (counter == try_path.length) {
                        reject("cannot find script: " + name);
                    }
                });
            }
        }).then((n)=>{
            block_logger.debug("script found: " + n);
            return n;
        }).catch((e)=>{
            block_logger.error(e);
            throw e;
        });
    };

    let loading_stack = new Array();
    let onload_queue = new Array();

    let ZFrame_class = class ZFrame extends Logger {
        constructor() {
            super();
            this.script_url = getScriptURL();
        }
        using(module_name) {
            let n = loading_stack.push(1);
            block_logger.debug(n + " module(s) are in loading");
            findScript(module_name).then(load_script).then((s)=>{
                block_logger.notify("script loded: ", s.target.src);
                loading_stack.pop();
                if (loading_stack.length == 0) {
                    block_logger.debug("loading stack is clear, call onload callbacks");
                    let count = onload_queue.length;
                    while (count > 0 && loading_stack.length == 0) {
                        --count;
                        onload_queue.pop()();
                    }
                }
            });
        }
        onload(callback) {
            if (callback instanceof Function) {
                if (loading_stack.length == 0) {
                    block_logger.debug("loading stack is empty, call onload callback now.");
                    callback();
                } else {
                    block_logger.debug("loading stack is not empty, add onload callback to queue.");
                    onload_queue.unshift(callback);
                }
            } else {
                block_logger.notify("onload callback is not a function, skipping.");
            }
        }
    };

    ZFrame = new ZFrame_class();
})()

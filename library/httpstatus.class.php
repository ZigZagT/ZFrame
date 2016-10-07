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

defined('ZEXEC') or die;

/**
 * Description of HTTPStatus
 *
 * @author master
 */
class HTTPStatus {
    const Continue_ = "Continue";
    const Switching_Protocols = "Switching Protocols";
    const OK = "OK";
    const Created = "Created";
    const Accepted = "Accepted";
    const Non_Authoritative_Information = "Non-Authoritative Information";
    const No_Content = "No Content";
    const Reset_Content = "Reset Content";
    const Partial_Content = "Partial Content";
    const Multiple_Choices = "Multiple Choices";
    const Moved_Permanently = "Moved Permanently";
    const Found = "Found";
    const See_Other = "See Other";
    const Not_Modified = "Not Modified";
    const Use_Proxy = "Use Proxy";
    const Temporary_Redirect = "Temporary Redirect";
    const Bad_Request = "Bad Request";
    const Unauthorized = "Unauthorized";
    const Payment_Required = "Payment Required";
    const Forbidden = "Forbidden";
    const Not_Found = "Not Found";
    const Method_Not_Allowed = "Method Not Allowed";
    const Not_Acceptable = "Not Acceptable";
    const Proxy_Authentication_Required = "Proxy Authentication Required";
    const Request_Timeout = "Request Timeout";
    const Conflict = "Conflict";
    const Gone = "Gone";
    const Length_Required = "Length Required";
    const Precondition_Failed = "Precondition Failed";
    const Request_Entity_Too_Large = "Request Entity Too Large";
    const Request_URI_Too_Long = "Request-URI Too Long";
    const Unsupported_Media_Type = "Unsupported Media Type";
    const Requested_Range_Not_Satisfiable = "Requested Range Not Satisfiable";
    const Expectation_Failed = "Expectation Failed";
    const Internal_Server_Error = "Internal Server Error";
    const Not_Implemented = "Not Implemented";
    const Bad_Gateway = "Bad Gateway";
    const Service_Unavailable = "Service Unavailable";
    const Gateway_Timeout = "Gateway Timeout";
    const HTTP_Version_Not_Supported = "HTTP Version Not Supported";
    
    public static function status_code_of($status) {
        $dict = [
            HTTPStatus::Continue_ => 100 ,
            HTTPStatus::Switching_Protocols => 101 ,
            HTTPStatus::OK => 200 ,
            HTTPStatus::Created => 201 ,
            HTTPStatus::Accepted => 202 ,
            HTTPStatus::Non_Authoritative_Information => 203 ,
            HTTPStatus::No_Content => 204 ,
            HTTPStatus::Reset_Content => 205 ,
            HTTPStatus::Partial_Content => 206 ,
            HTTPStatus::Multiple_Choices => 300 ,
            HTTPStatus::Moved_Permanently => 301 ,
            HTTPStatus::Found => 302 ,
            HTTPStatus::See_Other => 303 ,
            HTTPStatus::Not_Modified => 304 ,
            HTTPStatus::Use_Proxy => 305 ,
            HTTPStatus::Temporary_Redirect => 307 ,
            HTTPStatus::Bad_Request => 400 ,
            HTTPStatus::Unauthorized => 401 ,
            HTTPStatus::Payment_Required => 402 ,
            HTTPStatus::Forbidden => 403 ,
            HTTPStatus::Not_Found => 404 ,
            HTTPStatus::Method_Not_Allowed => 405 ,
            HTTPStatus::Not_Acceptable => 406 ,
            HTTPStatus::Proxy_Authentication_Required => 407 ,
            HTTPStatus::Request_Timeout => 408 ,
            HTTPStatus::Conflict => 409 ,
            HTTPStatus::Gone => 410 ,
            HTTPStatus::Length_Required => 411 ,
            HTTPStatus::Precondition_Failed => 412 ,
            HTTPStatus::Request_Entity_Too_Large => 413 ,
            HTTPStatus::Request_URI_Too_Long => 414 ,
            HTTPStatus::Unsupported_Media_Type => 415 ,
            HTTPStatus::Requested_Range_Not_Satisfiable => 416 ,
            HTTPStatus::Expectation_Failed => 417 ,
            HTTPStatus::Internal_Server_Error => 500 ,
            HTTPStatus::Not_Implemented => 501 ,
            HTTPStatus::Bad_Gateway => 502 ,
            HTTPStatus::Service_Unavailable => 503 ,
            HTTPStatus::Gateway_Timeout => 504 ,
            HTTPStatus::HTTP_Version_Not_Supported => 505 
        ];
        return $dict[$status];
    }
}

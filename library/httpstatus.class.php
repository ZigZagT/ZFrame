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
 * Description of HTTPStatus
 *
 * @author master
 */
class HTTPStatus {
    const Status_Continue = "Continue";
    const Status_Switching_Protocols = "Switching Protocols";
    const Status_OK = "OK";
    const Status_Created = "Created";
    const Status_Accepted = "Accepted";
    const Status_Non_Authoritative_Information = "Non-Authoritative Information";
    const Status_No_Content = "No Content";
    const Status_Reset_Content = "Reset Content";
    const Status_Partial_Content = "Partial Content";
    const Status_Multiple_Choices = "Multiple Choices";
    const Status_Moved_Permanently = "Moved Permanently";
    const Status_Found = "Found";
    const Status_See_Other = "See Other";
    const Status_Not_Modified = "Not Modified";
    const Status_Use_Proxy = "Use Proxy";
    const Status_Temporary_Redirect = "Temporary Redirect";
    const Status_Bad_Request = "Bad Request";
    const Status_Unauthorized = "Unauthorized";
    const Status_Payment_Required = "Payment Required";
    const Status_Forbidden = "Forbidden";
    const Status_Not_Found = "Not Found";
    const Status_Method_Not_Allowed = "Method Not Allowed";
    const Status_Not_Acceptable = "Not Acceptable";
    const Status_Proxy_Authentication_Required = "Proxy Authentication Required";
    const Status_Request_Timeout = "Request Timeout";
    const Status_Conflict = "Conflict";
    const Status_Gone = "Gone";
    const Status_Length_Required = "Length Required";
    const Status_Precondition_Failed = "Precondition Failed";
    const Status_Request_Entity_Too_Large = "Request Entity Too Large";
    const Status_Request_URI_Too_Long = "Request-URI Too Long";
    const Status_Unsupported_Media_Type = "Unsupported Media Type";
    const Status_Requested_Range_Not_Satisfiable = "Requested Range Not Satisfiable";
    const Status_Expectation_Failed = "Expectation Failed";
    const Status_Internal_Server_Error = "Internal Server Error";
    const Status_Not_Implemented = "Not Implemented";
    const Status_Bad_Gateway = "Bad Gateway";
    const Status_Service_Unavailable = "Service Unavailable";
    const Status_Gateway_Timeout = "Gateway Timeout";
    const Status_HTTP_Version_Not_Supported = "HTTP Version Not Supported";
    
    public static function status_code_of($status) {
        $dict = [
            HTTPStatus::Status_Continue => 100,
            HTTPStatus::Status_Switching_Protocols => 101,
            HTTPStatus::Status_OK => 200,
            HTTPStatus::Status_Created => 201,
            HTTPStatus::Status_Accepted => 202,
            HTTPStatus::Status_Non_Authoritative_Information => 203,
            HTTPStatus::Status_No_Content => 204,
            HTTPStatus::Status_Reset_Content => 205,
            HTTPStatus::Status_Partial_Content => 206,
            HTTPStatus::Status_Multiple_Choices => 300,
            HTTPStatus::Status_Moved_Permanently => 301,
            HTTPStatus::Status_Found => 302,
            HTTPStatus::Status_See_Other => 303,
            HTTPStatus::Status_Not_Modified => 304,
            HTTPStatus::Status_Use_Proxy => 305,
            HTTPStatus::Status_Temporary_Redirect => 307,
            HTTPStatus::Status_Bad_Request => 400,
            HTTPStatus::Status_Unauthorized => 401,
            HTTPStatus::Status_Payment_Required => 402,
            HTTPStatus::Status_Forbidden => 403,
            HTTPStatus::Status_Not_Found => 404,
            HTTPStatus::Status_Method_Not_Allowed => 405,
            HTTPStatus::Status_Not_Acceptable => 406,
            HTTPStatus::Status_Proxy_Authentication_Required => 407,
            HTTPStatus::Status_Request_Timeout => 408,
            HTTPStatus::Status_Conflict => 409,
            HTTPStatus::Status_Gone => 410,
            HTTPStatus::Status_Length_Required => 411,
            HTTPStatus::Status_Precondition_Failed => 412,
            HTTPStatus::Status_Request_Entity_Too_Large => 413,
            HTTPStatus::Status_Request_URI_Too_Long => 414,
            HTTPStatus::Status_Unsupported_Media_Type => 415,
            HTTPStatus::Status_Requested_Range_Not_Satisfiable => 416,
            HTTPStatus::Status_Expectation_Failed => 417,
            HTTPStatus::Status_Internal_Server_Error => 500,
            HTTPStatus::Status_Not_Implemented => 501,
            HTTPStatus::Status_Bad_Gateway => 502,
            HTTPStatus::Status_Service_Unavailable => 503,
            HTTPStatus::Status_Gateway_Timeout => 504,
            HTTPStatus::Status_HTTP_Version_Not_Supported => 505
        ];
        return $dict[$status];
    }
}

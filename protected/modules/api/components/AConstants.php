<?php

//module constants
class AConstants {
    const DEFAULT_PAGING = 10;
    const USER_TOKEN_EXPIRES_IN = 86400; //one day in seconds
    const ACCESS_TOKEN_EXPIRES_IN = 86400; //one day in seconds
    const TYPE_YES = 'yes';
    const TYPE_NO = 'no';    

    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 0;

    const SUCCESS = 'success';
    const ERROR = 'error';
    
    const HTTP_STATUS_100 = 100;
    const HTTP_STATUS_200 = 200;
    const HTTP_STATUS_201 = 201;
    const HTTP_STATUS_400 = 400; //Bad Request
    const HTTP_STATUS_401 = 401; //Unauthorized
    const HTTP_STATUS_403 = 403; //Forbidden
    const HTTP_STATUS_404 = 404; // Not Found
    const HTTP_STATUS_500 = 500; //Internal Server Error
    const HTTP_STATUS_501 = 501; //Not Implemented

    public static $ARR_HTTP_CODES = [
        self::HTTP_STATUS_100 => 'Continue',
        101 => 'Switching Protocols',
        self::HTTP_STATUS_200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    ];
    
    public static $ARR_RES_STATUS = [
        self::STATUS_SUCCESS => 'success',
        self::STATUS_ERROR => 'error',
    ];
    
    public static $ComparisonOperatorsMap = [
        'eq' => '=',
        'ne' => '!=',
        'gt' => '>',
        'ge' => '>=',
        'lt' => '<',
        'le' => '<=',
    ];
    
}

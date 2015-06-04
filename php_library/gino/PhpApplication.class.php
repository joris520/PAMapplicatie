<?php

class PhpApplication {


    /**
    * Transforms $_SERVER HTTP headers into a nice associative array. For example:
    *   array(
    *       'Referer' => 'example.com',
    *       'X-Requested-With' => 'XMLHttpRequest'
    *   )
    */
    
    static function getSessionIdentifier()
    {
        return session_id();
    }
    
    static function getRequestHeaders() {
        $headers = array();
        foreach($_SERVER as $key => $value) {
            if(strpos($key, 'HTTP_') === 0) {
                $headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
            }
        }
        return $headers;
    }

    static function getRequestHttpHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    static function getRequestUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    static function getRequestRemoteAddress()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    static function isDisplayErrorsAllowed()
    {
        return (ini_get('display_errors') == 1);
    }

}
?>

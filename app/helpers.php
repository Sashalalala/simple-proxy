<?php
/**
 * @param $path string
 * @return string
 * Remove slash from url path if it exists
 */
function pathUnslash( $path ){
    $len = strlen($path);
    $pos = strpos($path,'/', $len - 1);
    if($path !=='/' && $pos === strlen($path) - 1){
        return substr($path, '0', $len-1);
    }

    return $path;
}

/**
 * @param $code int Error code
 * @param $message string Erroe message
 * @return string
 */
function errorResponseFormatter($code, $message):string {
    $responce = [
        'success'=>false,
        'errorCode'=>$code,
        'message'=>$message
    ];

    return json_encode($responce);
}

/**
 * @return array
 */
function getRequestHeaders(){

    if(function_exists('getallheaders')){

        return getallheaders();
    } else {
        $headers = [];
        foreach($_SERVER as $name => $value){

            if(substr($name, 0, 5) == 'HTTP_')
            {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }

            if($name === 'CONTENT_TYPE'){
                $headers['Content-Type'] = $value;
            }

        }

        return $headers;
    }
}
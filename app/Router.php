<?php


class Router {

    private static $path;

    private static $routes;

    private function __construct(){}

    private function __clone(){}

    private static function setPath(){
        $uri= $_SERVER['REQUEST_URI'];
        $path = pathUnslash(parse_url($uri)['path']);
        self::$path = $path;
    }

    /**
     * @return string
     */

    private static function getPath(){
        if(!self::$path){
            self::setPath();
        }
        return self::$path;
    }

    /**
     * @return bool
     */
    private static function forward($path, $callBack){
        if($path === self::getPath()){
            $callBack();
            return true;
        }
        return false;
    }

    public static function addRoute($path,  $callback){
        self::$routes[] = [$path, $callback];
    }

    /**
     * Start routing, return false if route not found
     * @return bool
     */
    public static function start(){
        if(!empty(self::$routes)){
            foreach (self::$routes as $route){
                    $isForward = self::forward($route[0], $route[1]);
                    if($isForward) return $isForward;
            }
        }
        header('HTTP/1.0 404 Not Found');
        return false;
    }
}
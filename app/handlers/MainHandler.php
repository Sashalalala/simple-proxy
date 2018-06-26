<?php

class MainHandler extends RequestHandler{

    public static function init()
    {   //allow origin
        header('Access-Control-Allow-Origin: *');
        (new Proxy())->init();
    }

}
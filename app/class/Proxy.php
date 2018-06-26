<?php

class Proxy {

    const destinationServerUrl =  DEST_SERVER_URL;


    private $requestHeaders = [];
    private $responseHeaders = ['Content-Type: application/json'];

    private $requestBody;
    private $responseBody;

    public function init(){

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method){
            case 'POST':{
                $this->sendPost();
                break;
            }
            default:{
                $this->responseHeaders[] = 'HTTP/1.0 400 Bad request';
                $this->responseBody =  errorResponseFormatter(400, 'Bad request method');
            }
        }

        $this->sendClientResponse();
        exit;
    }

    private function sendClientResponse(){
        foreach ($this->responseHeaders as $header){
            header($header);
        }
        echo $this->responseBody;
    }

    private function sendPost(){

        $this->requestHeaders = getRequestHeaders();

        if( $this->requestHeaders['Content-Type'] !== 'application/json'){
            $this->responseHeaders[] = 'HTTP/1.0 400 Bad request';
            $this->responseBody =  errorResponseFormatter(400, 'Bad Content type');
            return;
        }

        $this->requestBody = file_get_contents('php://input');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::destinationServerUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->requestHeaders);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);

        $result = curl_exec($ch);
        curl_close($ch);
        $this->responseBody = $result;
    }

}
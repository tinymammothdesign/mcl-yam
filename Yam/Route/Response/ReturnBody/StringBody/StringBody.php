<?php

namespace Yam\Route\Response\ReturnBody\StringBody;

use Yam\Route\Response\ReturnBody\IReturnBody;

final class StringBody implements IReturnBody{

    private $payload = "";

    public function __construct($payload){
        if (is_string($payload)){
            $this->payload = $payload;
        }else{
            throw new EInvalidBodyType();
        }
    }

    public function getAsResponseBody(){
        return $this->payload;
    }

}
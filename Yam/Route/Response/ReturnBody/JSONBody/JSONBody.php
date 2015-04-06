<?php

namespace Yam\Route\Response\ReturnBody\JSONBody;

use Yam\Route\Response\ReturnBody\IReturnBody;

final class JSONBody implements IReturnBody{

    private $payload = "";

    public function __construct(array $payload){
        $this->payload = $payload;
    }

    public function getAsResponseBody(){
        return json_encode($this->payload, JSON_PRETTY_PRINT);
    }

}
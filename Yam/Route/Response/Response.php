<?php

namespace Yam\Route\Response;

use Yam\Route\Response\ReturnBody\IReturnBody;
use Yam\Route\ValueObjects\GenericETag\GenericETag;

class Response{

    /**
     * @var \Slim\Http\Response
     */
    protected $response;

    /**
     * @var \Yam\Route\Response\ReturnBody\IReturnBody
     */
    protected $returnBody = NULL;

    private function headerExists($headerName){
        $header = $this->response->headers->get($headerName);
        return isset($header);
    }

    public function __construct(\Slim\Http\Response $slimResponse){
        $this->response = $slimResponse;
    }

    public function setHeader($name, $value){
        $this->response->header($name, $value);
    }

    public function setETag(GenericETag $ETag){
        $this->setHeader("Etag", $ETag->toNativeType());
    }

    public function setReturnBody(IReturnBody $returnBody){
        $this->returnBody = $returnBody;
    }

    public function getReturnBody(){
        return $this->returnBody;
    }

}
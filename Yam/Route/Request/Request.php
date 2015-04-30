<?php

namespace Yam\Route\Request;

use Yam\Route\ValueObjects\GenericAuthorization\GenericAuthorization;
use Yam\Route\ValueObjects\GenericETag\GenericETag;

class Request{

    /**
     * @var \Slim\Http\Request
     */
    protected $request;

    private function headerExists($headerName){
        $header = $this->request->headers->get($headerName);
        return isset($header);
    }

    public function __construct(\Slim\Http\Request $slimRequest){
        $this->request = $slimRequest;
    }

    public function getHeader($name){
        return $this->request->headers->get($name);
    }

    public function hasIfNoneMatchCondition(){
        return $this->headerExists("If-None-Match");
    }

    public function getIfNoneMatchCondition(){
        if ($this->hasIfNoneMatchCondition()){
            return new GenericETag($this->getHeader("If-None-Match"));
        }else{
            throw new ERequestHeaderMissing("If-None-Match header was requested but is not present.");
        }
    }

    public function hasAuthorization(){
        return $this->headerExists("Authorization");
    }

    public function getAuthorization(){
        if ($this->hasAuthorization()){
            return new GenericAuthorization($this->getHeader("Authorization"));
        }else{
            throw new ERequestHeaderMissing("Authorization header was requested but is not present.");
        }
    }

    public function getPostData(){
        return $this->request->post();
    }

    public function getBodyAsArray(){
        return json_decode($this->request->getBody(), JSON_OBJECT_AS_ARRAY);
    }
}
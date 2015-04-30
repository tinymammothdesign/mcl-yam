<?php

namespace Yam\Route;

use Yam\Route\Request\Request;
use Yam\Route\Response\Response;

abstract class AbstractRoute{

    /**
     * @var \Yam\Route\Request\Request
     */
    protected $request;

    /**
     * @var \Yam\Route\Response\Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $queryParams;

    public function fileLocation(){
        return __DIR__;
    }

    public function prepare(Request $request, Response $response, array $queryParams){
        $this->response = $response;
        $this->request = $request;
        $this->queryParams = $queryParams;
    }

    abstract public function execute();
}
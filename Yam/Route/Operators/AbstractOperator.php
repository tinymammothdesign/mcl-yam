<?php

namespace Yam\Route\Operators;

use Yam\Route\AbstractRoute;
use Yam\Route\Request\Request;
use Yam\Route\Response\Response;

abstract class AbstractOperator{

    private $bailOut;

    public function bailOut(){
        $this->bailOut = TRUE;
    }

    public function isBailedOut(){
        return $this->bailOut;
    }

    abstract public function executeOperator(Request $request, Response $response, AbstractRoute $route, array $annotations);

}
<?php

namespace Yam\Router\Router;

class EMissingRouteFactory extends \Exception{

    public function __construct(){
        return parent::__construct("Missing route factory. Please specify.");
    }

}
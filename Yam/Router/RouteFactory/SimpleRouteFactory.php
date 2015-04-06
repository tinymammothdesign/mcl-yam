<?php

namespace Yam\Router\RouteFactory;

class SimpleRouteFactory implements IRouteFactory{

    public function instantiateRoute($routeClassName){
        return new $routeClassName;
    }

}
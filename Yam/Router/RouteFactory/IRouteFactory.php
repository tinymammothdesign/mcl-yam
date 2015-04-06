<?php

namespace Yam\Router\RouteFactory;

interface IRouteFactory{

    public function instantiateRoute($routeClassName);

}
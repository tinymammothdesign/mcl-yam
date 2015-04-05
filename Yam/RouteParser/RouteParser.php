<?php

namespace Yam\RouteParser;

use Yam\RouteWrapper\RouteWrapper;

class RouteParser{

    protected $xml;

    protected $routeWrappers = [];

    private function extractOperators($operatorXMLRoot, RouteWrapper &$wrapper){
        foreach($operatorXMLRoot as $anOperator){
            $annotations = [];
            foreach($anOperator->children() as $key => $value){
                $annotations[(string)$key] = (string)$value;
            }

            $wrapper->addOperator((string)$anOperator->attributes()->name, $annotations);
        }
    }

    private function parseRoutes(){
        foreach($this->xml->routes->route as $aRoute){
            $attributes = $aRoute->attributes();
            $name = (string)$attributes->name;
            $handler = (string)$attributes->handler;

            /** Extract each route */
            $wrapper = new RouteWrapper($name, $handler);
            foreach($aRoute->endpoint as $endpoint){
                $method = (string)$endpoint->attributes()->method;
                $endpoint = (string)$endpoint;
                $wrapper->addEndpoint($endpoint, $method);
            }

            /** Add each of the operators from the route */
            $this->extractOperators($aRoute->operators->operator, $wrapper);
            $this->routeWrappers[] = $wrapper;
        }
    }

    public function getRouteWrappers(){
        return $this->routeWrappers;
    }

    public function parse($routeDefinitions){
        $this->xml = simplexml_load_file($routeDefinitions);
        $this->parseRoutes();
    }
}
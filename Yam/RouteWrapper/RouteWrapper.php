<?php

namespace Yam\RouteWrapper;

class RouteWrapper{

    private $label;
    private $routeClassName;
    private $endpoints = [];
    private $operatorList;

    public function __construct($label, $routeClassName){
        $this->label = $label;
        $this->routeClassName = $routeClassName;
    }

    public function addEndpoint($endpoint, $method){
        $this->endpoints[] = ["Endpoint" => $endpoint, "Method" => $method];
    }

    public function routeClassName(){
        return $this->routeClassName;
    }

    public function label(){
        return $this->label;
    }

    public function endpoints(){
        return $this->endpoints;
    }

    public function operatorList(){
        return $this->operatorList;
    }

    public function addOperator($name, $annotations){
        $this->operatorList[] = array(
            "Name" => $name,
            "Annotations" => $annotations
        );
    }

}
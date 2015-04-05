<?php

namespace Yam\Route\Operators\OperatorCollection;

use Yam\Route\Operators\AbstractOperator;

class OperatorCollection{

    protected $operators = [];

    public function add(AbstractOperator $operator, $name){
        $this->operators[$name] = $operator;
    }

    public function findByName($name){
        return $this->operators[$name];
    }

}
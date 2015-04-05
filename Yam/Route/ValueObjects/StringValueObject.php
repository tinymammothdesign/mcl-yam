<?php

namespace Yam\Route\ValueObjects;

class StringValueObject{

    protected $value;

    public function __construct($value){
        $this->value = $value;
    }

    public function toNativeType(){
        return $this->value;
    }

}
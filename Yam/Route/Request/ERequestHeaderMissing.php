<?php

namespace Yam\Route\Request;

class ERequestHeaderMissing extends \Exception{

    public function __construct($message){
        parent::__construct($message);
    }

}
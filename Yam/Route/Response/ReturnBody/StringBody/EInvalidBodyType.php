<?php

namespace Yam\Route\Response\ReturnBody\StringBody;

final class EInvalidBodyType extends \Exception{

    public function __construct(){
        parent::__construct("The value given to StringBody is not a string.");
    }

}
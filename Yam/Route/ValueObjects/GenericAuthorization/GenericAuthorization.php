<?php

namespace Yam\Route\ValueObjects\GenericAuthorization;

use Yam\Route\ValueObjects\StringValueObject;

class GenericAuthorization extends StringValueObject{

    public function getTokenAsBearer(){
        return str_replace("bearer ", "", $this->value);
    }

}
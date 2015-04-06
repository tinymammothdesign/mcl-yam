<?php

namespace Yam\Route\Response\StatusCode;

class Status404 implements IStatusCode{

    public function toStatus(){
        return 404;
    }

} 
<?php

namespace Yam\Route\Response\StatusCode;

class StatusBadRequest implements  IStatusCode{

    public function toStatus(){
        return 400;
    }

} 
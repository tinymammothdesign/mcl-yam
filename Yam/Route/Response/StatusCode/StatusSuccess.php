<?php

namespace Yam\Route\Response\StatusCode;

class StatusSuccess implements  IStatusCode{

    public function toStatus(){
        return 200;
    }

} 
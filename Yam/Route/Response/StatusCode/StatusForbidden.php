<?php

namespace Yam\Route\Response\StatusCode;

class StatusForbidden implements IStatusCode{

    public function toStatus(){
        return 403;
    }

} 
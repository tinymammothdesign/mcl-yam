<?php

namespace Yam\Route\Response\StatusCode;

class StatusUnprocessableEntity implements IStatusCode{

    public function toStatus(){
        return 422;
    }

} 
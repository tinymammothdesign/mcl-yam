<?php

namespace Yam\ExceptionHandler;

use Yam\Route\Response\Response;

interface IExceptionHandler {

    public function handle(\Exception $exception, Response &$response);

} 
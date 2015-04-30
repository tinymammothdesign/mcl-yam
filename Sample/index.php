<?php

require_once "../vendor/autoload.php";

class TestRoute extends \Yam\Route\AbstractRoute{

    public function execute(){
        $this->response->setETag(new \Yam\Route\ValueObjects\GenericETag\GenericETag("Hey there"));

        $body = new \Yam\Route\Response\ReturnBody\StringBody\StringBody("This is a return payload!");
        $this->response->setReturnBody($body);
        $this->response->setStatusCode(new \Yam\Route\Response\StatusCode\StatusBadRequest());

        throw new Exception("Hello");
    }

}

class TestOperator extends \Yam\Route\Operators\AbstractOperator{

    public function executeOperator(\Yam\Route\Request\Request $request, \Yam\Route\Response\Response $response,
        \Yam\Route\AbstractRoute $route, array $annotations){

        echo "Operator executed! <br>";
    }
}

class GenericExceptionHandler implements \Yam\ExceptionHandler\IExceptionHandler{

    public function handle(\Exception $exception, \Yam\Route\Response\Response &$response){
        $response->setReturnBody(new \Yam\Route\Response\ReturnBody\JSONBody\JSONBody(["Message" => "Exception!"]));
    }
}

$routeParser = new Yam\RouteParser\RouteParser();
$slim = new \Slim\Slim();

$router = new \Yam\Router\Router\Router($routeParser, $slim);
$router->registerOperator(new TestOperator(), "MyFirstOperator");
$router->setRouteFactory(new \Yam\Router\RouteFactory\SimpleRouteFactory());

$router->registerExceptionHandler(new GenericExceptionHandler(), "Exception");

$router->initialize(__DIR__ . "/routes.xml");
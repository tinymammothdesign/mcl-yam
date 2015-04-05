<?php

require_once "../vendor/autoload.php";

class TestRoute extends \Yam\Route\AbstractRoute{

    public function execute(){
        $this->response->setETag(new \Yam\Route\ValueObjects\GenericETag\GenericETag("Hey there"));

        $body = new \Yam\Route\Response\ReturnBody\StringBody\StringBody("This is a return payload!");
        $this->response->setReturnBody($body);
    }

}

class TestOperator extends \Yam\Route\Operators\AbstractOperator{

    public function executeOperator(\Yam\Route\Request\Request $request, \Yam\Route\Response\Response $response,
        \Yam\Route\AbstractRoute $route, array $annotations){

        echo "Operator executed! <br>";
    }
}

$routeParser = new Yam\RouteParser\RouteParser();
$slim = new \Slim\Slim();

$router = new \Yam\Router\Router($routeParser, $slim);
$router->registerOperator(new TestOperator(), "MyFirstOperator");
$router->initialize(__DIR__ . "/routes.xml");
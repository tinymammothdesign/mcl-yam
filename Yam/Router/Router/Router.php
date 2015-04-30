<?php

namespace Yam\Router\Router;

use Slim\Slim;
use Yam\ExceptionHandler\IExceptionHandler;
use Yam\Route\AbstractRoute;
use Yam\Route\Operators\OperatorCollection\OperatorCollection;
use Yam\Route\Request\Request;
use Yam\Route\Response\Response;
use Yam\RouteParser\RouteParser;
use Yam\Route\Response\ReturnBody\IReturnBody;
use Yam\Router\RouteFactory\IRouteFactory;

class Router{

    protected $routeParser;
    protected $routeWrappers;
    protected $slim;
    protected $operators;

    protected $exceptionHandlers = [];

    /**
     * @var \Yam\Router\RouteFactory\IRouteFactory
     */
    protected $routeFactory = NULL;

    protected function runOperators(AbstractRoute &$route, Request &$request, Response &$response, $operatorRequirements){
        foreach($operatorRequirements as $anOperator){
            $name = $anOperator["Name"];
            $annotations = $anOperator["Annotations"];

            /** @var $operator \Yam\Route\Operators\AbstractOperator */
            $operator = $this->operators->findByName($name);
            $operator->executeOperator($request, $response, $route, $annotations);
        }
    }

    public function registerExceptionHandler(IExceptionHandler $exceptionHandler, $forExceptionClass){
        $this->exceptionHandlers[$forExceptionClass] = $exceptionHandler;
    }

    protected function setupSlimRoutes(){
        if (NULL === $this->routeFactory){
            throw new EMissingRouteFactory();
        }

        foreach($this->routeWrappers as $aRouteWrapper){
            /** @var $aRouteWrapper \Yam\RouteWrapper\RouteWrapper */
            foreach($aRouteWrapper->endpoints() as $anEndpoint){
                $method = strtolower($anEndpoint["Method"]);
                $endpoint = $anEndpoint["Endpoint"];

                $class = $aRouteWrapper->routeClassName();
                $operators = $aRouteWrapper->operatorList();

                $slim = $this->slim;
                $self = $this;
                $this->slim->{$method}($endpoint, function() use ($class, $operators, $slim, $self){
                    $request = new Request($slim->request);
                    $response = new Response($slim->response);

                    /** @var $route \Yam\Route\AbstractRoute */
                    $route = $this->routeFactory->instantiateRoute($class);

                    try{
                        /** Run through all the operators */
                        $self->runOperators($route, $request, $response, $operators);

                        $queryParams = func_get_args();
                        $route->prepare($request, $response, $queryParams);

                        $route->execute();
                    }catch(\Exception $e){
                        if (isset($self->exceptionHandlers[get_class($e)])){
                            /** @var \Yam\ExceptionHandler\IExceptionHandler $eHandler */
                            $eHandler = $self->exceptionHandlers[get_class($e)];
                            $eHandler->handle($e, $response);
                        }else{
                            throw $e;
                        }
                    }

                    if ($response->getReturnBody() instanceof IReturnBody){
                        echo $response->getReturnBody()->getAsResponseBody();
                    }else{
                        throw new \Exception("Route '$class' does not return a IReturnBody object.");
                    }
                });
            }
        }
        $this->slim->run();
    }

    public function __construct(RouteParser $routeParser, Slim $slim){
        $this->routeParser = $routeParser;
        $this->slim = $slim;

        $this->operators = new OperatorCollection();
    }

    public function registerOperator($className, $name){
        $this->operators->add($className, $name);
    }

    public function setRouteFactory(IRouteFactory $routeFactory){
        $this->routeFactory = $routeFactory;
    }

    public function initialize($filename){
        $this->routeParser->parse($filename);
        $this->routeWrappers = $this->routeParser->getRouteWrappers();
        $this->setupSlimRoutes();
    }
}
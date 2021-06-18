<?php


namespace App;


use App\Http\Request;
use App\Http\Response;
use App\Utils\Config;
use App\Utils\Route as RouteHelper;
use Exception;
use Nette\Utils\JsonException;
use QuickRoute\Router\Collector;
use QuickRoute\Router\Dispatcher;
use QuickRoute\Router\DispatchResult;
use Swoole\Http\Request as SWRequest;
use Swoole\Http\Response as SWResponse;
use Throwable;

class RootServer
{
    protected static Dispatcher $dispatcher;

    /**
     * @throws Exception
     */
    public function __construct(Collector $collector, Dispatcher $dispatcher)
    {
        self::$dispatcher = $dispatcher;

        new RouteHelper($collector);

        self::bootServiceProviders();
    }

    /**
     * @param SWRequest $request
     * @param SWResponse $response
     * @throws JsonException
     */
    public function __invoke(SWRequest $request, SWResponse $response): void
    {
        $response->header('Access-Control-Allow-Origin', '*');
        $dResult = self::dispatch($request);

        $genResponse = new Response($response);
        $genRequest = new Request($request, $genResponse, $dResult);
        $genResponse->setRequest($genRequest);

        switch (true) {
            case $dResult->isFound():
                self::generateFoundResponse($genRequest, $dResult);
                break;
            case $dResult->isNotFound():
                self::generateNotFoundResponse($genRequest);
                break;
            default:
                self::generateMethodNotAllowedResponse($genRequest);
        }
    }

    /**
     * @throws Exception
     */
    protected static function bootServiceProviders(): void
    {
        $providers = Config::load('app')->get('providers');
        foreach ($providers as $provider) {
            (new $provider)->boot();
        }
    }

    protected static function dispatch(SWRequest $request): DispatchResult
    {
        return self::$dispatcher->dispatch(
            $request->server['request_method'],
            $request->server['request_uri'],
        );
    }

    protected static function generateFoundResponse(
        Request $request,
        DispatchResult $dispatchResult
    ): void
    {
        $handler = $dispatchResult->getRoute()->getHandler();
        if (is_callable($handler)) {
            $handler($request);
        }

        $controller = $handler[0];
        $method = $handler[1];

        try {
            $initController = new $controller();
            go(fn() => call_user_func_array([$initController, $method], [$request]));
        } catch (Throwable $exception) {
            $request->response()->html($exception);
        }
    }

    protected static function generateNotFoundResponse(Request $request): void
    {
        $request->response()->html('Not Found.', 404);
    }

    protected static function generateMethodNotAllowedResponse(Request $request): void
    {
        $request->response()->html('Method Not Allowed.', 405);
    }
}
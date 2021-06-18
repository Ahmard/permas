<?php


namespace App\Http;

use App\Utils\Auth;
use App\Utils\Validator;
use Illuminate\Validation\ValidationException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use QuickRoute\Router\DispatchResult;
use Swoole\Http\Request as SWRequest;


/**
 * Class Request
 * @package App\Http
 * @mixin SWRequest
 */
class Request
{
    protected Auth $auth;

    protected ?array $parsedJsonBody = null;

    protected bool $expectsJson = false;


    /**
     * @throws JsonException
     */
    public function __construct(
        protected SWRequest $request,
        protected Response $response,
        protected DispatchResult $dispatchResult
    )
    {
        $this->auth = new Auth();

        $this->expectsJson = str_contains(
            $this->request->header['content-type']
                ?? $this->request->header['Content-Type']
                ?? '',
            'application/json'
        );

        if ($this->expectsJson()) {
            $this->parseJsonBody();
        }
    }

    public function __get(string $name): mixed
    {
        return $this->request->$name;
    }

    public function __call(string $name, array $arguments): mixed
    {
        return $this->request->$name(...$arguments);
    }

    public function expectsJson(): bool
    {
        return $this->expectsJson;
    }

    /**
     * @return $this
     * @throws JsonException
     */
    public function parseJsonBody(): Request
    {
        $this->parsedJsonBody = Json::decode(
            $this->request->rawContent(),
            Json::FORCE_ARRAY
        );

        return $this;
    }

    /**
     * Get http post data, json body if json is parsed
     *
     * @param string|null $key
     * @return array|string|null
     */
    public function post(?string $key = null): array|string|null
    {
        if (!$key) {
            if ($this->parsedJsonBody) {
                return $this->parsedJsonBody;
            }

            return $this->request->post;
        }

        if ($this->parsedJsonBody) {
            return $this->parsedJsonBody[$key] ?? null;
        }

        return $this->request->post[$key] ?? null;
    }

    /**
     * Get http url params
     *
     * @param string|null $key
     * @return array|string|null
     */
    public function get(?string $key = null): array|string|null
    {
        if (!$key) {
            return $this->request->get;
        }

        return $this->request->get[$key];
    }


    /**
     * @param array $rules
     * @return Validator
     * @throws JsonException
     * @throws ValidationException
     */
    public function validate(array $rules): Validator
    {
        return Validator::validate($this, $rules);
    }

    public function auth(): Auth
    {
        return $this->auth;
    }

    public function response(): Response
    {
        return $this->response;
    }

    public function dispatchedResult(): DispatchResult
    {
        return $this->dispatchResult;
    }
}
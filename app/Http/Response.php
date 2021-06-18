<?php


namespace App\Http;


use App\Utils\Env;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Swoole\Http\Response as SWResponse;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Response
 * @package App\Http
 * @mixin SWResponse
 */
class Response
{
    protected Request $request;

    public function __construct(
        protected SWResponse $response,
    )
    {
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function __call(string $name, array $arguments): mixed
    {
        return $this->response->$name(...$arguments);
    }

    public function html(string $htmlCode, int $status = 200, array $headers = []): void
    {
        if ($this->response->isWritable()) {
            $this->end(
                $htmlCode,
                $status,
                array_merge(['Content-Type' => 'text/html'], $headers)
            );
        }
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function view(string $filePath, array $data = []): void
    {
        if (!$this->response->isWritable()) {
            return;
        }

        $filePath = !str_contains($filePath, '.twig') ? "$filePath.twig" : $filePath;

        $this->html(
            Env::templateEngine($this->request)
                ->render($filePath, $data)
        );
    }

    /**
     * @param array|object|null $encodeAble
     * @param int $status
     * @param array $headers
     * @throws JsonException
     */
    public function json(null|array|object $encodeAble, int $status = 200, array $headers = []): void
    {
        $this->end(
            Json::encode($encodeAble),
            $status,
            array_merge(['Content-Type' => 'application/json'], $headers)
        );
    }

    /**
     * @param string|array|object|null $encodeAble
     * @throws JsonException
     */
    public function jsonSuccess(null|string|array|object $encodeAble): void
    {
        $this->json([
            'status' => 200,
            'data' => $encodeAble,
            'success' => true
        ]);
    }

    /**
     * @param string|array|object|null $encodeAble
     * @throws JsonException
     */
    public function jsonError(null|string|array|object $encodeAble): void
    {
        $this->json([
            'status' => 200,
            'data' => $encodeAble,
            'success' => false
        ]);
    }

    public function dump(mixed $data, mixed ...$moreData): void
    {
        $this->write(self::createDump($data));

        foreach ($moreData as $datum) {
            $this->write(self::createDump($datum));
        }
    }

    public function dd(mixed $data, mixed ...$moreData): void
    {
        $this->dump($data, ...$moreData);
        $this->response->end();
    }

    protected static function createDump(mixed $data): string
    {
        $clonedData = (new VarCloner())->cloneVar($data);
        return (string)(new HtmlDumper(null))->dump($clonedData, true);
    }

    /**
     * @param mixed|null $content
     */
    public function end(mixed $content = null, int $status = 200, array $headers = []): void
    {
        if ($this->response->isWritable()) {
            foreach ($headers as $key => $value) {
                $this->response->setHeader($key, $value);
            }

            $this->response->setHeader('Server', $_ENV['APP_NAME']);
            $this->response->setStatusCode($status);
            $this->response->end($content);
        }
    }
}
<?php


namespace App\Utils;


use App\Http\Request;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator as IlluminateValidator;
use JetBrains\PhpStorm\Pure;
use Nette\Utils\JsonException;

class Validator
{
    protected IlluminateValidator $validator;

    protected bool $validationPasses = false;

    /**
     * @throws ValidationException
     * @throws JsonException
     */
    public static function validate(Request $request, array $rules): Validator
    {
        return new self($request, $rules);
    }

    /**
     * @param Request $request
     * @param array $rules
     */
    public function __construct(
        protected Request $request,
        array $rules,
    )
    {
        $translator = new Translator(new ArrayLoader(), 'en');
        $this->validator = new IlluminateValidator($translator, $request->post(), $rules);
        $this->validationPasses = $this->validator->passes();
    }

    public function check(): bool
    {
        return $this->validationPasses;
    }

    public function fails(): bool
    {
        return !$this->validationPasses;
    }

    #[Pure] public function getData(): array
    {
        return $this->validator->getData();
    }

    /**
     * @return array
     * @throws ValidationException
     */
    public function validated(): array
    {
        return $this->validator->validated();
    }

    /**
     * Send validation error response to client
     */
    public function sendErrorResponse(): void
    {
        $this->request
            ->response()
            ->jsonError($this->validator->errors());
    }

    /**
     * @return IlluminateValidator
     */
    public function getValidator(): IlluminateValidator
    {
        return $this->validator;
    }
}
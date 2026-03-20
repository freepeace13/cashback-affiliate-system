<?php

namespace Cashback\Support;

use Illuminate\Support\Facades\Validator;

abstract class ActionData
{
    protected array $messages = [];

    abstract public function rules(): array;

    public function getData(): array
    {
        return array_reduce(
            array_keys($this->rules()),
            fn($acc, $key) => array_merge($acc, [$key => $this->{$key}]),
            []
        );
    }

    public function validate(array $additionalMessages = []): array
    {
        return Validator::make(
            $this->getData(),
            $this->rules(),
            array_merge($additionalMessages, $this->messages)
        )->validate();
    }
}

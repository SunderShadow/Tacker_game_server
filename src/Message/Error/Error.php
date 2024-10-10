<?php

namespace Core\Message\Error;

use Core\Message\Message;

readonly class Error extends Message
{
    public function __construct(string $message = '', int $code = 400)
    {
        parent::__construct('error', [
            'code'    => 400,
            'message' => $message
        ]);
    }
}
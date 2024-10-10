<?php

namespace Core\Message;

readonly class Message
{
    public function __construct(
        public string $action,
        public array $data = []
    )
    {
    }
}
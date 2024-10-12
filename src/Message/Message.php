<?php

namespace Core\Message;

use Exception;

readonly class Message implements \JsonSerializable
{
    public function __construct(
        public string $action,
        public array $data = []
    )
    {
    }

    /**
     * @throws Exception
     */
    public static function fromJson(string $json): Message
    {
        if (!json_validate($json)) {
            throw new Exception('Not valid JSON');
        }

        $json = json_decode($json, true);

        if (!isset($json['action'])) {
            throw new Exception('Action field is required');
        }

        return new self($json['action'], $json['data'] ?? []);
    }

    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'data'   => $this->data
        ];
    }
}
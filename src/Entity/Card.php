<?php

namespace Core\Entity;

class Card implements \JsonSerializable
{
    const string TEMPLATE_PATTERN = '/___/';

    public readonly string $template;

    public Player $owner;

    public array $values = [];

    public function __construct()
    {
        $this->template = "Some ___ template";
    }

    public function jsonSerialize(): mixed
    {
        return [
            'owner_id' => $this->owner->id,
            'template' => $this->getFilled()
        ];
    }

    public function isFilled(): bool
    {
        return empty($this->values);
    }

    public function getFilled(): ?string
    {
        if ($this->isFilled()) {
            return null;
        }

        $i = 0;
        return preg_replace_callback(self::TEMPLATE_PATTERN, fn () => $this->values[$i++], $this->template);
    }
}
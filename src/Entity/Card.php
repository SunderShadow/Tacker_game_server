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

    /**
     * Check if template is complete
     * @return bool
     */
    public function isComplete(): bool
    {
        return empty($this->values);
    }

    /**
     * Get completed template
     * @return string|null
     */
    public function getCompleted(): ?string
    {
        if ($this->isComplete()) {
            return null;
        }

        $i = 0;
        return preg_replace_callback(self::TEMPLATE_PATTERN, fn () => $this->values[$i++], $this->template);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'owner_id' => $this->owner->id,
            'template' => $this->getCompleted()
        ];
    }

}
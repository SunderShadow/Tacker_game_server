<?php

namespace Core\Entity;

class Card
{
    public readonly string $template;

    public Player $owner;

    public array $values = [];

    public function __construct()
    {
        $this->template = "Some ___ template";
    }
}
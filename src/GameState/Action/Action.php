<?php

namespace Core\GameState\Action;

use Core\Game;
use Core\Player;

abstract class Action
{
    public function __construct(
        protected Player $invoker,
        protected readonly array $data,
        protected readonly Game $game
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        // TODO: implement validation
    }

    abstract public function __invoke(): void;
}
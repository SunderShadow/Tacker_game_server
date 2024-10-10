<?php

namespace Core\GameState;

use Core\Game;
use Core\GameState\Action\TestAction;

class PrepareCards extends GameState
{
    protected array $actions = [
        'action:test' => TestAction::class
    ];

    public function __construct(Game $game)
    {
        parent::__construct($game);
    }
}
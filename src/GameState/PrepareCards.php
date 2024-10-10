<?php

namespace Core\GameState;

use Core\GameState\Action\TestAction;

class PrepareCards extends GameState
{
    protected array $actions = [
        'action:test' => TestAction::class
    ];
}
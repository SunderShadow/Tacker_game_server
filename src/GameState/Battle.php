<?php

namespace Core\GameState;

class Battle extends GameState
{
    protected array $actions = [
        'vote' => Action\Vote::class
    ];

    public function process()
    {
        // Silence is gold...
    }
}
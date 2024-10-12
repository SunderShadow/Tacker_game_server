<?php

namespace Core\GameLobby;

class StartGame extends Action
{
    public function __invoke(): void
    {
        $this->lobby->startGame();
    }
}
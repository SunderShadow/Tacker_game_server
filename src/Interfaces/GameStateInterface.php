<?php

namespace Core\Interfaces;

use Core\Game;

interface GameStateInterface extends ServerMessageHandlerInterface
{
    public function __construct(Game $game);
}
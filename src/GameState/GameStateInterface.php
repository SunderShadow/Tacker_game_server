<?php

namespace Core\GameState;

use Core\Game;
use Core\ServerMessageHandlerInterface;

interface GameStateInterface extends ServerMessageHandlerInterface
{
    public function __construct(Game $game);
}
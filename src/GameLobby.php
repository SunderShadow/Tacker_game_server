<?php

namespace Core;

use Core\Entity\Player;

class GameLobby
{
    public array $players = [];

    public function startGame(): Game
    {
        return new Game($this->players);
    }

    public function addPlayer(): Player
    {
        return $this->players[] = new Player();
    }
}
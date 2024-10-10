<?php

namespace Core;

use Core\GameState\GameStateInterface;
use Core\GameState\PrepareCards;
use Core\Message\Message;

class Game implements ServerMessageHandlerInterface
{
    public readonly PlayersBag $players;
    private GameStateInterface $state;

    public function __construct($players)
    {
        foreach ($players as $player) {
            $player->game = $this;
        }

        $this->players = new PlayersBag($players);
        $this->state = new PrepareCards($this);
    }

    public function handleMessage(Player $sender, Message $msg): void
    {
        $this->state->handleMessage($sender, $msg);
    }
}
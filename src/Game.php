<?php

namespace Core;

use Core\Entity\Player;
use Core\GameState\PrepareCards;
use Core\Interfaces\GameStateInterface;
use Core\Interfaces\ServerMessageHandlerInterface;
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
        $this->changeState(new PrepareCards($this));
    }

    public function changeState(GameStateInterface $state): void
    {
        $this->state = $state;
    }

    public function handleMessage(Player $sender, Message $msg): void
    {
        echo
            "Game#", spl_object_id($this),       PHP_EOL,
            "---------------------------",       PHP_EOL,
            "Message",                           PHP_EOL,
            "Action: ", $msg->action,            PHP_EOL,
            "Data: ",   json_encode($msg->data), PHP_EOL,
            "---------------------------",       PHP_EOL,
        PHP_EOL;


        $this->state->handleMessage($sender, $msg);
    }
}
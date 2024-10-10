<?php

namespace Core;

use Core\Message\Error\Error;
use Core\Message\Message;

class Player
{
    public readonly int $id;

    public Game $game;

    public function __construct()
    {
        $this->id = rand(0, 100);
    }

    public function sendMessage(Message $msg): void
    {
        $this->game->handleMessage($this, $msg);
    }

    public function handleMessage(Message $msg): void
    {
        if ($msg instanceof Error) {
            echo "Code: " . $msg->data['code'], PHP_EOL;
            echo "Error: " . $msg->data['message'], PHP_EOL;
        }
    }
}
<?php

namespace Core\Interfaces;

use Core\Entity\Player;
use Core\Message\Message;

interface ServerMessageHandlerInterface
{
    /**
     * Handles message received from client
     * @param Player $sender
     * @param Message $msg
     * @return void
     */
    public function handleMessage(Player $sender, Message $msg): void;
}
<?php

namespace Core\Interfaces;

use Core\Entity\Player;
use Core\Message\Message;

interface ServerMessageHandlerInterface
{
    public function handleMessage(Player $sender, Message $msg): void;
}
<?php

namespace Core\Interfaces;

use Core\Message\Message;
use Core\Player;

interface ServerMessageHandlerInterface
{
    public function handleMessage(Player $sender, Message $msg): void;
}
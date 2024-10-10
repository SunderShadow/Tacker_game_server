<?php

namespace Core;

use Core\Message\Message;

interface ServerMessageHandlerInterface
{
    public function handleMessage(Player $sender, Message $msg): void;
}
<?php

namespace Core\GameLobby;

use Core\Message\Message;

class Join extends Action
{
    public function __invoke(): void
    {
        $this->lobby->addPlayer($this->invoker);
        $this->invoker->handleMessage(new Message('lobby:join:success'));
    }
}
<?php

namespace Core\GameLobby;

use Core\Message\Message;
use Respect\Validation\Mixins\ChainedValidator;
use Respect\Validation\Validator;

class Join extends Action
{
    public function validator(): ChainedValidator|Validator|null
    {
        return Validator::key('id', Validator::intVal());
    }

    public function __invoke(): void
    {
        $this->lobby->addPlayer($this->invoker);
        $this->invoker->handleMessage(new Message('lobby:join:success', [
            'lobby_id' => $this->lobby->id,
            'players'   => $this->lobby->players
        ]));
    }
}
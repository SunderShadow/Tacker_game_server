<?php

namespace Core\GameState\Action;

use Core\Message\Error\Error;
use Core\Message\Message;
use Respect\Validation\Mixins\ChainedValidator;
use Respect\Validation\Validator;

class Vote extends Action
{
    protected function validator(): ChainedValidator|Validator|null
    {
        return Validator::key('id', Validator::intVal());
    }

    public function __invoke(): void
    {
        $id = $this->data['id'];
        $player = $this->game->players->getById($id);

        if (!$player) {
            $this->invoker->handleMessage(new Error("Undefined player with id: $id"));
            return;
        }

        $player->acceptVote();

        $this->game->players->sendMessage(new Message('vote', [
            'from' => $this->invoker->id,
            'to'   => $player->id
        ]));
    }
}
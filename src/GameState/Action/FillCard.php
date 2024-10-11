<?php

namespace Core\GameState\Action;

use Core\Entity\Card;
use Core\Message\Error\Error;
use Respect\Validation\Mixins\ChainedValidator;
use Respect\Validation\Validator;
use Respect\Validation\Validator as v;

class FillCard extends Action
{
    protected function validator(): Validator|ChainedValidator
    {
        return v::each(v::stringVal());
    }

    public function __invoke(): void
    {
        $this->invoker->getCurrentCard()->values = $this->data;

        if ($this->invoker->hasMaxCards()) {
            $this->invoker->handleMessage(new Error('Maximum number of cards reached'));
            return;
        }

        $this->invoker->getNewCard(new Card());
    }
}
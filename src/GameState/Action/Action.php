<?php

namespace Core\GameState\Action;

use Core\Game;
use Core\Player;
use Respect\Validation\Mixins\ChainedValidator;
use Respect\Validation\Validator;

abstract class Action
{
    /**
     * @throws \Throwable
     */
    public function __construct(
        protected Player $invoker,
        protected readonly array $data,
        protected readonly Game $game
    )
    {
        $validator = $this->validator();

        if ($validator) {
            $validator->assert($data);
        }
    }

    protected function validator(): ChainedValidator|Validator|null
    {
        return null;
    }

    abstract public function __invoke(): void;
}
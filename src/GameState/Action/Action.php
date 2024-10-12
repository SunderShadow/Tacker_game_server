<?php

namespace Core\GameState\Action;

use Core\Entity\Player;
use Core\Game;
use Respect\Validation\Mixins\ChainedValidator;
use Respect\Validation\Validator;
use Throwable;

abstract class Action
{
    /**
     * @throws Throwable
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

    /**
     * Returns validator provided by "respect/validation"
     * @return ChainedValidator|Validator|null
     */
    protected function validator(): ChainedValidator|Validator|null
    {
        return null;
    }

    /**
     * All action logic contains here
     * @return void
     */
    abstract public function __invoke(): void;
}
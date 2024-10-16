<?php

namespace Core\GameState\Action;

use Core\Entity\Player;
use Core\Game;
use Respect\Validation\Mixins\ChainedValidator;
use Respect\Validation\Validator;
use Throwable;

abstract class Action extends \Core\Action
{
    protected readonly Game $game;

    /**
     * @throws Throwable
     */
    public function __construct(Player $invoker, array $data, Game $game)
    {
        parent::__construct($invoker, $data);
        $this->game = $game;
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
<?php

namespace Core\GameState;

use Core\Game;
use Core\GameState\Action\Action;
use Core\Message\Error\UndefinedAction;
use Core\Message\Message;
use Core\Player;

abstract class GameState implements GameStateInterface
{
    protected readonly Game $game;

    /** @var array<class-string|callable>  */
    protected array $actions = [
        // 'action:test' => TestAction::class
    ];

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function handleMessage(Player $sender, Message $msg): void
    {
        if (!isset($this->actions[$msg->action])) {
            $sender->handleMessage(new UndefinedAction());
            return;
        }

        /** @var Action $action */
        $action = new $this->actions[$msg->action]($sender, $msg->data, $this->game);
        $action->__invoke();
    }
}
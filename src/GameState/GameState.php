<?php

namespace Core\GameState;

use Core\Entity\Player;
use Core\Game;
use Core\GameState\Action\Action;
use Core\Interfaces\GameStateInterface;
use Core\Message\Error\UndefinedAction;
use Core\Message\Message;

abstract class GameState implements GameStateInterface
{
    protected readonly Game $game;

    /**
     * Container for all registered actions
     * @var array<class-string|callable>
     */
    protected array $actions = [
        // 'action:test' => TestAction::class
    ];

    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->process();
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

    /**
     * All user logic stores here
     * @return void
     */
    abstract public function process(): void;
}
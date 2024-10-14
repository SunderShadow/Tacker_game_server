<?php

namespace Core;

use Core\Entity\Player;
use Core\GameLobby\Join;
use Core\GameLobby\StartGame;
use Core\Interfaces\ServerMessageHandlerInterface;
use Core\Message\Error\UndefinedAction;
use Core\Message\Message;

class GameLobby implements ServerMessageHandlerInterface
{
    protected static array $instances = [];

    protected array $actions = [
        'lobby:join'  => Join::class,
        'lobby:start' => StartGame::class
    ];

    protected static int $lastId = 0;

    public readonly Player $owner;

    public readonly int $id;

    /** @var Player[] */
    public array $players = [];

    public function __construct(Player $owner)
    {
        $owner->lobby = $this;

        $this->addPlayer($this->owner = $owner);
        $this->id = static::$lastId++;

        static::$instances[$this->id] = $this;

        $this->owner->handleMessage(new Message('lobby:create:success', [
            'id'      => $this->id,
            'players' => $this->players
        ]));
    }

    public function addPlayer(Player $player): Player
    {
        foreach ($this->players as $playerInLobby) {
            $playerInLobby->handleMessage(new Message('lobby:join:guest', [
                'player' => $player
            ]));
        }
        return $this->players[] = $player;
    }

    public function handleMessage(Player $sender, Message $msg): void
    {
        if (!isset($this->actions[$msg->action])) {
            $sender->handleMessage(new UndefinedAction());
            return;
        }

        /** @var GameLobby\Action $action */
        $action = new $this->actions[$msg->action]($sender, $msg->data, $this);
        $action->__invoke();
    }

    public function startGame(): Game
    {
        return new Game($this->players);
    }

    public static function getById(int $id): ?static
    {
        return static::$instances[$id] ?? null;
    }
}
<?php

namespace Core\GameLobby;

use Core\Entity\Player;
use Core\GameLobby;

abstract class Action extends \Core\Action
{
    protected readonly GameLobby $lobby;

    public function __construct(Player $invoker, array $data, GameLobby $lobby)
    {
        parent::__construct($invoker, $data);
        $this->lobby = $lobby;
    }

    abstract public function __invoke(): void;
}
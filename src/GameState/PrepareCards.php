<?php

namespace Core\GameState;

use Core\Entity\Card;
use Core\Game;
use Core\GameState\Action\FillCard;

class PrepareCards extends GameState
{
    protected array $actions = [
        'card:fill' => FillCard::class
    ];

    public function __construct(Game $game)
    {
        parent::__construct($game);

        $this->giveCardEachPlayer();
    }

    protected function giveCardEachPlayer(): void
    {
        foreach ($this->game->players as $player) {
            $player->getNewCard(new Card());
        }
    }
}
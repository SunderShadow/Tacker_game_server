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

    protected function giveCardEachPlayer(): void
    {
        foreach ($this->game->players as $player) {
            $player->acceptNewCard(new Card());
        }
    }

    public function process(): void
    {
        $this->giveCardEachPlayer();
    }
}
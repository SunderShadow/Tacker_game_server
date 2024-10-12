<?php

namespace Core\GameState;

use Core\GameState\Action\FillCard;
use function React\Async\async;
use function React\Async\await;
use function React\Promise\Timer\sleep as reactSleep;

class PrepareCards extends GameState
{
    protected array $actions = [
        'card:fill' => FillCard::class
    ];

    protected function giveCardEachPlayer(): void
    {
        async(function () {
            foreach ($this->game->players as $player) {
                $player->acceptNewCard($this->game->cardLoader->popRandom());
            }

            await(reactSleep(2));
            $this->game->changeState(new Battle($this->game));
        })();
    }

    public function process(): void
    {
        $this->giveCardEachPlayer();
    }
}
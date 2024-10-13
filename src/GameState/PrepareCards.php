<?php

namespace Core\GameState;

use Core\GameState\Action\FillCard;
use Core\Message\Message;
use function React\Async\async;
use function React\Async\await;
use function React\Promise\Timer\sleep as reactSleep;

class PrepareCards extends GameState
{
    protected array $actions = [
        'card:fill' => FillCard::class
    ];

    public function process(): void
    {
        $this->game->players->sendMessage(new Message('game:state:prepare-cards'));
        $this->giveCardEachPlayer();
    }

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
}
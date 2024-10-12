<?php

namespace Core\GameState;

use Core\Entity\Player;
use Core\Message\BattleCardPair;
use Core\Message\Message;
use function React\Async\async;
use function React\Async\await;
use function React\Promise\Timer\sleep as reactSleep;

class Battle extends GameState
{
    /** @var Player[] */
    private array $opponents = [];

    protected array $actions = [
        'vote' => Action\Vote::class
    ];

    public function process(): void
    {
        $this->opponents = $this->game->players->getArrayCopy();

        async(function () {
            while (count($this->opponents)) {
                $this->game->players->sendMessage(new BattleCardPair($this->getTwoOpponentsCards()));
                await(reactSleep(2));
            }
            $this->game->players->sendMessage(new Message('battle:end'));
        })();
    }

    private function getTwoOpponentsCards(): array
    {
        [$o1, $o2] = $this->calcOpponents($o1k, $o2k);

        $cards = $o1->battleWith($o2);

        if (!$o1->hasCards()) {
            unset($this->opponents[$o1k]);
        }

        if (!$o2->hasCards()) {
            unset($this->opponents[$o2k]);
        }

        return $cards;
    }

    private function eachOpponentHasThemPair(Player $o1, Player $o2): bool
    {
        return count($this->opponents) === 3
            && $o1->hasMaxCards()
            && $o2->hasMaxCards();
    }

    /**
     * @param $o1k
     * @param $o2k
     * @return Player[]
     */
    private function grantOpponentHasThemPair(&$o1k, &$o2k): array
    {
        $o1 = $this->opponents[$o1k];
        $o2 = $this->opponents[$o2k];

        foreach ($this->opponents as $k => $o) {
            if ($o !== $o1 && $o !== $o2) {
                $o1k = $k;
                $o1 = $o;
                break;
            }
        }

        return [$o1, $o2];
    }

    /**
     * @return Player[]
     */
    private function calcOpponents(&$o1k, &$o2k): array
    {
        [$o1k, $o2k] = array_rand($this->opponents, 2);

        $o1 = $this->opponents[$o1k];
        $o2 = $this->opponents[$o2k];

        if (!$this->eachOpponentHasThemPair($o1, $o2)) {
            return $this->grantOpponentHasThemPair($o1k, $o2k);
        }

        return [$o1, $o2];
    }
}
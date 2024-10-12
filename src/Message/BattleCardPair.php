<?php

namespace Core\Message;

use Core\Entity\Card;

readonly class BattleCardPair extends Message
{
    /**
     * @param Card[] $cards
     */
    public function __construct(array $cards)
    {
        $data = [];

        foreach ($cards as $card) {
            $data[] = $card->jsonSerialize();
        }

        parent::__construct('battle:cards', $data);
    }
}
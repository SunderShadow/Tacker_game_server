<?php

namespace Core\Message;

use Core\Entity\Card;

readonly class PlayerCardReceive extends Message
{
    public function __construct(Card $card)
    {
        parent::__construct('card:receive', [
            'template' => $card->template
        ]);
    }
}
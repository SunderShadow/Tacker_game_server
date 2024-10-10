<?php

namespace Core;

use ArrayObject;
use Core\Entity\Player;
use Core\Message\Message;

/**
 * @template-extends ArrayObject<string, Player>
 */
class PlayersBag extends ArrayObject
{
    public function sendMessage(Message $msg):void
    {
        foreach ($this as $player) {
            $player->handleMessage($msg);
        }
    }
}
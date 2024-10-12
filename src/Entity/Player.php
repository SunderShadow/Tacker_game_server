<?php

namespace Core\Entity;

use Core\Game;
use Core\Message\Error\Error;
use Core\Message\Message;
use Core\Message\PlayerCardReceive;

class Player
{
    const int MAX_CARDS = 2;

    public readonly int $id;

    public Game $game;

    /** @var Card[]  */
    protected array $cards = [];
    protected int $votes = 0;

    public function __construct()
    {
        $this->id = rand(0, 100);
    }

    /**
     * Player receives new card
     * @param Card $card
     * @return void
     */
    public function acceptNewCard(Card $card): void
    {
        $this->cards[] = $card;
        $card->owner = $this;
        $this->handleMessage(new PlayerCardReceive($card));
    }

    /**
     * Get vote from other user
     * @return void
     */
    public function acceptVote(): void
    {
        $this->votes += 1;
    }

    /**
     * Get card that user fills right now
     * @return Card
     */
    public function getCurrentCard(): Card
    {
        return $this->cards[count($this->cards) - 1];
    }

    /**
     * Check if player has max cards
     * @return bool
     */
    public function hasMaxCards(): bool
    {
        return count($this->cards) >= self::MAX_CARDS;
    }

    /**
     * Check if player has cards
     * @return bool
     */
    public function hasCards(): bool
    {
        return count($this->cards);
    }

    /**
     * Get a pair of cards to battle
     * @param Player $player
     * @return Card[]
     */
    public function battleWith(Player $player): array
    {
        return [
            array_pop($this->cards),
            array_pop($player->cards)
        ];
    }

    /**
     * Send message to game
     * @param Message $msg
     * @return void
     */
    public function sendMessage(Message $msg): void
    {
        $this->game->handleMessage($this, $msg);
    }

    /**
     * Send message to client
     * @param Message $msg
     * @return void
     */
    public function handleMessage(Message $msg): void
    {
        echo "Player#", spl_object_id($this), PHP_EOL;
        echo "---------------------------", PHP_EOL;
        if ($msg instanceof Error) {
            echo
                "Error",                             PHP_EOL,
                "Code: ",     $msg->data['code'],    PHP_EOL,
                "Message: ",  $msg->data['message'], PHP_EOL;
        } else {
            echo
                "Message",                           PHP_EOL,
                "Action: ", $msg->action,            PHP_EOL,
                "Data: ",   json_encode($msg->data), PHP_EOL;
        }

        echo "---------------------------", PHP_EOL, PHP_EOL;
    }
}
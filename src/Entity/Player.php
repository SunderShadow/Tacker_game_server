<?php

namespace Core\Entity;

use Core\Game;
use Core\GameLobby;
use Core\Message\Message;
use Core\Message\PlayerCardReceive;

class Player extends User implements \JsonSerializable
{
    const int MAX_CARDS = 2;

    public GameLobby $lobby;

    public Game $game;

    public string $name;

    /** @var Card[]  */
    protected array $cards = [];
    protected int $votes = 0;

    public function inLobby(): bool
    {
        return isset($this->lobby);
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

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
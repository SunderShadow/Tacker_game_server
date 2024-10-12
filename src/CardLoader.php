<?php

namespace Core;

use Core\Entity\Card;

class CardLoader
{
    const string CARD_TEMPLATES_DIRECTORY = ROOT_DIR . DIRECTORY_SEPARATOR . 'card_templates';

    /** @var Card[] */
    private array $cards = [];

    /**
     * Load cards from given preset
     * @param string $presetName
     * @return void
     */
    public function load(string $presetName = 'default'): void
    {
        $cards = require $this->getPresetFilepath($presetName);

        foreach ($cards as $card) {
            $this->cards[] = new Card($card);
        }
    }

    /**
     * Pop random card from array
     * @throws \Exception
     * @return Card|Card[]
     */
    public function popRandom(int $count = 1): Card|array
    {
        if (count($this->cards) < $count)
        {
            throw new \Exception('Not enough cards');
        }

        if ($count === 1) {
            $key = array_rand($this->cards);
            $card = $this->cards[$key];
            unset ($this->cards[$key]);

            return $card;
        }

        return array_map(
            function ($k) {
                $card = $this->cards[$k];
                unset ($this->cards[$k]);

                return $card;
            },
            array_rand($this->cards, $count)
        );
    }

    /**
     * Retrieves full preset filepath
     * @param string $presetName
     * @return string
     */
    private function getPresetFilepath(string $presetName): string
    {
        return static::CARD_TEMPLATES_DIRECTORY . DIRECTORY_SEPARATOR . $presetName . '.php';
    }
}
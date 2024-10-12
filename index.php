<?php

use Core\Message\Message;

include "vendor/autoload.php";

$gameLobby = new \Core\GameLobby();
/** @var \Core\Entity\Player[] $players */
$players = [
    $gameLobby->addPlayer(),
    $gameLobby->addPlayer(),
    $gameLobby->addPlayer()
];

$game = $gameLobby->startGame();

try {
    foreach ($players as $player) {
        $player->sendMessage(new Message('card:fill', ['someData']));
        $player->sendMessage(new Message('card:fill', ['someData']));
    }

    $game->changeState(new \Core\GameState\Battle($game));

//    $players[0]->sendMessage(new Message('vote', ['id' => $players[1]->id]));
} catch (\Respect\Validation\Exceptions\ValidationException $e) {
    $players[0]->handleMessage(new \Core\Message\Error\Error($e->getFullMessage()));
}

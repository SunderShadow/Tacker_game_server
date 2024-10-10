<?php

include "vendor/autoload.php";

$gameLobby = new \Core\GameLobby();

/** @var \Core\Entity\Player[] $players */
$players = [
    $gameLobby->addPlayer(),
    $gameLobby->addPlayer(),
    $gameLobby->addPlayer(),
    $gameLobby->addPlayer()
];

$game = $gameLobby->startGame();

try {
    $players[0]->sendMessage(new \Core\Message\Message('card:fill', ['someData']));
    $players[0]->sendMessage(new \Core\Message\Message('card:fill', ['someData']));
} catch (\Respect\Validation\Exceptions\ValidationException $e) {
    $players[0]->handleMessage(new \Core\Message\Error\Error($e->getFullMessage()));
}


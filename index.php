<?php
include "vendor/autoload.php";

$gameLobby = new \Core\GameLobby();

/** @var \Core\Player[] $players */
$players = [
    $gameLobby->addPlayer(),
    $gameLobby->addPlayer(),
    $gameLobby->addPlayer(),
    $gameLobby->addPlayer()
];

$game = $gameLobby->startGame();

$players[0]->sendMessage(new \Core\Message\Message('action:test', ['someData']));
$players[0]->sendMessage(new \Core\Message\Message('undefined', ['someData']));

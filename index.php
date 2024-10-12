<?php

use Core\Entity\Player;
use Core\GameLobby;
use Core\Server;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

include "vendor/autoload.php";


const ROOT_DIR = __DIR__;

//$gameLobby = new GameLobby();
//
///** @var Player[] $players */
//$players = [
//    $gameLobby->addPlayer(),
//    $gameLobby->addPlayer(),
//    $gameLobby->addPlayer()
//];

//$game = $gameLobby->startGame();
//
//try {
//    foreach ($players as $player) {
//        $player->sendMessage(new Message('card:fill', ['someData']));
//        $player->sendMessage(new Message('card:fill', ['someData']));
//    }
//
//    $game->changeState(new \Core\GameState\Battle($game));
//
////    $players[0]->sendMessage(new Message('vote', ['id' => $players[1]->id]));
//} catch (\Respect\Validation\Exceptions\ValidationException $e) {
//    $players[0]->handleMessage(new \Core\Message\Error\Error($e->getFullMessage()));
//}

$protocol = new HttpServer(
    new WsServer(
        new Server()
    )
);

$port = '100';
$address = '127.0.0.1';

error_reporting(E_ALL ^ E_DEPRECATED);

IoServer::factory($protocol, $port, $address)->run();
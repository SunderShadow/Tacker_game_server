<?php

namespace Core;
use Core\Entity\Player;
use Core\Message\Error\Error;
use Core\Message\Message;

class Server implements \Ratchet\MessageComponentInterface
{
    function onOpen(\Ratchet\ConnectionInterface $conn): void
    {
        Player::register($conn);
    }

    function onClose(\Ratchet\ConnectionInterface $conn): void
    {
        Player::closeConnection($conn);
    }

    function onError(\Ratchet\ConnectionInterface $conn, \Exception $e): void
    {
        echo $e->getMessage(), PHP_EOL;
    }

    function onMessage(\Ratchet\ConnectionInterface $from, $msg): void
    {
        $player = Player::getByConnection($from);

        try {
            $msg = Message::fromJson($msg);
        } catch (\Exception $e) {
            $player->handleMessage(new Error($e->getMessage()));
            return;
        }

        if ($msg->action === 'lobby:create') {
            if ($player->inLobby()) {
                $player->handleMessage(new Error('Already in lobby'));
                return;
            }

            if (!isset($msg->data['name'])) {
                $player->handleMessage(new Error('name field is required'));
                return;
            }

            $player->name = $msg->data['name'];

            new GameLobby($player);
            return;
        }

        if ($msg->action === 'lobby:join') {
            if (!isset($msg->data['id'])) {
                $player->handleMessage(new Error('Undefined lobby'));
                return;
            }

            if (!isset($msg->data['name'])) {
                $player->handleMessage(new Error('name field is required'));
                return;
            }

            $player->name = $msg->data['name'];

            $lobby = GameLobby::getById($msg->data['id']);

            if (!$lobby) {
                $player->handleMessage(new Error('Undefined lobby'));
                return;
            }

            $lobby->handleMessage($player, $msg);
            return;
        }

        if ($player->inLobby()) {
            $player->lobby->handleMessage($player, $msg);
        }
    }
}
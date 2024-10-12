<?php

namespace Core\Entity;

use Core\Message\Error\Error;
use Core\Message\Message;
use Ratchet\ConnectionInterface;

class User
{
    /** @var self[] */
    protected static array $instances = [];

    public bool $connected = true;

    public readonly int $id;

    public readonly ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;

        $this->id = $connection->resourceId;
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

        $this->connection->send(json_encode($msg));
    }

    public static function getByConnection(ConnectionInterface $conn): static
    {
        return static::$instances[$conn->resourceId];
    }

    public static function register(ConnectionInterface $conn): static
    {
        return static::$instances[$conn->resourceId] = new static($conn);
    }

    public static function closeConnection(ConnectionInterface $conn): void
    {
        static::$instances[$conn->resourceId]->connected = false;

        unset(static::$instances[$conn->resourceId]);
    }
}
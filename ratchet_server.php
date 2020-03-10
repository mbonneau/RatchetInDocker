<?php

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use React\EventLoop\Factory;

require __DIR__ . '/vendor/autoload.php';

$loop = Factory::create();

$webSock = new React\Socket\Server('0.0.0.0:8009', $loop); // Binding to 0.0.0.0 means remotes can connect
$webServer = new Ratchet\Server\IoServer(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new class implements MessageComponentInterface {
                function onOpen(ConnectionInterface $conn) { echo "Conn opened.\n"; }

                function onClose(ConnectionInterface $conn) { echo "Conn closed.\n"; }

                function onError(ConnectionInterface $conn, \Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }

                public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
                {
                    echo "Got message: " . $msg->getPayload() . "\n";
                    $conn->send($msg->getPayload());
                }

            }
        )
    ),
    $webSock
);

$loop->run();
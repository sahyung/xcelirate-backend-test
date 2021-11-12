<?php

namespace App\MessageHandler;

use App\Message\ApiMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Predis\Client;

final class ApiMessageHandler implements MessageHandlerInterface
{
    public function __construct()
    {
        $this->redis=new Client($_ENV['REDIS_DSN']);
    }
    public function __invoke(ApiMessage $message)
    {
        var_dump($message);
        $this->redis->set($message->getRedisKey(),$message->getContent());
    }
}

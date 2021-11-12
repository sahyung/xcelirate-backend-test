<?php

namespace App\Message;

class ApiMessage
{
    private $rediskey;
    private $content;

    public function __construct(string $rediskey='anonymous',string $content="[\"EMPTY QUOTE!\"]")
    {
        $this->rediskey=$rediskey;
        $this->content=$content;
    }
    public function getRedisKey(): string
    {
        return $this->rediskey;
    }
    public function getContent(): string
    {
        return $this->content;
    }
}

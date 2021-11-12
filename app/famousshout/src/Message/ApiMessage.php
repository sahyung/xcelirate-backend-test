<?php

namespace App\Message;

final class ApiMessage
{
    /*
     * Add whatever properties & methods you need to hold the
     * data for this message class.
     */

    private $rediskey;
    private $content;

    public function __construct(string $rediskey = '', string $content = '')
    {
        $this->rediskey = $rediskey;
        $this->content = $content;
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

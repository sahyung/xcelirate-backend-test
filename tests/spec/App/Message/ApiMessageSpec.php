<?php

namespace spec\App\Message;

use App\Message\ApiMessage;
use PhpSpec\ObjectBehavior;

class ApiMessageSpec extends ObjectBehavior
{
    private $rediskey;
    private $content;

    function it_is_initializable()
    {
        $this->shouldHaveType(ApiMessage::class);
    }
    function it_should_return_corresponding_message_given_redis_key_and_content()
    {
        $this->beConstructedWith('george_orwell?limit=1',json_encode(['NOTHING CONSISTS OF NOTHINGNESS!']));
        $this->getRedisKey()->shouldReturn('george_orwell?limit=1');
        $this->getContent()->shouldReturn(json_encode(['NOTHING CONSISTS OF NOTHINGNESS!']));
    }
}

<?php

namespace spec\App\Entity;

use App\Entity\Quotes;
use PhpSpec\ObjectBehavior;

class QuotesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Quotes::class);
    }
    function it_should_allow_to_set_quote(){
        $this->setQuote('Nothing consists of nothingness.');
        $this->getQuote()->shouldReturn('Nothing consists of nothingness.');
    }
    function it_should_allow_to_set_author(){
        $this->setAuthor('George Orwell');
        $this->getAuthor()->shouldReturn('George Orwell');
    }
    function it_should_allow_to_set_route(){
        $this->setRoute('george_orwell');
        $this->getRoute()->shouldReturn('george_orwell');
    }
    function it_should_have_a_string_as_a_quote(){
        $this->setQuote('Nothing consists of nothingness.');
        $this->getQuote()->shouldBeString();
    }
    function it_should_have_a_string_as_an_author(){
        $this->setAuthor('George Orwell');
        $this->getAuthor()->shouldBeString();
    }
    function it_should_have_a_string_as_a_route(){
        $this->setRoute('george_orwell');
        $this->getRoute()->shouldBeString();
    }
}

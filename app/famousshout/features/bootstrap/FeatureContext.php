<?php

use App\Entity\Quotes;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    private $quotes;
    private $author;
    private $route;
    private $limit;
    private $client;
    private $lastrequest;
    private $lastresponse;
    private $method;
    private $uri;

    public function __construct()
    {
        $this->author='Albert Einstein';
        $this->route='albert_einstein';
        $this->limit;
        $this->client=new Client(['base_uri'=>'http://symfony.dev']);
    }
    /**
     * @Given the following author exists:
     */
    public function theFollowingAuthorExists(TableNode $table)
    {
        if($table->getRow(1)[1]!==$this->author){throw new BadRequestHttpException('The author does not exist. You can always try for another.');}
    }

    /**
     * @Given the quote is :arg1
     */
    public function theQuoteIs($arg1)
    {
        $this->quotes=[$arg1];
    }

    /**
     * @Given the limit is :arg1
     */
    public function theLimitIs($arg1)
    {
        $this->limit=intval($arg1);
    }

    /**
     * @When I request :arg1
     */
    public function iRequest($arg1)
    {
        $this->method=strtoupper(explode(' ',$arg1)[0]);
        $this->uri=explode(' ',$arg1)[1].'?limit='.$this->limit;
        $this->lastrequest=new Request($this->method,$this->uri);
        try{
            $this->lastresponse=$this->client->send($this->lastrequest);
        }catch(\GuzzleHttp\Exception\BadResponseException $exception){
            if($exception->getResponse()===null){throw $exception;}
            $this->lastresponse=$exception->getResponse();
            if($this->limit>0 and $this->limit<=10 and in_array($this->author,['Albert Einstein'])){throw new \Exception('Bad response.');}
        }
    }

    /**
     * @Then the response status code should be :arg1
     */
    public function theResponseStatusCodeShouldBe($arg1)
    {
        if(!$this->lastresponse->getStatusCode()===intval($arg1)){throw new GuzzleHttp\Exception\BadResponseException();}
    }

    /**
     * @Then the response should equal "[:arg1]"
     */
    public function theResponseShouldEqual($arg1)
    {
        try{
            if(!strval($this->lastresponse->getBody())===strval($arg1)){throw new GuzzleHttp\Exception\BadResponseException();}
        }catch(\Exception $exception){
            throw new \Exception('Bad response. The response should be '.$arg1);
        }
    }

    /**
     * @Given the quotes are :arg1
     */
    public function theQuotesAre($arg1)
    {
        $givenquotes=[];
        foreach(explode('|',$arg1) as $q){
            $givenquotes[]=$q;
        }
        $this->quotes=$givenquotes;
    }

    /**
     * @Then the response should equal :arg1
     */
    public function theResponseShouldEqual2($arg1)
    {
        $supposedresponse=[];
        foreach(explode('|',$arg1) as $q){
            $supposedresponse[]=$q;
        }
        try{
            if(!strval($this->lastresponse->getBody())===json_encode($supposedresponse)){throw new GuzzleHttp\Exception\BadResponseException();}
        }catch(\Exception $exception){
            throw new \Exception('Bad response. The response should be '.$arg1);
        }
    }

    /**
     * @Given the author is :arg1
     */
    public function theAuthorIs($arg1)
    {
        $this->author=$arg1;
        $this->route=str_replace(' ','_',strtolower($arg1));
    }
}

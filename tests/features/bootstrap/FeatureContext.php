<?php

use App\Entity\Quotes;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpFoundation\Request;

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
    private $quote;
    private $author;
    private $limit;

    public function __construct()
    {
        $request=new Request();
        $this->quote=new Quotes();
        $this->author=$this->quote->getAuthor();
        $this->limit=$request->query->get('limit',1);
    }
    /**
     * @Given the following quotes exist:
     */
    public function theFollowingQuotesExist(TableNode $table)
    {
        foreach($table as $row){
            var_dump($row);
        }
    }

    /**
     * @When I request :arg1
     */
    public function iRequest($arg1)
    {
        return true;
    }

    /**
     * @Then the response status code should be :arg1
     */
    public function theResponseStatusCodeShouldBe($arg1)
    {
        return true;
    }

    /**
     * @Then the response should equal "[:arg1]"
     */
    public function theResponseShouldEqual($arg1)
    {
        return true;
    }
}

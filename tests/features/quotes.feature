Feature: Quotes returned
    In order to get quotes from a specific author
    As a client
    I need to define the author and how many quotes i'd prefer as an upper limit, as there could be less than that

    Rules:
    - Limit is lower than or equal to 10
    - Author must exist in database and needs to be set in valid format

    Scenario: Get a single quote
        Given the following quotes exist:
            | quote                                                         | Author            |
            | Strive not to be a success, but rather to be of value.        | Albert Einstein   |
            | A person who never made a mistake never tried anything new.   | Albert Einstein   |
        When I request "GET http://symfony.dev/shout/albert_einstein"
        Then the response status code should be 200
        And the response should equal "["STRIVE NOT TO BE A SUCCESS, BUT RATHER TO BE OF VALUE!"]"
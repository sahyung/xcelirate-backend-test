Feature: Quotes returned
    In order to get quotes from a specific author
    As a client
    I need to define the author and how many quotes i'd prefer as an upper limit, as there could be less than that

    Rules:
    - Limit is lower than or equal to 10
    - Author must exist in database and needs to be set in valid format

    Scenario: Get a single quote from an existing author
        Given the following author exists:
            | route              | Author            |
            | albert_einstein    | Albert Einstein   |
        And the quote is "Strive not to be a success, but rather to be of value."
        And the limit is 1
        When I request "GET /shout/albert_einstein"
        Then the response status code should be 200
        And the response should equal "["STRIVE NOT TO BE A SUCCESS, BUT RATHER TO BE OF VALUE!"]"

    Scenario: Get more than a single quote from an existing author, exactly as many as available <=10
        Given the following author exists:
            | route              | Author            |
            | albert_einstein    | Albert Einstein   |
        And the quotes are "Strive not to be a success, but rather to be of value.|A person who never made a mistake never tried anything new."
        And the limit is 2
        When I request "GET /shout/albert_einstein?limit=2"
        Then the response status code should be 200
        And the response should equal "STRIVE NOT TO BE A SUCCESS, BUT RATHER TO BE OF VALUE!|A PERSON WHO NEVER MADE A MISTAKE NEVER TRIED ANYTHING NEW!"
    
    Scenario: Get more than a single quote from an existing author, more than available <=10
        Given the following author exists:
            | route              | Author            |
            | albert_einstein    | Albert Einstein   |
        And the quotes are "Strive not to be a success, but rather to be of value.|A person who never made a mistake never tried anything new."
        And the limit is 10
        When I request "GET /shout/albert_einstein?limit=10"
        Then the response status code should be 200
        And the response should equal "STRIVE NOT TO BE A SUCCESS, BUT RATHER TO BE OF VALUE!|A PERSON WHO NEVER MADE A MISTAKE NEVER TRIED ANYTHING NEW!"
    
    Scenario: Get more than 10 quotes from an existing author
        Given the following author exists:
            | route              | Author            |
            | albert_einstein    | Albert Einstein   |
        And the quotes are "Strive not to be a success, but rather to be of value.|A person who never made a mistake never tried anything new."
        And the limit is 11
        When I request "GET /shout/albert_einstein?limit=11"
        Then the response status code should be 400

    Scenario: Get single quote from non-existing author
        Given the following author exists:
            | route              | Author            |
            | albert_einstein    | Albert Einstein   |
        And the author is "George Orwell"
        And the limit is 1
        When I request "GET /shout/george_orwell"
        Then the response status code should be 404

    Scenario: Get more than a single quote from non-existing author
        Given the following author exists:
            | route              | Author            |
            | albert_einstein    | Albert Einstein   |
        And the author is "George Orwell"
        And the limit is 10
        When I request "GET /shout/george_orwell?limit=10"
        Then the response status code should be 404

    Scenario: Get more than 10 quotes from non-existing author
        Given the following author exists:
            | route              | Author            |
            | albert_einstein    | Albert Einstein   |
        And the author is "George Orwell"
        And the limit is 11
        When I request "GET /shout/george_orwell?limit=11"
        Then the response status code should be 400

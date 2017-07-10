# ./bin/behat --config app/config/behat.yml --suite=subscription
Feature: Validate media subscription
  In order to get subscribed
  As an anonymous user
  I am able to leave my e-mail and fullname by validating it

  @SUBSCRIPTION_VALIDATION
  @javascript
  Scenario: Validate subscription
    When I go to homepage
    Then I should see "NEWSLETTER"

    And  I press "Request Subscription Registration"
    And  I confirm the popup

    When I fill in "E-mail" with "wendywolf@minkbehat.com"
    And  I press "Request Subscription Registration"
    And  I confirm the popup

    When I fill in "Full Name" with "Wendy Wolf"
    And  I press "Request Subscription Registration"
    And  I confirm the popup

    When I check "Accept terms and conditions"
    And  I press "Request Subscription Registration"
    
    Then I should see after a while "Subscription successfully created"

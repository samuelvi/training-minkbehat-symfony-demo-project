# ./bin/behat --config app/config/behat.yml --suite=subscription
Feature: Subscribe to media
  In order to get subscribed
  As an anonymous user
  I am able to leave my e-mail and fullname

  @SUBSCRIPTION_OK
  @javascript
  Scenario: Create Subscription
    When I go to homepage
    Then I should see "NEWSLETTER"
    When I scroll to "E-mail"
    And  I fill in "E-mail" with "wendywolf@minkbehat.com"
    And  I fill in "Full Name" with "Wendy Wolf"
    And  I check "Accept terms and conditions"
    And  I press "Request Subscription Registration"
    Then I should see after a while "Subscription successfully created"


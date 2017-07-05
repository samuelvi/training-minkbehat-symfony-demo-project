# ./bin/behat --config app/config/behat.yml --suite=contact_form --tags=CONTACT_FORM_OK
@CONTACT_FORM_OK
@FRONTEND
Feature: Check that users can contact us from the contact form
  In order for users to contact us
  As an anonymous or logged user
  I complete and send a contact form request

  # ./bin/behat --config app/config/behat.yml --suite=contact_form --tags=FRONTEND --tags=OK
  @OK
  Scenario: Send a contact form request
    When I go to homepage
    And  I follow "Contact"
    Then I should see "You are here: Contact Form"

    When I fill in "Full name" with "Wendy Wolf"

    #And  I fill in "E-mail" with "wendywolf@minkbehat.com"
    #And  I fill in "Subject" with "Need help on BDD"

    And  I type "wendywolf@minkbehat.com" in "E-mail"
    And  I type "Need help on BDD" in "Subject"

    And  I fill in "Message" with "Can you help me on BDD please?"
    And  I check "Accept terms and conditions"
    And  I press "Send Contact Form Request"
    Then I should see "Your messages has been properly managed"

  # ./bin/behat --config app/config/behat.yml --suite=contact_form --tags=EMAIL
  @EMAIL
  @mink:symfony2
  Scenario: Check 2 e-mails are sent when contact form request submission
    When I am on "contact"
    Then I should see "You are here: Contact Form"
    When I fill in "Full name" with "Wendy Wolf"
    And  I type "wendywolf@minkbehat.com" in "E-mail"
    And  I type "Need help on BDD" in "Subject"
    And  I fill in "Message" with "Can you help me on BDD please?"
    And  I check "Accept terms and conditions"

    When I submit the contact form
    Then One e-mail should be sent to the requester and another one to the webmaster




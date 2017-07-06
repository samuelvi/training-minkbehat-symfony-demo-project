# ./bin/behat --config app/config/behat.yml --suite=contact_form --tags=CONTACT_FORM_ERROR

@CONTACT_FORM_ERROR
Feature: Check that users can not contact us from the contact form
  In order for users to contact us
  As an anonymous user
  I am not be able to complete and send a contact form request

  Background:
    When I go to homepage
    And  I follow "Contact"
    Then I should see "You are here: Contact Form"

  # ./bin/behat --config app/config/behat.yml --suite=contact_form --tags=CONTACT_FORM_ERROR --tags=EMPTY_FIELDS
  @EMPTY_FIELDS
  Scenario: Check validation for empty fields
    And  I press "Send Contact Form Request"
    Then I should see "The full name can not be empty"
    And  I should see "The e-mail can not be empty"
    And  I should see "Message subject required"
    And  I should see "Message required"
    And  I should see "You must accept terms and conditions"
    And  I should see an error mask next to "The e-mail can not be empty"

  # ./bin/behat --config app/config/behat.yml --suite=contact_form --tags=CONTACT_FORM_ERROR --tags=EMAIL_NOT_VALID
  @EMAIL_NOT_VALID
  Scenario: Check validation for e-mail not valid
    And  I fill in "E-mail" with "this-is-not-a-valid-e-mail-address"
    And  I press "Send Contact Form Request"
    Then I should see "The given e-mail is not valid"

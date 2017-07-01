Feature: Public web navigation
  In order to visit the public demo web site
  As an anonymous user
  I am able to watch all frontend sections

  Background:
    Given I go to homepage


  Scenario: Visit the homepage
    Then  I should see "Welcome to the Demo page for Mink+Behat Symfony integration"

  Scenario: Visit the contact form page
    When  I follow "Contact"
    Then  I should see "You are here: Contact Form"

  Scenario: Visit the login form page
    When  I follow "Login"
    Then  the url should match "/login"
    And   I should see "You are here: Login Form"

  Scenario: Visit the request reset password page
    When  I follow "Login"
    And   I follow "Forgot your password? Click here to request a password reset"
    Then  the url should match "/resetting/request"
    And   I should see "You are here: Request new password"

  @LEGAL @COOKIES
  Scenario: Visit the legal cookies policy page
    When  I follow "Legal Cookies Policy"
    Then print current URL
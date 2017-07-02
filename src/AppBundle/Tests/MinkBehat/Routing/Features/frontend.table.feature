# ./bin/behat --config app/config/behat.yml --suite=routing --tags=ROUTING --tags=FRONTEND --tags=TABLE
# ./bin/behat --config app/config/behat.yml src/AppBundle/Tests/MinkBehat/Routing/Features/frontend.table.feature
@ROUTING
@FRONTEND
@TABLE
Feature: Navigate Demo site from a given table
  In order to visit the public demo web site
  As an anonymous user
  I should be able to navigate through all frontend sections from a given table of information

  Background:
    Given I am on the homepage

  @ONE_LEVEL_ROUTES
  Scenario Outline:
    When  I follow <section>
    Then  the url should match <url>
    And   I should see <text>

    Examples:
      | section              | url                     | text                                                          |
      | "Home Page"          | "/"                     | "Welcome to the Demo page for Mink+Behat Symfony integration" |
      | "Contact"            | "/contact"              | "You are here: Contact Form"                                  |
      | "Products"           | "/products"             | "You are here: List of Products"                              |
      | "Login"              | "/login"                | "You are here: Login Form"                                    |
      | "Cookies Policy"     | "/cookies"              | "You are here: Cookies Policy"                                |
      | "Terms & Conditions" | "/terms-and-conditions" | "You are here: Terms and Conditions"                          |


  @REQUEST_RESET_PASSWORD
  Scenario Outline:
    When  I follow "Login"
    And   I follow <section>
    Then  the url should match <url>
    And   I should see <text>

    Examples:
      | section                                                        | url                  | text                                 |
      | "Forgot your password? Click here to request a password reset" | "/resetting/request" | "You are here: Request new password" |






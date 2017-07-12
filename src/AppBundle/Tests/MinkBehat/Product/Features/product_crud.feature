# ./bin/behat --config app/config/behat.yml --suite=product --tags=CRUD
@BACKEND
@PRODUCT
@CRUD
Feature: CRUD on Backend
  In order to create, list, update and delete products
  As a webmaster user
  I CRUD from the backend administration page

  Background:
    Given I go to homepage
    When  I follow "Login"
    And   I login as admin
    Then  I should see "Mink Behat Admin Dashboard"
    When  I follow "Product"

  # ./bin/behat --config app/config/behat.yml --suite=product --tags=LIST
  @LIST
  Scenario: List products from backend
    Given The following films
      | name      | price | category | description    |
      | Avatar    | 14.99 | Films    | Nature is...   |
      | Titanic   | 29.95 | Films    | The biggest... |
      | Star Wars | 24.85 | Films    | The most...    |
    When I reload the page
    Then I should see "1 - 15 of 108"

  # ./bin/behat --config app/config/behat.yml --suite=product --tags=ADD
  @ADD
  Scenario Outline: Add a product from backend
    When I follow "Add Product"
    And  I fill in "Name" with "<name>"
    And  I fill in "Price" with "<price>"
    And  I fill in "Description" with "<description>"
    And  I select "<category>" from "Category"
    And  I press "Save changes"
    Then I should see a row with name "<name>", price "<price>" and category "<category>"
    Examples:
      | name                           | price | description  | category |
      | The Good, the Bad and the Ugly | 15    | Western...   | Films    |
      | Rambo                          | 10    | Silvester... | Films    |
      | The Delta Force                | 55    | A film...    | Films    |

  # ./bin/behat --config app/config/behat.yml --suite=product --tags=FILTER
  @FILTER
  Scenario: Check existing products appear in the list page
    And I fill the text "Rocky" in the search box
    And I press "Search"
    Given the following products exists
      | name     | price | category |
      | Rocky I  | 24.99 | Films    |
      | Rocky II | 19.95 | Films    |
      | Rocky V  | 14.85 | Films    |

  # ./bin/behat --config app/config/behat.yml --suite=product --tags=UPDATE
  @UPDATE
  Scenario: Change the description for one product
    When I fill the text "Rocky" in the search box
    And  I press "Search"
    And  I edit the film "Rocky V"
    And  I fill in "Description" with:
    """
    Reluctant retired...
    --------------------
    Rocky takes on...
    """
    And I fill in "Price" with "10.25"
    And I fill in "Name" with "Rocky V (Five)"
    And I select "Books" from "Category"
    And I press "Save changes"
    When I edit the film "Rocky V (Five)"
    Then I should see the following text in the "Description" field:
    """
    Reluctant retired...
    --------------------
    Rocky takes on...
    """
    And I press "Save changes"
    Then I should see a row with name "Rocky V (Five)", price "10.25" and category "Books"

  # ./bin/behat --config app/config/behat.yml --suite=product --tags=DELETE
  @DELETE
  @javascript
  Scenario: Delete a product
    When I fill the text "Rocky V" in the search box
    And  I press "Search"
    Then I should see a row with name "Rocky V", price "14.85" and category "Films"

    When I click delete for the product "Rocky V"
    And  I confirm Deletion
    When I fill the text "Rocky V" in the search box
    And  I press "Search"
    Then I should see "No results found"



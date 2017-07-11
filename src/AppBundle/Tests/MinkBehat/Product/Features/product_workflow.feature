Feature: Product Workflow
  In order to offer a user a new product
  As an admin user
  I should be able to create a product in the backend and then make it visible to everyone

  Scenario: Add a product from backend and list it in frontend
    Given I go to homepage
    When  I follow "Login"

    And   I fill in "Username" with "admin"
    And   I fill in "Password" with "admin"
    And   I press "Log in"
    Then  I should see "Mink Behat Admin Dashboard"

    When  I follow "Product"
    And   I follow "Add Product"
    Then  I should see "Create Product"
    And   I fill in "Name" with "The Delta force"
    And   I fill in "Price" with "55"
    And   I fill in "Description" with "A film about terrorists and airplane hijacking"
    And   I select "Films" from "Category"
    And   I press "Save changes"
    When  I go to homepage
    And   I follow "List Products"
    Then  I should see listed first the product with name "The Delta force", price "55.00", category "Films" and description "A film about terrorists and airplane hijacking"

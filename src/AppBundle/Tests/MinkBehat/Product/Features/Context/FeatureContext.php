<?php

namespace AppBundle\Tests\MinkBehat\Product\Features\Context;

use Behat\Gherkin\Node\PyStringNode;
use AppBundle\Entity\Product;
use AppBundle\Tests\MinkBehat\AbstractFeatureContext;
use AppBundle\Tests\MinkBehat\DataFixturesTrait;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Doctrine\ORM\EntityManager;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

use \PHPUnit_Framework_Assert as phpUnit;

class FeatureContext extends AbstractFeatureContext implements Context
{
    use DataFixturesTrait;

    /** @BeforeScenario */
    public function beforeScenario(BeforeScenarioScope $event)
    {
        $dataFixtures = [
            sprintf('%s/src/AppBundle/DataFixtures/ORM/LoadUserData.php', self::$kernel->getProjectDir()),
            sprintf('%s/src/AppBundle/DataFixtures/ORM/LoadProductData.php', self::$kernel->getProjectDir()),
        ];

        $this->loadDataFixturesFromArrayOfDataFixtureFiles(
            $this->getContainer()->get('doctrine.orm.entity_manager'),
            $dataFixtures,
            $this->getContainer()
        );
    }

    /**
     * @Then I should see listed first the product with name :name, price :price, category :category and description :description
     */
    public function iShouldSeeListedFirstTheProductWithNamePriceCategoryAndDescription($name, $price, $category, $description)
    {
        /** @var Page $page */
        $page = $this->getSession()->getPage();

        /** @var NodeElement $block */
        $block = $page->find('css', '.product');

        phpUnit::assertEquals($block->find('css', '.title')->getText(), $name, 'Title not found');
        phpUnit::assertEquals($block->find('css', '.description')->getText(), $description, 'Description not found');
        phpUnit::assertEquals(
            $block->find('css', '.category')->getText(),
            sprintf('Category: %s', $category),
            'Category not found'
        );

        phpUnit::assertEquals(
            $block->find('css', '.price')->getText(),
            sprintf('Price: %s€', $price),
            'Category not found'
        );
    }

    /**
     * @Given /^The following films$/
     */
    public function theFollowingFilms(TableNode $table)
    {
        /** @var EntityManager $em */
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        foreach ($table as $row) {
            $categoryEntity = $em->getRepository('AppBundle:Category')->findOneByName($row['category']);

            $productEntity = new Product();
            $productEntity->setName($row['name']);
            $productEntity->setDescription($row['description']);
            $productEntity->setPrice($row['price']);
            $productEntity->setCategory($categoryEntity);
            $productEntity->setCreatedAt(new \DateTime());

            $em->persist($productEntity);
            $em->flush();
        }
    }

    /**
     * @Then /^I should see a row with name "([^"]*)", price "([^"]*)" and category "([^"]*)"$/
     */
    public function iShouldSeeARowWithNamePriceAndCategory($name, $price, $category)
    {
        $existsRowInfo = $this->existsRowInfo($name, $price, $category);
        phpUnit::assertTrue(
            $existsRowInfo,
            sprintf('No row found for name: "%s", price "%s" and category "%s"',
                $name, $price, $category
            )
        );
    }

    private function existsRowInfo($name, $price, $category)
    {
        /** @var NodeElement[] $rows */
        $rows = $this->getSession()->getPage()->findAll(
            'xpath',
            '//table/tbody/tr[@data-id]'
        );

        $values = ['Name' => $name, 'Price' => $price, 'Category' => $category];

        $lambda = function (NodeElement $row, array $values) {

            $matches = 0;
            foreach ($values as $key => $value) {
                if (
                    null !== ($cell = $row->find('css', sprintf('td[data-label="%s"]', $key)))
                    &&
                    $cell->getText() == $values[$key]
                ) {
                    $matches++;
                }
            }
            return count($values) == $matches;
        };

        $existsRowInfo = false;
        foreach ($rows as $row) {
            if ($lambda($row, $values)) {
                $existsRowInfo = true;
                break;
            }
        }
        return $existsRowInfo;
    }

    /**
     * @Given /^I fill the text "([^"]*)" in the search box$/
     */
    public function iFillTheTextInTheSearchBox($searchString)
    {
        /** @var NodeElement $searchBox */
        $searchBox = $this->getSession()->getPage()->find('css', '.form-control');
        $searchBox->setValue($searchString);
    }

    /**
     * @Given /^the following products exists$/
     */
    public function theFollowingProductsExists(TableNode $table)
    {
        foreach ($table as $row) {
            $found = $this->existsRowInfo($row['name'], $row['price'], $row['category']);
            phpUnit::assertTrue(
                $found,
                sprintf('No row found for name "%s", price "%s" and category "%s"',
                    $row['name'], $row['price'], $row['category']
                )
            );
        }
    }

    /**
     * @Given /^I edit the film "([^"]*)"$/
     */
    public function iEditTheFilm($name)
    {
        $link = $this->getActionLinkFromProductName($name, 'Edit');

        if (null !== $link) {
            $link->click();
        } else {
            phpUnit::assertNotNull($link, sprintf('The film "%s" was not found', $name));
        }

    }

    private function getActionLinkFromProductName($nameOfProduct, $nameOfLink)
    {
        $page = $this->getSession()->getPage();
        $cells = $page->findAll(
            'xpath',
            '//table/tbody/tr[@data-id]/td[@data-label=\'Name\']'
        );

        $found = false;
        /** @var NodeElement $cell */
        foreach ($cells as $cell) {
            if ($cell->getText() == $nameOfProduct) {
                $found = true;
                break;
            }
        }

        if ($found) {
            $link = $cell->getParent()->find('named', array('link', $nameOfLink));
        } else {
            $link = null;
        }
        return $link;
    }

    /**
     * @Then I should see the following text in the :arg1 field:
     */
    public function iShouldSeeTheFollowingTextInTheField($name, PyStringNode $string)
    {
        $page = $this->getSession()->getPage();
        $field = $page->findField($name);
        $string = join(PHP_EOL, $string->getStrings());
        phpUnit::assertEquals($field->getValue(), $string);
    }

    /**
     * @When I click delete for the product :arg1
     */
    public function iClickDeleteForTheProduct($name)
    {
        $link = $this->getActionLinkFromProductName($name, 'Delete');
        $link->click();
    }

    /**
     * @When I confirm Deletion
     */
    public function iConfirmDeletion()
    {
        try {
            $this->spins(
              function (FeatureContext $context) {
                  /** @var NodeElement $modalDeleteDiv */
                  $modalDeleteDiv = $context->getSession()->getPage()->findById('modal-delete');
                  $deleteButton = $modalDeleteDiv->findById('modal-delete-button');

                  $clicked = false;
                  if ($deleteButton->isVisible()) {
                      $deleteButton->click();
                      $clicked = true;
                  }
                  return $clicked;
              }
            );
        } catch (\Exception $e) {
            phpUnit::assertTrue(false, $e->getMessage());
        }
    }

}

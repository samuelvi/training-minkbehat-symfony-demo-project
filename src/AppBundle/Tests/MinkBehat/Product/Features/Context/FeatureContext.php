<?php

namespace AppBundle\Tests\MinkBehat\Product\Features\Context;

use AppBundle\Tests\MinkBehat\AbstractFeatureContext;
use AppBundle\Tests\MinkBehat\DataFixturesTrait;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Mink\Element\NodeElement;
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
}

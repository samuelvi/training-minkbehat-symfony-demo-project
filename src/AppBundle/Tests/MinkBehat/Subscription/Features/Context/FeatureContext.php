<?php

namespace AppBundle\Tests\MinkBehat\Subscription\Features\Context;

use AppBundle\Tests\MinkBehat\AbstractFeatureContext;
use AppBundle\Tests\MinkBehat\DataFixturesTrait;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Mink\Session;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use \PHPUnit_Framework_Assert as phpUnit;

class FeatureContext extends AbstractFeatureContext implements Context
{
    use DataFixturesTrait;

    /** @var  ContainerAwareInterface */
    private static $container;

    /** @var  EntityManager */
    private static $em;

    /** @BeforeScenario */
    public function beforeScenario(BeforeScenarioScope $scope)
    {
        static::$container = $this->getContainer();
        static::$em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $this->resizeWindow();

        if (!in_array('IGNORE_DATAFIXTURES', $scope->getScenario()->getTags())) {
            $this->loadDataFixtures();
        }
    }

    /**
     * @When /^I scroll to "([^"]*)"$/
     */
    public function iScrollTo($text)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('named', ['content', $text]);
        $element->focus();
    }


    /**
     * @Then /^I should see after a while "([^"]*)"$/
     * @Then /^I should see after a while '([^']*)'$/
     */
    public function iShouldSeeAfterAWhile($message)
    {
//        try {
//
//            $waitForMessageToAppear = function (FeatureContext $context) use ($message) {
//                return $context->getSession()->getPage()->find('named', ['content', $message]);
//            };
//
//            $this->spins($waitForMessageToAppear);
//
//        } catch (\Exception $e) {
//            phpUnit::assertTrue(false, $e->getMessage());
//        }

        /** @var Session $session */
        $session = $this->getSession();

        $js = sprintf('return $("body").text().indexOf("%s") > -1', $message);
        $session->wait(5000, $session->evaluateScript($js));

        phpUnit::assertTrue(
            $session->evaluateScript($js),
            sprintf('The message "%s" was not found on page', $message)
        );
    }

    public function resizeWindow()
    {
        $this->getSession()->resizeWindow(800, 600);
    }

    private function loadDataFixtures()
    {
        $dataFixtures = [
            self::$kernel->getRootDir() . '/../src/AppBundle/DataFixtures/ORM/LoadSubscriptionData.php',
            self::$kernel->getProjectDir() . '/src/AppBundle/DataFixtures/ORM/LoadSubscriptionData.php',
        ];

        $this->loadDataFixturesFromArrayOfDataFixtureFiles(
            static::$em,
            $dataFixtures,
            static::$container
        );
    }
}

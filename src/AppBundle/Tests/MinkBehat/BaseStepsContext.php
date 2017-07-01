<?php

namespace AppBundle\Tests\MinkBehat;

use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Driver\Selenium2Driver;
use \PHPUnit_Framework_Assert as phpUnit;
use Symfony\Component\BrowserKit\Client;

class BaseStepsContext extends AbstractFeatureContext
{

    /**
     * @AfterStep
     * @param AfterStepScope $scope
     */
    public function takeScreenShotAfterFailedStep(AfterStepScope $scope)
    {
        if (99 === $scope->getTestResult()->getResultCode()) {
            $this->takeScreenShot('test_failed_');
        }
    }

    /**
     * @When I take a screenshot
     * @When I take a screenshot with name :fileName
     */
    public function takeScreenShot($fileName = null)
    {
        $fileName = sprintf('%s-%s', date('ymdHis'), ($fileName != null) ? ($fileName) : ('test_'));

        if ($this->isJavascript()) {
            $extension = '.png';
            $this->saveScreenshot($fileName . $extension, $this->getScreenShotFolder());
        } else {
            $extension = '.html';
            file_put_contents(sprintf('%s%s%s', $this->getScreenShotFolder(), $fileName, $extension), $this->getSession()->getPage()->getOuterHtml());
        }
    }

    /**
     * @When I wait for :seconds seconds
     */
    public function iWaitForSeconds($seconds, $condition = 'false')
    {
        $this->getSession()->wait($seconds * 1000, $condition);
    }

    /**
     * @When /^(?:|I )confirm the popup$/
     */
    public function confirmPopup()
    {
        /** @var Selenium2Driver $driver */
        $driver = $this->getSession()->getDriver();

        $driver->getWebDriverSession()->accept_alert();
    }

    /**
     * @When /^(?:|I )cancel the popup$/
     */
    public function cancelPopup()
    {
        /** @var Selenium2Driver $driver */
        $driver = $this->getSession()->getDriver();

        $driver->getWebDriverSession()->dismiss_alert();
    }

    /**
     * @When /^(?:|I )should see "([^"]*)" in popup$/
     *
     * @param string $message The message.
     *
     * @return bool
     */
    public function assertPopupMessage($message)
    {
        /** @var Selenium2Driver $driver */
        $driver = $this->getSession()->getDriver();

        return $message == $driver->getWebDriverSession()->getAlert_text();
    }

    /**
     * @When /^(?:|I )fill "([^"]*)" in popup$/
     *
     * @param string $message The message.
     */
    public function setPopupText($message)
    {
        /** @var Selenium2Driver $driver */
        $driver = $this->getSession()->getDriver();

        $driver->getWebDriverSession()->postAlert_text($message);
    }

    protected function loginUser($email, $password)
    {
        $page = $this->getSession()->getPage();

        $page->findField('Username')->setValue($email);
        $page->findField('Password')->setValue($password);
        $page->pressButton('Log in');
    }

    /**
     * @When I login as Admin
     */
    public function iLoginAsAdmin()
    {
        $this->loginUser('admin', 'admin');
    }


    /**
     * @When I login as User with Username "([^"]*)" and password "([^"]*)"
     */
    public function iLoginAsUser($userName, $password)
    {
        $this->loginUser($userName, $password);
    }


    /**
     * @When /^I follow the redirection$/
     * @Then /^I should be redirected$/
     */
    public function iFollowTheRedirection()
    {
        $this->canIntercept();

        /** @var BrowserKitDriver $driver */
        $driver = $this->getSession()->getDriver();

        /** @var Client $client */
        $client = $driver->getClient();
        $client->followRedirects(true);
        $client->followRedirect();
    }

    /**
     * @When /^I click on "([^"]*)"$/
     */
    public function iClickOn($text)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('xpath', sprintf('//*[text()[contains(.,"%s")]]', $text));
        phpUnit::assertTrue($element->isVisible());
        $element->click();
    }

    /**
     * @Then /^breakpoint$/i
     */
    public function breakPoint()
    {
        fwrite(STDOUT, "\033[s    \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
        while (fgets(STDIN, 1024) == '') {
        }
        fwrite(STDOUT, "\033[u");
        return;
    }

    /**
     *
     * NOTICE: THIS IS A BAD PRACTICE. JUST WRITTEN FOR DEMONSTRATION PURPOSES.
     * @Given /^I sleep (\d+) seconds$/
     */
    public function iSleepSeconds($seconds)
    {
        usleep($seconds*1000000);
    }

}
<?php

namespace AppBundle\Tests\MinkBehat\ContactForm\Features\Context;

use AppBundle\Tests\MinkBehat\AbstractFeatureContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Element\NodeElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;
use \PHPUnit_Framework_Assert as phpUnit;

class FeatureContext extends AbstractFeatureContext implements Context
{
    /**
     * @When /^I type "([^"]*)" in "([^"]*)"$/
     */
    public function iTypeIn($text, $label)
    {
        $elements = [
            'E-mail' => 'chuck_norris@hitme.com', // PlaceHolder
            'Subject' => 'contact_form_type[subject]', // NAME
        ];

        /** @var Page $page */
        $page = $this->getSession()->getPage();
        $locator = $elements[$label];

        /** @var NodeElement $nodeElement */
        $nodeElement = $page->findField($locator);
        $nodeElement->setValue($text);
    }

    /**
     * @When /^I submit the contact form$/
     */
    public function iSubmitTheContactForm()
    {
        $this->canIntercept();
        $this->getSession()->getDriver()->getClient()->followRedirects(false);

        $this->getSession()->getPage()->pressButton('Send Contact Form Request');
    }

    /**
     * @Then One e-mail should be sent to the requester and another one to the webmaster
     */
    public function oneEMailShouldBeSentToTheRequesterAndAnotherOneToTheWebmaster()
    {
        $profile = $this->getSymfonyProfile();

        /** @var MessageDataCollector $collector */
        $collector = $profile->getCollector('swiftmailer');

        phpUnit::assertEquals(2, $collector->getMessageCount(),
            sprintf('2 messages should be sent, but found %d', $collector->getMessageCount()));

        $messagesToCheck = [
            'Thank you Wendy Wolf for contacting Us!',
            'A user contacted Us! (Wendy Wolf)'
        ];

        foreach ($collector->getMessages() as $idx => $message) {
            phpUnit::assertEquals($messagesToCheck[$idx], $message->getSubject());
        }
    }
}

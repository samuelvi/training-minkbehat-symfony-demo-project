<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\Subscription as SubscriptionEntity;

class LoadSubscriptionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var SubscriptionEntity $subscriptionEntity */
        $subscriptionEntity = new SubscriptionEntity();
        $subscriptionEntity->setFullname('Chuck Norris');
        $subscriptionEntity->setEmail('chucknorris@never-fails-a-test.never');
        $manager->persist($subscriptionEntity);
        $manager->flush();
        $this->addReference('subscription-chucknorris', $subscriptionEntity);
    }

    public function getOrder()
    {
        return 10;
    }
}
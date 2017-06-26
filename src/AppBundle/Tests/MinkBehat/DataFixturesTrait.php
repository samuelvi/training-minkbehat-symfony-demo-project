<?php

namespace AppBundle\Tests\MinkBehat;

use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use InvalidArgumentException;

trait DataFixturesTrait
{
    /**
     * @param EntityManager $em
     * @param string $table
     */
    public function truncateTable($em, $table)
    {
        $connection = $em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $truncateSql = $platform->getTruncateTableSQL($table);
        $connection->executeUpdate($truncateSql);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
    }

    /**
     * @param EntityManager $em
     * @param array $dataFixtureFiles
     */
    public function loadDataFixturesFromArrayOfDataFixtureFiles($em, $dataFixtureFiles, $container)
    {
        $loader = new Loader();

        foreach ($dataFixtureFiles as $dataFixtureFile) {
            $loader->loadFromFile($dataFixtureFile);
        }

        $fixtures = $loader->getFixtures();

        // Explicit container injection. At this point container inside the fixture is null.
        foreach ($fixtures as $fixture) {
            if (method_exists($fixture, 'setContainer')) {
                $fixture->setContainer($container);
            }
        }

        if (!$fixtures) {
            throw new InvalidArgumentException('Could not find any fixtures to load in');
        }

        $purger = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($fixtures, false);
    }
}
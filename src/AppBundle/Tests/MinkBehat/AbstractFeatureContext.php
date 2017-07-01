<?php

namespace AppBundle\Tests\MinkBehat;

use Behat\Mink\Driver\Selenium2Driver;

use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\MinkExtension\ServiceContainer\Driver\SahiFactory;
use Behat\Symfony2Extension\Context\KernelAwareContext;

use Behat\Symfony2Extension\Driver\KernelDriver;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Profiler\Profile;


abstract class AbstractFeatureContext extends RawMinkContext implements KernelAwareContext
{
    /** @var  Kernel $kernel */
    protected static $kernel;

    public function setKernel(KernelInterface $kernel)
    {
        self::$kernel = $kernel;
    }

    protected function getContainer()
    {
        return static::$kernel->getContainer();
    }

    public function __call($method, $parameters)
    {
        // we try to call the method on the Page first
        $page = $this->getSession()->getPage();
        if (method_exists($page, $method)) {
            return call_user_func_array(array($page, $method), $parameters);
        }

        // we try to call the method on the Session
        $session = $this->getSession();
        if (method_exists($session, $method)) {
            return call_user_func_array(array($session, $method), $parameters);
        }

        // could not find the method at all
        throw new \RuntimeException(sprintf(
            'The "%s()" method does not exist.', $method
        ));
    }

    /** @deprecated Use driverSupportsJavascript */
    protected function isJavascript()
    {
        $driver = $this->getSession()->getDriver();
        return ($driver instanceof Selenium2Driver || $driver instanceof SahiFactory);
    }

    protected function driverSupportsJavascript()
    {
        $driver = $this->getSession()->getDriver();
        return ($driver instanceof Selenium2Driver || $driver instanceof SahiFactory);
    }

    protected function driverSupportsPopUp($session = null)
    {
        $driver = $this->getSession($session)->getDriver();
        return ($driver instanceof Selenium2Driver);
    }

    public function spins($closure, $seconds = 5)
    {
        $fraction = 4;
        $max = $seconds * $fraction;
        $i = 1;
        while ($i++ <= $max) {
            if ($closure($this)) {
                return true;
            }
            $this->getSession()->wait(1000 / $fraction);
        }

        $backtrace = debug_backtrace();
        throw new \Exception(
            sprintf("Timeout thrown by %s::%s()\n%s, line %s",
                $backtrace[0]['class'], $backtrace[0]['function'], $backtrace[0]['file'], $backtrace[0]['line']
            )
        );
    }

    protected function getScreenShotFolder()
    {
        $kernelRootDir = $this->getContainer()->getParameter('kernel.root_dir');
        $tmpFolder = sprintf('%s/../src/AppBundle/Tests/MinkBehat/screenshots/', $kernelRootDir);
        is_dir($tmpFolder) || mkdir($tmpFolder, 0755, true);
        return $tmpFolder;
    }

    public function resizeWindow($width, $height, $name = 'current')
    {
        $this->getSession()->resizeWindow($width, $height, $name);
    }

    protected function loginUser($email, $password)
    {
        $page = $this->getSession()->getPage();

        $page->findField('Username')->setValue($email);
        $page->findField('Password')->setValue($password);
        $page->pressButton('Log in');
    }

    /**
     * @return mixed
     * @throws UnsupportedDriverActionException
     */
    public function getSymfonyProfile()
    {
        $driver = $this->getSession()->getDriver();
        if (!$driver instanceof KernelDriver) {
            throw new UnsupportedDriverActionException(
                'You need to tag the scenario with ' .
                '"@mink:symfony2". Using the profiler is not ' .
                'supported by %s', $driver
            );
        }

        /** @var Profile $profile */
        $profile = $driver->getClient()->getProfile();
        if (false === $profile) {
            throw new \RuntimeException(
                'The profiler is disabled. Activate it by setting ' .
                'framework.profiler.only_exceptions to false in ' .
                'your config'
            );
        }
        return $profile;
    }

    public function canIntercept()
    {
        $driver = $this->getSession()->getDriver();

        if (!$driver instanceof KernelDriver) {
            $message = <<<EOT
                You need to tag the scenario with "@mink:goutte" or "@mink:symfony2".
                Intercepting the redirections is not supported by %s
EOT;
            throw new UnsupportedDriverActionException($message, $driver);
        }
    }


}
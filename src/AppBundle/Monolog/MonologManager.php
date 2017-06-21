<?php

namespace AppBundle\Monolog;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Monolog\Logger;

use Monolog\Logger as BaseLogger;

class MonologManager
{
    /** @var Logger $logger  */
    private $logger;

    /** @var  string $kernelLogsDir */
    private $kernelLogsDir;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setKernelLogsDir($kernelLogsDir)
    {
        $this->kernelLogsDir = $kernelLogsDir;
    }

    public function getFile($level)
    {
        return sprintf('%s/%s-%s.log', $this->kernelLogsDir, $this->logger->getName(), strtolower(BaseLogger::getLevelName($level)));
    }

    protected function getDefaultFormat()
    {
        $dateFormat = 'Y-m-d, h:i:s';
        $output = "%datetime% | %level_name% | %message% | %context% | %extra%\n";
        return new LineFormatter($output, $dateFormat);
    }

    private function doLog($message, $context, $level)
    {
        $stream = new StreamHandler($this->getFile($level), $level);
        $stream->setFormatter($this->getDefaultFormat());
        $this->logger->pushHandler($stream);

        $method = sprintf('add%s', ucfirst(strtolower(BaseLogger::getLevelName($level))));
        $this->logger->$method($message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->doLog($message, $context, BaseLogger::ERROR);
    }

    public function warning($message, array $context = [])
    {
        $this->doLog($message, $context, BaseLogger::WARNING);
    }

    public function critical($message, array $context = [])
    {
        $this->doLog($message, $context, BaseLogger::CRITICAL);
    }

    public function info($message, array $context = [])
    {
        $this->doLog($message, $context, BaseLogger::INFO);
    }
}
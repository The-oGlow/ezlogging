<?php

declare(strict_types=1);

namespace Monolog;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Processor\ProcessorInterface;

/**
 * Class AbstractEasyGoingLogger
 *
 * @package Monolog
 */
abstract class AbstractEasyGoingLogger extends Logger
{
    public const STANDARD_TIMEZONE = "Europe/Berlin";
    public const STANDARD_FILENAME = 'noFilename';
    public const STANDARD_FILEEXT  = '.log';
    public const HANDLER_STDOUT    = "php://stdout";
    protected $targetFile;

    /**
     * AbstractEasyGoingLogger constructor.
     *
     * @param string $name
     * @param array  $handlers
     * @param array  $processors
     * @param null   $timezone
     */
    public function __construct($name, $handlers = [], $processors = [], $timezone = null)
    {
        parent::__construct(
            $name,
            $handlers,
            $processors,
            $timezone ?? new \DateTimeZone(date_default_timezone_get() ?? self::STANDARD_TIMEZONE)
        );
        $this->pushProcessor($this->getDefaultProcessor());
        $this->pushHandler($this->getConsoleHandler());
    }

    abstract protected function getDefaultHandler(): HandlerInterface;

    abstract protected function getDefaultProcessor(): ProcessorInterface;

    abstract protected function getDefaultFormatter(): FormatterInterface;

    /**
     * @return Handler\StreamHandler
     */
    protected function getConsoleHandler()
    {
        $consoleHandler = new Handler\StreamHandler(self::HANDLER_STDOUT);
        $consoleHandler->setFormatter($this->getDefaultFormatter());

        return $consoleHandler;
    }

    /**
     * @param string $pathToFile
     * @param string $fileName
     *
     * @return Handler\StreamHandler
     */
    protected function getFileHandler(string $pathToFile, string $fileName = self::STANDARD_FILENAME)
    {
        $this->targetFile = $pathToFile . DIRECTORY_SEPARATOR . str_replace("\\", "_", $fileName . self::STANDARD_FILEEXT);
        $fileHandler      = new Handler\StreamHandler($this->targetFile);

        return $fileHandler;
    }
}

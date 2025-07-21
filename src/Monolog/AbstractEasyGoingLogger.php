<?php

declare(strict_types=1);

namespace Monolog;

use DateTimeZone;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
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
    protected string $targetFile;

    /**
     * AbstractEasyGoingLogger constructor.
     *
     * @param string             $name       The logging channel, a simple descriptive name that is attached to all log records
     * @param HandlerInterface[] $handlers   Optional stack of handlers, the first one in the array is called first, etc.
     * @param callable[]         $processors Optional array of processors
     * @param DateTimeZone|null  $timezone   Optional timezone, if not provided date_default_timezone_get() will be used
     */
    public function __construct(string $name, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null)
    {
        parent::__construct(
            $name,
            $handlers,
            $processors,
            $timezone ?? new DateTimeZone(!empty(date_default_timezone_get()) ? date_default_timezone_get() : self::STANDARD_TIMEZONE)
        );
        $this->pushProcessor($this->getDefaultProcessor());
        $this->pushHandler($this->getConsoleHandler());
    }

    abstract protected function getDefaultHandler(): HandlerInterface;

    abstract protected function getDefaultProcessor(): ProcessorInterface;

    abstract protected function getDefaultFormatter(): FormatterInterface;

    protected function getConsoleHandler(): StreamHandler
    {
        $consoleHandler = new Handler\StreamHandler(self::HANDLER_STDOUT);
        $consoleHandler->setFormatter($this->getDefaultFormatter());

        return $consoleHandler;
    }

    protected function getFileHandler(string $pathToFile, string $fileName = self::STANDARD_FILENAME): StreamHandler
    {
        $this->targetFile = $pathToFile . DIRECTORY_SEPARATOR . str_replace("\\", "_", $fileName . self::STANDARD_FILEEXT);

        return new Handler\StreamHandler($this->targetFile);
    }
}

<?php

declare (strict_types=1);
/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Monolog\Test;

use ZOOlanders\YOOessentials\Vendor\Monolog\Logger;
use ZOOlanders\YOOessentials\Vendor\Monolog\DateTimeImmutable;
use ZOOlanders\YOOessentials\Vendor\Monolog\Formatter\FormatterInterface;
/**
 * Lets you easily generate log records and a dummy formatter for testing purposes
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 *
 * @phpstan-import-type Record from \Monolog\Logger
 * @phpstan-import-type Level from \Monolog\Logger
 *
 * @internal feel free to reuse this to test your own handlers, this is marked internal to avoid issues with PHPStorm https://github.com/Seldaek/monolog/issues/1677
 */
class TestCase extends \ZOOlanders\YOOessentials\Vendor\PHPUnit\Framework\TestCase
{
    public function tearDown() : void
    {
        parent::tearDown();
        if (isset($this->handler)) {
            unset($this->handler);
        }
    }
    /**
     * @param mixed[] $context
     *
     * @return array Record
     *
     * @phpstan-param  Level $level
     * @phpstan-return Record
     */
    protected function getRecord(int $level = \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::WARNING, string $message = 'test', array $context = []) : array
    {
        return ['message' => (string) $message, 'context' => $context, 'level' => $level, 'level_name' => \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::getLevelName($level), 'channel' => 'test', 'datetime' => new \ZOOlanders\YOOessentials\Vendor\Monolog\DateTimeImmutable(\true), 'extra' => []];
    }
    /**
     * @phpstan-return Record[]
     */
    protected function getMultipleRecords() : array
    {
        return [$this->getRecord(\ZOOlanders\YOOessentials\Vendor\Monolog\Logger::DEBUG, 'debug message 1'), $this->getRecord(\ZOOlanders\YOOessentials\Vendor\Monolog\Logger::DEBUG, 'debug message 2'), $this->getRecord(\ZOOlanders\YOOessentials\Vendor\Monolog\Logger::INFO, 'information'), $this->getRecord(\ZOOlanders\YOOessentials\Vendor\Monolog\Logger::WARNING, 'warning'), $this->getRecord(\ZOOlanders\YOOessentials\Vendor\Monolog\Logger::ERROR, 'error')];
    }
    protected function getIdentityFormatter() : \ZOOlanders\YOOessentials\Vendor\Monolog\Formatter\FormatterInterface
    {
        $formatter = $this->createMock(\ZOOlanders\YOOessentials\Vendor\Monolog\Formatter\FormatterInterface::class);
        $formatter->expects($this->any())->method('format')->will($this->returnCallback(function ($record) {
            return $record['message'];
        }));
        return $formatter;
    }
}

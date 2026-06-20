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
namespace ZOOlanders\YOOessentials\Vendor\Monolog\Formatter;

use ZOOlanders\YOOessentials\Vendor\Monolog\Logger;
/**
 * Formats a log message according to the ChromePHP array format
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ChromePHPFormatter implements \ZOOlanders\YOOessentials\Vendor\Monolog\Formatter\FormatterInterface
{
    /**
     * Translates Monolog log levels to Wildfire levels.
     *
     * @var array<int, 'log'|'info'|'warn'|'error'>
     */
    private $logLevels = [\ZOOlanders\YOOessentials\Vendor\Monolog\Logger::DEBUG => 'log', \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::INFO => 'info', \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::NOTICE => 'info', \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::WARNING => 'warn', \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::ERROR => 'error', \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::CRITICAL => 'error', \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::ALERT => 'error', \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::EMERGENCY => 'error'];
    /**
     * {@inheritDoc}
     */
    public function format(array $record)
    {
        // Retrieve the line and file if set and remove them from the formatted extra
        $backtrace = 'unknown';
        if (isset($record['extra']['file'], $record['extra']['line'])) {
            $backtrace = $record['extra']['file'] . ' : ' . $record['extra']['line'];
            unset($record['extra']['file'], $record['extra']['line']);
        }
        $message = ['message' => $record['message']];
        if ($record['context']) {
            $message['context'] = $record['context'];
        }
        if ($record['extra']) {
            $message['extra'] = $record['extra'];
        }
        if (\count($message) === 1) {
            $message = \reset($message);
        }
        return [$record['channel'], $message, $backtrace, $this->logLevels[$record['level']]];
    }
    /**
     * {@inheritDoc}
     */
    public function formatBatch(array $records)
    {
        $formatted = [];
        foreach ($records as $record) {
            $formatted[] = $this->format($record);
        }
        return $formatted;
    }
}

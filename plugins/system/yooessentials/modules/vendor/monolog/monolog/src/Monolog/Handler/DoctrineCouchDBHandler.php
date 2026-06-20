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
namespace ZOOlanders\YOOessentials\Vendor\Monolog\Handler;

use ZOOlanders\YOOessentials\Vendor\Monolog\Logger;
use ZOOlanders\YOOessentials\Vendor\Monolog\Formatter\NormalizerFormatter;
use ZOOlanders\YOOessentials\Vendor\Monolog\Formatter\FormatterInterface;
use ZOOlanders\YOOessentials\Vendor\Doctrine\CouchDB\CouchDBClient;
/**
 * CouchDB handler for Doctrine CouchDB ODM
 *
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 */
class DoctrineCouchDBHandler extends \ZOOlanders\YOOessentials\Vendor\Monolog\Handler\AbstractProcessingHandler
{
    /** @var CouchDBClient */
    private $client;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Doctrine\CouchDB\CouchDBClient $client, $level = \ZOOlanders\YOOessentials\Vendor\Monolog\Logger::DEBUG, bool $bubble = \true)
    {
        $this->client = $client;
        parent::__construct($level, $bubble);
    }
    /**
     * {@inheritDoc}
     */
    protected function write(array $record) : void
    {
        $this->client->postDocument($record['formatted']);
    }
    protected function getDefaultFormatter() : \ZOOlanders\YOOessentials\Vendor\Monolog\Formatter\FormatterInterface
    {
        return new \ZOOlanders\YOOessentials\Vendor\Monolog\Formatter\NormalizerFormatter();
    }
}

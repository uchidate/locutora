<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContentsPlaceholder;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class TableOfContentsPlaceholderParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    private $config;
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        $placeholder = $this->config->get('table_of_contents/placeholder');
        if ($placeholder === null) {
            return \false;
        }
        // The placeholder must be the only thing on the line
        if ($cursor->match('/^' . \preg_quote($placeholder, '/') . '$/') === null) {
            return \false;
        }
        $context->addBlock(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContentsPlaceholder());
        return \true;
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}

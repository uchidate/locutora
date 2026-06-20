<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) Rezo Zero / Ambroise Maupate
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Parser;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteRef;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\Reference;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class FootnoteRefParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    private $config;
    public function getCharacters() : array
    {
        return ['['];
    }
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineContext) : bool
    {
        $container = $inlineContext->getContainer();
        $cursor = $inlineContext->getCursor();
        $nextChar = $cursor->peek();
        if ($nextChar !== '^') {
            return \false;
        }
        $state = $cursor->saveState();
        $m = $cursor->match('#\\[\\^([^\\]]+)\\]#');
        if ($m !== null) {
            if (\preg_match('#\\[\\^([^\\]]+)\\]#', $m, $matches) > 0) {
                $container->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteRef($this->createReference($matches[1])));
                return \true;
            }
        }
        $cursor->restoreState($state);
        return \false;
    }
    private function createReference(string $label) : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\Reference
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\Reference($label, '#' . $this->config->get('footnote/footnote_id_prefix', 'fn:') . $label, $label);
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $config) : void
    {
        $this->config = $config;
    }
}

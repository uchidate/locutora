<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (https://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * Additional emphasis processing code based on commonmark-java (https://github.com/atlassian/commonmark-java)
 *  - (c) Atlassian Pty Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor;

final class DelimiterProcessorCollection implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorCollectionInterface
{
    /** @var array<string,DelimiterProcessorInterface>|DelimiterProcessorInterface[] */
    private $processorsByChar = [];
    public function add(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface $processor)
    {
        $opening = $processor->getOpeningCharacter();
        $closing = $processor->getClosingCharacter();
        if ($opening === $closing) {
            $old = $this->processorsByChar[$opening] ?? null;
            if ($old !== null && $old->getOpeningCharacter() === $old->getClosingCharacter()) {
                $this->addStaggeredDelimiterProcessorForChar($opening, $old, $processor);
            } else {
                $this->addDelimiterProcessorForChar($opening, $processor);
            }
        } else {
            $this->addDelimiterProcessorForChar($opening, $processor);
            $this->addDelimiterProcessorForChar($closing, $processor);
        }
    }
    public function getDelimiterProcessor(string $char) : ?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface
    {
        return $this->processorsByChar[$char] ?? null;
    }
    public function getDelimiterCharacters() : array
    {
        return \array_keys($this->processorsByChar);
    }
    private function addDelimiterProcessorForChar(string $delimiterChar, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface $processor) : void
    {
        if (isset($this->processorsByChar[$delimiterChar])) {
            throw new \InvalidArgumentException(\sprintf('Delim processor for character "%s" already exists', $processor->getOpeningCharacter()));
        }
        $this->processorsByChar[$delimiterChar] = $processor;
    }
    private function addStaggeredDelimiterProcessorForChar(string $opening, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface $old, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface $new) : void
    {
        if ($old instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\StaggeredDelimiterProcessor) {
            $s = $old;
        } else {
            $s = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\StaggeredDelimiterProcessor($opening, $old);
        }
        $s->add($new);
        $this->processorsByChar[$opening] = $s;
    }
}

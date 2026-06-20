<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Exception\InvalidOptionException;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\Slug\SlugGeneratorInterface as DeprecatedSlugGeneratorInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer\SlugNormalizer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer\TextNormalizerInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
/**
 * Searches the Document for Heading elements and adds HeadingPermalinks to each one
 */
final class HeadingPermalinkProcessor implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface
{
    const INSERT_BEFORE = 'before';
    const INSERT_AFTER = 'after';
    /** @var TextNormalizerInterface|DeprecatedSlugGeneratorInterface */
    private $slugNormalizer;
    /** @var ConfigurationInterface */
    private $config;
    /**
     * @param TextNormalizerInterface|DeprecatedSlugGeneratorInterface|null $slugNormalizer
     */
    public function __construct($slugNormalizer = null)
    {
        if ($slugNormalizer instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\Slug\SlugGeneratorInterface) {
            @\trigger_error(\sprintf('Passing a %s into the %s constructor is deprecated; use a %s instead', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\Slug\SlugGeneratorInterface::class, self::class, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer\TextNormalizerInterface::class), \E_USER_DEPRECATED);
        }
        $this->slugNormalizer = $slugNormalizer ?? new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer\SlugNormalizer();
    }
    public function setConfiguration(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
    public function __invoke(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent $e) : void
    {
        $this->useNormalizerFromConfigurationIfProvided();
        $walker = $e->getDocument()->walker();
        while ($event = $walker->next()) {
            $node = $event->getNode();
            if ($node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading && $event->isEntering()) {
                $this->addHeadingLink($node, $e->getDocument());
            }
        }
    }
    private function useNormalizerFromConfigurationIfProvided() : void
    {
        $generator = $this->config->get('heading_permalink/slug_normalizer');
        if ($generator === null) {
            return;
        }
        if (!($generator instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\Slug\SlugGeneratorInterface || $generator instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer\TextNormalizerInterface)) {
            throw new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Exception\InvalidOptionException('The heading_permalink/slug_normalizer option must be an instance of ' . \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer\TextNormalizerInterface::class);
        }
        $this->slugNormalizer = $generator;
    }
    private function addHeadingLink(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading $heading, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document) : void
    {
        $text = $this->getChildText($heading);
        if ($this->slugNormalizer instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\Slug\SlugGeneratorInterface) {
            $slug = $this->slugNormalizer->createSlug($text);
        } else {
            $slug = $this->slugNormalizer->normalize($text, $heading);
        }
        $slug = $this->ensureUnique($slug, $document);
        $headingLinkAnchor = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\HeadingPermalink($slug);
        switch ($this->config->get('heading_permalink/insert', 'before')) {
            case self::INSERT_BEFORE:
                $heading->prependChild($headingLinkAnchor);
                return;
            case self::INSERT_AFTER:
                $heading->appendChild($headingLinkAnchor);
                return;
            default:
                throw new \RuntimeException("Invalid configuration value for heading_permalink/insert; expected 'before' or 'after'");
        }
    }
    /**
     * @deprecated Not needed in 2.0
     */
    private function getChildText(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node $node) : string
    {
        $text = '';
        $walker = $node->walker();
        while ($event = $walker->next()) {
            if ($event->isEntering() && ($child = $event->getNode()) instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer) {
                $text .= $child->getContent();
            }
        }
        return $text;
    }
    private function ensureUnique(string $proposed, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document) : string
    {
        // Quick path, it's a unique ID
        if (!isset($document->data['heading_ids'][$proposed])) {
            $document->data['heading_ids'][$proposed] = \true;
            return $proposed;
        }
        $extension = 0;
        do {
            ++$extension;
        } while (isset($document->data['heading_ids']["{$proposed}-{$extension}"]));
        $document->data['heading_ids']["{$proposed}-{$extension}"] = \true;
        return "{$proposed}-{$extension}";
    }
}

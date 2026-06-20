<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Element\Markdown;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentPreParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Input\MarkdownInput;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationAwareInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;

/**
 * Searches the Markdown for the Heading with level 1 and removes it
 */
final class HeadingRemoval implements ConfigurationAwareInterface
{
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }

    public function __invoke(DocumentPreParsedEvent $e): void
    {
        $levelToRemove = $this->config->get('heading_remove');

        if ($levelToRemove) {
            $md = $e->getMarkdown()->getContent();
            $md = preg_replace('/^# (.*)$/m', '', $md) ;

            $e->replaceMarkdown(new MarkdownInput($md));
        }
    }
}

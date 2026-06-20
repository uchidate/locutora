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
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;

/**
 * Searches the Markdown for Heading lines and escalates the level from the starting level point
 */
final class HeadingMinLevel implements ConfigurationAwareInterface
{
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }

    public function __invoke(DocumentPreParsedEvent $e): void
    {
        $startingLevel = $this->config->get('heading_starting_level');
        $diffLevel = 0;

        $lines = $e->getMarkdown()->getLines();
        $newlines = [];

        foreach ($lines as $line) {
            $match = RegexHelper::matchAll('/^(#{1,6}) (.*)/', $line);

            if ($match) {
                $level = strlen($match[1]);
                $text = $match[2];

                // once we know the diff level we can use it on subsequent
                if ($diffLevel === 0 and $startingLevel > $level) {
                    $diffLevel = $startingLevel - $level;
                }

                // increase the level at max 6
                $level = min($level + $diffLevel, 6);

                $newlines[] = str_repeat('#', $level) . " $text";

                continue;
            }

            $newlines[] = $line;
        }

        $e->replaceMarkdown(new MarkdownInput(implode("\n", $newlines)));
    }
}

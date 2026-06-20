<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Element\Markdown;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentPreParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;

final class HeadingExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addEventListener(DocumentPreParsedEvent::class, new HeadingRemoval(), -100);
        $environment->addEventListener(DocumentPreParsedEvent::class, new HeadingMinLevel(), -100);
    }
}

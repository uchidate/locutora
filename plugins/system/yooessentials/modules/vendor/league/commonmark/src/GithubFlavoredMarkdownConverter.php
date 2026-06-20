<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark;

/**
 * Converts Github Flavored Markdown to HTML.
 */
class GithubFlavoredMarkdownConverter extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\CommonMarkConverter
{
    /**
     * Create a new commonmark converter instance.
     *
     * @param array<string, mixed>      $config
     * @param EnvironmentInterface|null $environment
     */
    public function __construct(array $config = [], \ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface $environment = null)
    {
        if ($environment === null) {
            $environment = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Environment::createGFMEnvironment();
        } else {
            @\trigger_error(\sprintf('Passing an $environment into the "%s" constructor is deprecated in 1.6 and will not be supported in 2.0; use MarkdownConverter instead. See https://commonmark.thephpleague.com/2.0/upgrading/consumers/#commonmarkconverter-and-githubflavoredmarkdownconverter-constructors for more details.', self::class), \E_USER_DEPRECATED);
        }
        if ($environment instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface) {
            $environment->mergeConfig($config);
        }
        \ZOOlanders\YOOessentials\Vendor\League\CommonMark\MarkdownConverter::__construct($environment);
    }
}

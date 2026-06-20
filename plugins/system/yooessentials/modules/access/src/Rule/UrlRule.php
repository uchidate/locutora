<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

use YOOtheme\Arr;
use YOOtheme\Config;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Access\AbstractRule;

class UrlRule extends AbstractRule
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function group(): string
    {
        return 'site';
    }

    public function name(): string
    {
        return 'Url';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_url';
    }

    public function description(): string
    {
        return 'Validates against the site url.';
    }

    public function fields(): array
    {
        return [
            'urls' => [
                'label' => 'Patterns',
                'type' => 'textarea',
                'source' => true,
                'description' => 'A list of part URLs to match the current request url. Separate the entries with a comma and/or new line.',
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => "localhost\nmy/site/section"
                ]
            ],
            'regex' => [
                'text' => 'Use Regular Expressions',
                'description' => 'Create advanced matches using <a href="https://regex101.com" target="_blank">Regular Expressions</a>, e.g. <code>\/$</code> to match the site home.',
                'type' => 'checkbox',
                'source' => true
            ]
        ];
    }

    public function resolveProps(object $props, object $node): object
    {
        if (!isset($props->urls)) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        $regex = $props->regex ?? false;

        return (object) [
            'regex' => $regex,
            'urls' => self::parseUrls($props->urls, $regex),
            'requestUrl' => $this->config->get('req.href') ?? ''
        ];
    }

    public function resolve($props, $node): bool
    {
        $requestUrls = self::parseRequestUrl($props->requestUrl);

        return Arr::some($requestUrls, function ($url) use ($props) {
            return Arr::some($props->urls, function ($pattern) use ($url, $props) {
                if (!$props->regex) {
                    return Str::contains($url, $pattern);
                }

                if (@preg_match("{$pattern}u", $url) || @preg_match($pattern, $url)) {
                    return true;
                }

                return false;
            });
        });
    }

    protected static function parseUrls(string $urls, bool $regex): array
    {
        $urls = self::parseTextareaList($urls);

        return array_map(function ($url) use ($regex) {
            if ($regex) {
                $url = str_replace(['#', '&amp;'], ['\#', '(&amp;|&)'], $url);
                $url = "#{$url}#si";
            }

            return $url;
        }, $urls);
    }

    /**
     * Code adapted from Regular Labs Library version 20.9.11663
     *
     * @author Peter van Westen
     * @copyright Copyright © 2020 Regular Labs All Rights Reserved
     * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
     */
    protected static function parseRequestUrl(string $url): array
    {
        static $urls = [];

        if (!empty($urls)) {
            return $urls;
        }

        $urls = [
            html_entity_decode(urldecode($url), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            urldecode($url),
            html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            $url,
        ];

        return $urls = array_unique($urls);
    }
}

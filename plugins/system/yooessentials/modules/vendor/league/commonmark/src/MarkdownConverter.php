<?php

declare (strict_types=1);
/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark;

class MarkdownConverter extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Converter
{
    /** @var EnvironmentInterface */
    protected $environment;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface $environment)
    {
        $this->environment = $environment;
        parent::__construct(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\DocParser($environment), new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlRenderer($environment));
    }
    public function getEnvironment() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface
    {
        return $this->environment;
    }
}

<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\Slug;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer\TextNormalizerInterface;
@\trigger_error(\sprintf('%s is deprecated; use %s instead', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\Slug\SlugGeneratorInterface::class, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer\TextNormalizerInterface::class), \E_USER_DEPRECATED);
/**
 * @deprecated Use League\CommonMark\Normalizer\TextNormalizerInterface instead
 */
interface SlugGeneratorInterface
{
    /**
     * Create a URL-friendly slug based on the given input string
     *
     * @param string $input
     *
     * @return string
     */
    public function createSlug(string $input) : string;
}

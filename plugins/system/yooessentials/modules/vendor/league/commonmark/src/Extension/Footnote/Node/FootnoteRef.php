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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceInterface;
final class FootnoteRef extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline
{
    /** @var ReferenceInterface */
    private $reference;
    /** @var string|null */
    private $content;
    /**
     * @param ReferenceInterface $reference
     * @param string|null        $content
     * @param array<mixed>       $data
     */
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceInterface $reference, ?string $content = null, array $data = [])
    {
        $this->reference = $reference;
        $this->content = $content;
        $this->data = $data;
    }
    public function getReference() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceInterface
    {
        return $this->reference;
    }
    public function setReference(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceInterface $reference) : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteRef
    {
        $this->reference = $reference;
        return $this;
    }
    public function getContent() : ?string
    {
        return $this->content;
    }
}

<?php

/*
 * This file is part of Respect/Stringifier.
 *
 * (c) Henrique Moody <henriquemoody@gmail.com>
 *
 * For the full copyright and license information, please view the "LICENSE.md"
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers;

use ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Quoters\CodeQuoter;
use ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Quoters\StringQuoter;
use ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifier;
/**
 * Converts a value into a string using the defined Stringifiers.
 *
 * @author Henrique Moody <henriquemoody@gmail.com>
 */
final class ClusterStringifier implements \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifier
{
    /**
     * @var Stringifier[]
     */
    private $stringifiers;
    /**
     * Initializes the stringifier.
     *
     * @param Stringifier[] ...$stringifiers
     */
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifier ...$stringifiers)
    {
        $this->setStringifiers($stringifiers);
    }
    /**
     * Create a default instance of the class.
     *
     * This instance includes all possible stringifiers.
     *
     * @return ClusterStringifier
     */
    public static function createDefault() : self
    {
        $quoter = new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Quoters\CodeQuoter();
        $stringifier = new self();
        $stringifier->setStringifiers([new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\TraversableStringifier($stringifier, $quoter), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\DateTimeStringifier($stringifier, $quoter, 'c'), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\ThrowableStringifier($stringifier, $quoter), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\StringableObjectStringifier($stringifier), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\JsonSerializableStringifier($stringifier, $quoter), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\ObjectStringifier($stringifier, $quoter), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\ArrayStringifier($stringifier, $quoter, 3, 5), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\InfiniteStringifier($quoter), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\NanStringifier($quoter), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\ResourceStringifier($quoter), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\BoolStringifier($quoter), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\NullStringifier($quoter), new \ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifiers\JsonParsableStringifier()]);
        return $stringifier;
    }
    /**
     * Set stringifiers.
     *
     * @param array $stringifiers
     *
     * @return void
     */
    public function setStringifiers(array $stringifiers) : void
    {
        $this->stringifiers = [];
        foreach ($stringifiers as $stringifier) {
            $this->addStringifier($stringifier);
        }
    }
    /**
     * Add a stringifier to the chain
     *
     * @param Stringifier $stringifier
     *
     * @return void
     */
    public function addStringifier(\ZOOlanders\YOOessentials\Vendor\Respect\Stringifier\Stringifier $stringifier) : void
    {
        $this->stringifiers[] = $stringifier;
    }
    /**
     * {@inheritdoc}
     */
    public function stringify($value, int $depth) : ?string
    {
        foreach ($this->stringifiers as $stringifier) {
            $string = $stringifier->stringify($value, $depth);
            if (null === $string) {
                continue;
            }
            return $string;
        }
        return null;
    }
}

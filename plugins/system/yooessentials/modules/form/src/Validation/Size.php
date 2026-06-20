<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Validation;

use SplFileInfo;
use YOOtheme\Http\Message\UploadedFile;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ComponentException;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Rules\AbstractRule;

class Size extends AbstractRule
{
    /**
     * @var string|int|null
     */
    private $minSize;

    /**
     * @var float|null
     */
    private $minValue;

    /**
     * @var string|int|null
     */
    private $maxSize;

    /**
     * @var float|null
     */
    private $maxValue;

    /**
     * @param string|int|null $minSize
     * @param string|int|null $maxSize
     */
    public function __construct($minSize = null, $maxSize = null)
    {
        $this->minSize = $minSize;
        $this->minValue = $minSize ? $this->toBytes($minSize) : null;
        $this->maxSize = $maxSize;
        $this->maxValue = $maxSize ? $this->toBytes($maxSize) : null;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($input): bool
    {
        if ($input instanceof UploadedFile) {
            return $this->isValidSize($input->getSize());
        }

        if ($input instanceof SplFileInfo) {
            return $this->isValidSize($input->getSize());
        }

        if (is_string($input)) {
            return $this->isValidSize((int) filesize($input));
        }

        return false;
    }

    /**
     * @param mixed $size
     */
    private function toBytes($size): float
    {
        $value = \ZOOlanders\YOOessentials\Util\File::toBytes($size);

        if (!is_numeric($value)) {
            throw new ComponentException(sprintf('"%s" is not a recognized file size.', (string) $size));
        }

        return $value;
    }

    private function isValidSize(float $size): bool
    {
        if ($this->minValue !== null && $this->maxValue !== null) {
            return $size >= $this->minValue && $size <= $this->maxValue;
        }

        if ($this->minValue !== null) {
            return $size >= $this->minValue;
        }

        return $size <= $this->maxValue;
    }
}

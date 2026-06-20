<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Rss\Type;

use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Source\SourceService;

class RssArrayType implements TypeInterface
{
    use ExtractsFields;

    /** @var string */
    private $prefix;
    /** @var string */
    private $header;
    /** @var array */
    private $data;

    public function __construct(string $header, array $data, string $prefix)
    {
        $this->data = $data;
        $this->header = $header;
        $this->prefix = $prefix;
    }

    public function name(): string
    {
        return SourceService::encodeField($this->prefix . '_' . $this->header);
    }

    public function type(): string
    {
        return TypeInterface::TYPE_OBJECT;
    }

    public function label(): string
    {
        return Str::titleCase($this->header);
    }

    public function config(): array
    {
        $fields = $this->getFields($this->data);

        return [
            'fields' => $fields,
            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],
        ];
    }
}

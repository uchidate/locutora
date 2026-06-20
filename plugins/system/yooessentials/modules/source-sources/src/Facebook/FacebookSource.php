<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Facebook;

use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class FacebookSource extends AbstractSourceType implements SourceInterface
{
    use HasApiRequest;

    public const MEDIA_LIMIT_DEFAULT = 20;

    public function types(): array
    {
        if (!self::api($this->account())) {
            return [];
        }

        return [
            new Type\FacebookPagePersonType(),
            new Type\FacebookPageType(),
            new Type\FacebookPostType(),
            new Type\FacebookPageQueryType($this),
            new Type\FacebookPagePostsQueryType($this),
        ];
    }

    public function account(): ?string
    {
        return $this->config()['account'] ?? null;
    }

    public function pageId(): ?string
    {
        return $this->config()['page_id'] ?? null;
    }
}

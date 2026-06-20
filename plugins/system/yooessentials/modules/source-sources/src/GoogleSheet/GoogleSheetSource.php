<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleSheet;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Api\Google\Sheet\GoogleSheetApi;
use ZOOlanders\YOOessentials\Api\Google\Sheet\GoogleSheetApiInteface;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedData;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class GoogleSheetSource extends AbstractSourceType implements SourceInterface
{
    use CachesResolvedData;

    public const SHEET_COLUMN_START = 'A';
    public const SHEET_COLUMN_END = 'Z';
    public const SHEET_ROW_OFFSET = 0;
    public const SHEET_ROW_LIMIT = 20;

    /** @var string */
    public $account;

    /** @var string */
    public $sheetId;

    /** @var string */
    public $sheetName;

    /** @var string */
    public $startColumn = self::SHEET_COLUMN_START;

    /** @var string */
    public $endColumn = self::SHEET_COLUMN_END;

    /** @var GoogleSheetApi */
    private $api;

    public function bind(array $config): SourceInterface
    {
        parent::bind($config);

        $this->account = $config['account'] ?? null;
        $this->sheetId = $config['sheet_id'] ?? null;
        $this->sheetName = $config['sheet_name'] ?? null;
        $this->startColumn = $config['start_column'] ?? self::SHEET_COLUMN_START;
        $this->endColumn = $config['end_column'] ?? self::SHEET_COLUMN_END;

        return $this;
    }

    public function types(): array
    {
        if (!$this->auth()) {
            return [];
        }

        $objectType = new Type\SheetSourceType($this);
        $queryType = new Type\SheetQuerySourceType($this, $objectType);

        return [
            $objectType,
            $queryType,
        ];
    }

    public static function getCacheKey(): string
    {
        return 'google-sheet-source';
    }

    public function defaultName(): string
    {
        return 'Sheet';
    }

    public function auth(): ?AuthOAuth
    {
        if (!$this->account) {
            throw new \Exception('Auth Account must be specified.');
        }

        return app(AuthManager::class)->auth($this->account);
    }

    public function api(): GoogleSheetApiInteface
    {
        if ($this->api) {
            return $this->api;
        }

        $this->api = app(GoogleSheetApiInteface::class);

        try {
            $this->api->forAccount($this->auth());
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'google-sheet',
                'error' => $e->getMessage()
            ]);
        }

        return $this->api;
    }

    public function headers(): array
    {
        $interval = $this->interval(1, 1);

        $headers = self::resolveFromCache($this, [$interval], function () use ($interval) {
            return $this->api()->headers($this->sheetId, $interval) ?? [];
        });

        if (empty($headers)) {
            throw new \Exception('Missing Spreadsheet headers.');
        }

        return $headers;
    }

    public function sheets(): array
    {
        return array_map(function ($sheet) {
            return $sheet->properties->title;
        }, $this->api()->sheets($this->sheetId));
    }

    public function interval(Int $offset = self::SHEET_ROW_OFFSET, int $limit = self::SHEET_ROW_LIMIT): string
    {
        return "{$this->sheetName}!{$this->startColumn}{$offset}:{$this->endColumn}{$limit}";
    }
}

<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Legacy\FormAction\SaveGoogleSheetLegacy;

use function YOOtheme\app;
use YOOtheme\Event;
use ZOOlanders\YOOessentials\Api\Google\Sheet\GoogleSheetApi;
use ZOOlanders\YOOessentials\Api\Google\Sheet\GoogleSheetApiInteface;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Form\Actions\StandardAction;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;
use ZOOlanders\YOOessentials\Legacy\FormAction\HasColumnConfig;

class SaveGoogleSheetAction extends StandardAction
{
    use HasColumnConfig;

    public const NAME = 'save-google-sheet-legacy';

    protected const VALUE_INPUT_OPTIONS = [
        'INPUT_TYPE_RAW' => GoogleSheetApi::INPUT_TYPE_RAW,
        'INPUT_TYPE_USER_ENTERED' => GoogleSheetApi::INPUT_TYPE_USER_ENTERED
    ];

    /** @var GoogleSheetApiInteface */
    private static $api;

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        $form = $response->submission()->form();
        $config = (object) $this->getConfig();

        $controls = $form->controls();
        $columnsConfig = self::columnsConfig($config, $controls);
        $formData = self::flattenFormData($response->submission()->data());
        $formData = self::fillEmptyKeys($columnsConfig['headers'], $formData);

        $sheet = $config->sheet_name ?? '';
        $sheetId = $config->sheet_id;
        $valueInput = $config->value_input ?? 'INPUT_TYPE_RAW';

        $api = self::api($config);

        if (!$api) {
            Event::emit('yooessentials.error', [
                'addon' => 'form',
                'action' => $this->config,
                'name' => $this->name(),
                'error' => 'Error Initing Google Sheet API'
            ]);

            $response->withErrors([
                'Google Sheet Action Error: Error Initing Google Sheet API'
            ]);

            return $next($response);
        }

        try {
            // map formData with columns order and configuration
            $data = array_reduce($columnsConfig['fields'], function ($carry, $field) use ($formData) {
                return array_merge($carry, [$formData[$field] ?? '']);
            }, []);

            $headers = $columnsConfig['headers'];
            $interval = self::interval($sheet, $headers);

            $params = [
                'valueInputOption' => self::VALUE_INPUT_OPTIONS[$valueInput]
            ];

            // Header
            if (!$api->values($sheetId, $interval)) {
                $api->write($sheetId, $headers, $interval, $params);
            }

            // Row
            $api->append($sheetId, $data, $interval, $params);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'form',
                'action' => $this->config,
                'name' => $this->name(),
                'error' => $e->getMessage() . ' - ' . $e->getTraceAsString()
            ]);

            $response->withErrors([
                'Google Sheet Action Error: ' . $e->getMessage()
            ]);
        }

        return $next($response);
    }

    public static function api(\stdClass $config): ?GoogleSheetApiInteface
    {
        if (self::$api) {
            return self::$api;
        }

        try {
            $auth = app(AuthManager::class)->auth($config->account);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'google-sheet',
                'error' => 'Missing Auth'
            ]);

            return null;
        }

        return self::$api = app(GoogleSheetApiInteface::class)->forAccount($auth);
    }

    protected static function interval(string $sheet, array $headers): string
    {
        $endIntervalColumn = 'A';

        for ($i = 1; $i < count($headers); $i++) {
            $endIntervalColumn = ++$endIntervalColumn;
        }

        return "{$sheet}!A1:{$endIntervalColumn}1";
    }
}

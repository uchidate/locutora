<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Google\Sheet;

use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Vendor\Google\Client;
use ZOOlanders\YOOessentials\Vendor\Google\Service\Drive;
use ZOOlanders\YOOessentials\Vendor\Google\Service\Drive\FileList;
use ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets;
use ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Sheet;
use ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\Spreadsheet;
use ZOOlanders\YOOessentials\Vendor\Google\Service\Sheets\ValueRange;

class GoogleSheetApi implements GoogleSheetApiInteface
{
    /**
     * @see https://developers.google.com/sheets/api/reference/rest/v4/ValueInputOption
     */
    public const INPUT_TYPE_RAW = 'RAW';
    public const INPUT_TYPE_USER_ENTERED = 'USER_ENTERED';

    /** @var Client */
    private $client;

    /** @var Sheets */
    private $sheetsService;

    /** @var Drive */
    private $driveService;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->driveService = new Drive($client);
        $this->sheetsService = new Sheets($client);
    }

    public function __call($name, array $args)
    {
        $method = [$this, $name];

        if (!is_callable($method)) {
            throw new \Exception(sprintf('Call to undefined method %s::%s()', __CLASS__, $name), 500);
        }

        if ($method instanceof \Closure) {
            $method = $method->bindTo($this);
        }

        try {
            return call_user_func_array($method, $args);
        } catch (\Exception $e) {
            $result = json_decode($e->getMessage(), true) ?? [];

            $code = $result['error']['code'] ?? $result['code'] ?? $e->getCode() ?? 400;
            $message = $result['error']['message'] ?? $result['message'] ?? $e->getMessage() ?? 'Unknown Error';

            throw new \Exception($message, $code);
        }
    }

    private function spreadsheet(string $spreadsheetId): ?Spreadsheet
    {
        return $this->sheetsService->spreadsheets->get($spreadsheetId);
    }

    /**
     * @return Sheet[]
     */
    private function sheets(string $spreadsheetId): array
    {
        return $this->sheetsService->spreadsheets->get($spreadsheetId)->getSheets();
    }

    private function listFiles(array $options): ?FileList
    {
        return $this->driveService->files->listFiles($options);
    }

    private function spreadSheetTitle(string $spreadsheetId): ?string
    {
        return $this->sheetsService->spreadsheets->get($spreadsheetId)->getProperties()->getTitle();
    }

    private function values(string $spreadsheetId, string $interval, array $params = []): ?array
    {
        return $this->sheetsService->spreadsheets_values->get($spreadsheetId, $interval, $params)->getValues();
    }

    private function headers(string $spreadsheetId, string $interval): ?array
    {
        $values = $this->values($spreadsheetId, $interval);

        return empty($values) ? [] : array_shift($values);
    }

    private function write(string $spreadsheetId, array $values, string $range, array $params = []): ?array
    {
        $body = new ValueRange([
            'values' => [$values]
        ]);

        $params += ['valueInputOption' => self::INPUT_TYPE_RAW];

        $updatedData = $this->sheetsService->spreadsheets_values->update($spreadsheetId, $range, $body, $params)
            ->getUpdatedData();

        if (!$updatedData) {
            return [];
        }

        return $updatedData->getValues();
    }

    private function append(string $spreadsheetId, array $values, string $range, array $params = []): ?array
    {
        $body = new ValueRange([
            'values' => [$values]
        ]);

        $params += ['valueInputOption' => self::INPUT_TYPE_RAW];

        $updatedData = $this->sheetsService->spreadsheets_values->append($spreadsheetId, $range, $body, $params)
            ->getUpdates();

        if ($updatedData && $updatedData->getUpdatedData()) {
            return $updatedData
                ->getUpdatedData()
                ->getValues();
        }

        return [];
    }

    public function forAccount(AuthOAuth $auth): GoogleSheetApiInteface
    {
        $this->client->setAccessToken([
            'expires_in' => $auth->expiresIn(),
            'access_token' => $auth->accessToken(),
            'refresh_token' => $auth->refreshToken(),
        ]);

        if ($auth->custom()) {
            $this->client->setClientId($auth->clientId());
            $this->client->setClientSecret($auth->clientSecret());
        }

        // there can be 2 clients with different configs, don't cache them together
        $this->client->setCacheConfig([
            'prefix' => 'google-sheets-client-' . sha1($auth->refreshToken())
        ]);

        return $this;
    }
}

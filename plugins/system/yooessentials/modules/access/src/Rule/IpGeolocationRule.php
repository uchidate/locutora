<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Rule;

use YOOtheme\Arr;
use ZOOlanders\YOOessentials\Access\AbstractRule;
use ZOOlanders\YOOessentials\Api\MaxMind\GeoIp;
use ZOOlanders\YOOessentials\Util\Ip as IpUtil;

class IpGeolocationRule extends AbstractRule
{
    /**
     * @var GeoIp
     */
    protected $geoip;

    public function __construct(GeoIp $geoip)
    {
        $this->geoip = $geoip;
    }

    public function docs(): string
    {
        return 'https://zoolanders.com/docs/essentials-for-yootheme-pro/access/rule/ipgeolocation';
    }

    public function group(): string
    {
        return 'device';
    }

    public function name(): string
    {
        return 'IP Geolocation';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_ipgeolocation';
    }

    public function description(): string
    {
        return 'Validates against the device IP location determined by MaxMind GeoIp.';
    }

    public function resolve($props, $node): bool
    {
        $continents = self::parseTextareaList($props->continents ?? '');
        $countries = self::parseTextareaList($props->countries ?? '');
        $cities = self::parseTextareaList($props->cities ?? '');
        $codes = self::parseTextareaList($props->codes ?? '');

        if (!$this->geoip->isReaderReady() || !array_filter(array_merge($countries, $continents, $cities, $codes))) {
            throw new \RuntimeException('Not Valid Evaluation Arguments');
        }

        $ip = IpUtil::getIP();
        $result = [];

        if (($continents || $countries) && $record = $this->geoip->getCountryRecord($ip)) {
            $continentData = $record->continent->jsonSerialize() ?? [];
            $continentData = array_filter([$continentData['code'] ?? null] + array_values($continentData['names'] ?? []));

            $countryData = $record->country->jsonSerialize() ?? [];
            $countryData = array_filter([$countryData['iso_code'] ?? null] + array_values($countryData['names'] ?? []));

            $result['continents'] = $this->resolveEntries($continents, $continentData);
            $result['countries'] = $this->resolveEntries($countries, $countryData);
        }

        if (($cities || $codes) && $record = $this->geoip->getCityRecord($ip)) {
            $cityData = $record->city->jsonSerialize() ?? [];
            $cityData = array_filter([$cityData['name'] ?? null] + array_values($cityData['names'] ?? []));

            $codeData = [$record->postal->code];

            $result['cities'] = $this->resolveEntries($cities, $cityData);
            $result['codes'] = $this->resolveEntries($codes, $codeData);
        }

        return (bool) array_filter($result);
    }

    protected function resolveEntries(array $entries, array $data): bool
    {
        return Arr::some($entries, function ($entry) use ($data) {
            return in_array($entry, $data);
        });
    }

    public function fields(): array
    {
        return [
            'continents' => [
                'label' => 'Continents',
                'type' => 'textarea',
                'source' => true,
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => "South America\nAfrica\nAU"
                ],
                'show' => '$customizer.yooessentials.geoipcountry || $customizer.yooessentials.geoipcity',
                'description' => 'A list of Continents (names or iso codes) that the device IP location must match, international names are supported. Separate the entries with a comma and/or new line.'
            ],
            '_continents' => [
                'label' => 'Continents',
                'type' => 'yooessentials-info',
                'show' => '!($customizer.yooessentials.geoipcountry || $customizer.yooessentials.geoipcity)',
                'description' => 'This feature relies on the GeoIp City or Country Database.'
            ],
            'countries' => [
                'label' => 'Countries',
                'type' => 'textarea',
                'source' => true,
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => "Spain\nItaly\nDE"
                ],
                'show' => '$customizer.yooessentials.geoipcountry || $customizer.yooessentials.geoipcity',
                'description' => 'A list of Countries (names or iso codes) that the device IP location must match, international names are supported. Separate the entries with a comma and/or new line.'
            ],
            '_countries' => [
                'label' => 'Countries',
                'type' => 'yooessentials-info',
                'show' => '!($customizer.yooessentials.geoipcountry || $customizer.yooessentials.geoipcity)',
                'description' => 'This feature relies on the GeoIp City or Country Database.'
            ],
            'cities' => [
                'label' => 'Cities',
                'type' => 'textarea',
                'source' => true,
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => "Barcelona\nVicenza\nDenpasar"
                ],
                'show' => '$customizer.yooessentials.geoipcity',
                'description' => 'A list of Cities that the device IP location must match, international names are supported. Separate the entries with a comma and/or new line.'
            ],
            '_cities' => [
                'label' => 'Cities',
                'type' => 'yooessentials-info',
                'show' => '!$customizer.yooessentials.geoipcity',
                'description' => 'This feature relies on the GeoIp City Database.'
            ],
            'codes' => [
                'label' => 'Postal Codes',
                'type' => 'textarea',
                'source' => true,
                'attrs' => [
                    'rows' => 4,
                    'placeholder' => '55455'
                ],
                'show' => '$customizer.yooessentials.geoipcity',
                'description' => 'A list of Postal Codes that the device IP location must match. Separate the entries with a comma and/or new line.'
            ],
            '_codes' => [
                'label' => 'Postal Codes',
                'type' => 'yooessentials-info',
                'show' => '!$customizer.yooessentials.geoipcity',
                'description' => 'This feature relies on the GeoIp City Database.'
            ],
        ];
    }
}

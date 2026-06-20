<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Google\MyBusiness;

use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Location;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Review;

interface GoogleMyBusinessApiInteface
{
    public function accounts(): array;

    public function locations(string $account): array;

    public function location(string $location): ?Google_Service_MyBusiness_Location;

    public function review(string $review): Google_Service_MyBusiness_Review;

    public function reviews(string $accountLocation, array $options = []): array;

    public function medias(string $accountLocation, array $options = []): array;

    public function totalReviewCount(string $accountLocation): ?int;

    public function averageReviewRating(string $accountLocation): ?float;

    public function processException(\Exception $e): array;

    public function forAccount(AuthOAuth $account): GoogleMyBusinessApiInteface;
}

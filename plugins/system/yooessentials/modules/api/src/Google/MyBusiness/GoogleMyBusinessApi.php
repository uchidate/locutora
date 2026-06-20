<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Api\Google\MyBusiness;

use function YOOtheme\app;
use ZOOlanders\YOOessentials\Api\Google\MyBusiness\Service\BusinessInformationService;
use ZOOlanders\YOOessentials\Auth\AuthOAuth;
use ZOOlanders\YOOessentials\Vendor\Google\Client;
use ZOOlanders\YOOessentials\Vendor\Google\Service\MyBusinessAccountManagement;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Account;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Location;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_LocationReview;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_MediaItem;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Review;

class GoogleMyBusinessApi implements GoogleMyBusinessApiInteface
{
    /** @var AuthOAuth */
    private $account;

    /** @var Client */
    private $client;

    /** @var Google_Service_MyBusiness */
    private $service;

    /** @var BusinessInformationService */
    private $serviceBusiness;

    /** @var MyBusinessAccountManagement */
    private $serviceManagement;

    /**
     * @return Google_Service_MyBusiness_Account[]
     */
    public function accounts(): array
    {
        try {
            return $this->serviceManagement->accounts->listAccounts()->getAccounts();
        } catch (\Exception $e) {
            $this->processException($e);
        }
    }

    /**
     * @return Google_Service_MyBusiness_Location
     */
    public function location(string $location): ?Google_Service_MyBusiness_Location
    {
        try {
            return $this->serviceBusiness->account_location->get($location);
        } catch (\Exception $e) {
            $this->processException($e);
        }
    }

    /**
     * @return Google_Service_MyBusiness_Location[]
     */
    public function locations(string $account): array
    {
        try {
            return $this->serviceBusiness->accounts_locations->listAccountsLocations($account, ['pageSize' => 100])->getLocations();
        } catch (\Exception $e) {
            $this->processException($e);
        }
    }

    /**
     * @return Google_Service_MyBusiness_MediaItem[]
     */
    public function medias(string $accountLocation, array $options = []): array
    {
        try {
            return $this->service->accounts_locations_media->listAccountsLocationsMedia($accountLocation, $options)->getMediaItems();
        } catch (\Exception $e) {
            $this->processException($e);
        }
    }

    public function review(string $review): Google_Service_MyBusiness_Review
    {
        try {
            return $this->service->accounts_locations_reviews->get($review);
        } catch (\Exception $e) {
            $this->processException($e);
        }
    }

    /**
     * @return Google_Service_MyBusiness_LocationReview[]
     */
    public function reviews(string $accountLocation, array $options = []): array
    {
        try {
            return $this->service->accounts_locations_reviews->listAccountsLocationsReviews($accountLocation, $options)->getReviews();
        } catch (\Exception $e) {
            $this->processException($e);
        }
    }

    public function totalReviewCount(string $accountLocation): ?int
    {
        try {
            return $this->service->accounts_locations_reviews->listAccountsLocationsReviews($accountLocation)->getTotalReviewCount();
        } catch (\Exception $e) {
            $this->processException($e);
        }
    }

    public function averageReviewRating(string $accountLocation): ?float
    {
        try {
            return $this->service->accounts_locations_reviews->listAccountsLocationsReviews($accountLocation)->getAverageRating();
        } catch (\Exception $e) {
            $this->processException($e);
        }
    }

    public function forAccount(AuthOAuth $account): GoogleMyBusinessApiInteface
    {
        $this->account = $account;
        $this->init();

        return $this;
    }

    public function processException(\Exception $e): array
    {
        $result = json_decode($e->getMessage(), true) ?? [];

        $code = $result['error']['code'] ?? $e->getCode();
        $message = $result['error']['message'] ?? $result['error'] ?? $e->getMessage();

        if ($message === 'invalid_grant') {
            $message = 'The Authorization grant has expired.';
        }

        throw new \Exception($message, $code);
    }

    protected function init()
    {
        /** @var Client $client */
        $this->client = app(Client::class);

        $this->client->setAccessToken([
            'expires_in' => $this->account->expiresIn(),
            'access_token' => $this->account->accessToken(),
            'refresh_token' => $this->account->refreshToken(),
        ]);

        // there can be 2 clients with different configs, don't cache them together
        $this->client->setCacheConfig([
            'prefix' => 'google-mybusiness-client-' . sha1($this->account->refreshToken())
        ]);

        $this->service = new Google_Service_MyBusiness($this->client);
        $this->serviceManagement = new MyBusinessAccountManagement($this->client);
        $this->serviceBusiness = new BusinessInformationService($this->client);
    }
}

<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleMyBusiness;

use function YOOtheme\app;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use ZOOlanders\YOOessentials\Api\Google\MyBusiness\GoogleMyBusinessApiInteface;
use ZOOlanders\YOOessentials\Auth\AuthManager;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Location as MyBusinessLocation;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusiness_Review;
use ZOOlanders\YOOessentials\Vendor\Google_Service_MyBusinessAccountManagement_Account as MyBusinessAccount;

class GoogleMyBusinessController
{
    use LoadsSourceFromArgs;

    public const PRESAVE_ENDPOINT = 'yooessentials/source/google-mybusiness';
    public const GET_LOCATIONS_ENDPOINT = 'yooessentials/source/google-mybusiness/locations';
    public const GET_ACCOUNTS_ENDPOINT = 'yooessentials/source/google-mybusiness/accounts';
    public const GET_REVIEWS_ENDPOINT = 'yooessentials/source/google-mybusiness/reviews';

    public function presave(Request $request, Response $response)
    {
        $form = $request->getParam('form') ?? [];
        $account = $form['account'] ?? null;
        $location = $form['location'] ?? null;
        $businessAccount = $form['businessAccount'] ?? null;

        if (!$account) {
            return $response->withJson('Account must be specified.', 400);
        }

        if (!$businessAccount) {
            return $response->withJson('Business Account must be specified.', 400);
        }

        if (!$location) {
            return $response->withJson('Location must be specified.', 400);
        }

        return $response->withJson(200);
    }

    public function accounts(Request $request, Response $response)
    {
        $form = $request->getParam('form');

        try {
            $api = $this->initApi($form);
            $accounts = $api->accounts();

            $items = array_map(function (MyBusinessAccount $account) {
                return [
                    'text' => $account->getAccountName(),
                    'value' => $account->getName(),
                    'meta' => $account->getName(),
                ];
            }, $accounts);

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }

    public function locations(Request $request, Response $response)
    {
        $form = $request->getParam('form');
        $api = $this->initApi($form);

        try {
            $locations = $api->locations($form['businessAccount']);
            $items = array_map(function (MyBusinessLocation $location) {
                return [
                    'value' => $location->getName(),
                    'meta' => $location->getName(),
                    'text' => $location->title
                ];
            }, $locations);

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            $error = $api->processException($e);

            if ($error['code'] === 404) {
                return $response->withJson('Not Found. Verify My Bussiness Account input.', 400);
            }

            return $response->withJson($e->getMessage(), 400);
        }
    }

    public function reviews(Request $request, Response $response)
    {
        $source = self::loadSource($request->getParsedBody(), GoogleMyBusinessSource::class);

        try {
            $reviews = $source->api()->reviews($source->businessAccount . '/' . $source->location);

            $items = array_map(function (Google_Service_MyBusiness_Review $review) {
                $updatedAt = new \DateTime($review->getUpdateTime());

                return [
                    'value' => $review->getName(),
                    'text' => $review->getReviewer()->getDisplayName() . ' - ' . $updatedAt->format('jS M y'),
                    'meta' => $review->getName(),
                ];
            }, $reviews);

            return $response->withJson($items, 200);
        } catch (\Exception $e) {
            return $response->withJson($e->getMessage(), 400);
        }
    }

    protected function initApi(array $data): GoogleMyBusinessApiInteface
    {
        $account = $data['account'] ?? null;

        if (!$account) {
            throw new \Exception('Account must be specified.');
        }

        $authManager = app(AuthManager::class);

        $auth = $authManager->auth($account);

        if (!$auth) {
            throw new \Exception('Invalid Auth.');
        }

        return app(GoogleMyBusinessApiInteface::class)->forAccount($auth);
    }
}
